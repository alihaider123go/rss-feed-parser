<?php

namespace Services;

use App\Models\PoolingTrigger;
use App\Models\AlertAction;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PoolingTriggerNotification;

class ZapTapService
{

    public function setZapTapRequestFormat($data)
    {
        $data_set = [
            'feed_url' => $data['feed_url'],
            'title' => $data['title'],
            'interval' => $data['interval'],
            'alert_actions' => array_filter([
                isset($data['email_address']) ? [
                    'recipient_address' => $data['email_address'],
                    'subject' => $data['email_subject'],
                    'body_items' => $data['email_body'],
                    'alert_type' => 'email',
                ] : null,
                isset($data['slack_address']) ? [
                    'recipient_address' => $data['slack_address'],
                    'subject' => $data['slack_subject'],
                    'body_items' => $data['slack_body'],
                    'alert_type' => 'slack',
                ] : null,
            ]),
        ];
        return $data_set;
    }

    public function createZapTap($data,$user)
    {
        $poolingTrigger = PoolingTrigger::create([
            'feed_url'=>$data['feed_url'],
            'title'=>$data['title'],
            'interval'=>$data['interval'],
            'user_id'=>$user->id
        ]);

        foreach ($data['alert_actions'] as $key => $alert) {
            AlertAction::create([
                'recipient_address'=>$alert['recipient_address'],
                'subject'=>$alert['subject'],
                'body_items'=>json_encode($alert['body_items']),
                'alert_type'=>$alert['alert_type'],
                'pooling_trigger_id'=>$poolingTrigger->id
            ]);
        }

        return $poolingTrigger;
    }


    public function updateZapTap($data,$id)
    {
        $poolingTrigger = PoolingTrigger::find($id)->update([
            'feed_url'=>$data['feed_url'],
            'title'=>$data['title'],
            'interval'=>$data['interval']
        ]);

        PoolingTrigger::find($id)->alertActions()->delete();

        foreach ($data['alert_actions'] as $key => $alert) {
            AlertAction::create([
                'recipient_address'=>$alert['recipient_address'],
                'subject'=>$alert['subject'],
                'body_items'=>json_encode($alert['body_items']),
                'alert_type'=>$alert['alert_type'],
                'pooling_trigger_id'=>$id
            ]);
        }

        return $poolingTrigger;
    }




    public function getZapTapByUserId($user_id)
    {
        $user = User::find($user_id);
        return $user->poolingTriggers;
    }


    public function getZapTapById($id)
    {
        return PoolingTrigger::find($id);
    }

    public function deleteZapTap($id)
    {
        $poolingTrigger = PoolingTrigger::find($id);
        $poolingTrigger->delete();
        return true;
    }


    public function testZapTap($id)
    {
        $this->sendZapTapAlertActions($id,true);
        return true;
    }
    
    public function parseRssFeed($feed_url){
        $feed = \FeedReader::read($feed_url);
        $data = [];
        foreach ($feed->get_items() as $key => $item) {
            $data[]=[
                'id'=>$this->getIdFromURL($item->get_link()),
                'title'=>$item->get_title(),
                'description'=>$item->get_content(),
                'link'=>$item->get_link(),
            ];
        }
        return $data;
    }


    public function sendZapTapAlertActions($id, $test = false){
        $zaptap = ZapTapService::getZapTapById($id);
        foreach ($zaptap->alertActions as $key => $alertAction) {
            if($alertAction->alert_type == 'email'){
                $email_action = [
                    'to' => $alertAction->recipient_address,
                    'subject' => $alertAction->subject,
                    'body_items' => $alertAction->body_items
                ];
            }
            if($alertAction->alert_type == 'slack'){
                $slack_action = [
                    'to' => $alertAction->recipient_address,
                    'subject' => $alertAction->subject,
                    'body_items' => $alertAction->body_items
                ];
            }
        }

        $feeds = $this->parseRssFeed($zaptap->feed_url);
        if(isset($feeds)){
            if($test){
                if(isset($email_action)){
                    $alertData = [
                        'job_link'=>in_array("link", json_decode($email_action['body_items']))?$feeds[0]['link']:null,
                        'job_title'=>in_array("title", json_decode($email_action['body_items']))?$feeds[0]['title']:null,
                        'job_description'=>in_array("description", json_decode($email_action['body_items']))?$feeds[0]['description']:null,
                        'title'=>$zaptap['title'],
                        'subject'=>$email_action['subject'],
                    ];
                    Notification::route('mail', $email_action['to'])->notify(new PoolingTriggerNotification($alertData));
                }
                return true;
            }
            foreach ($feeds as $key => $feed) {
                if($zaptap->last_updated_job_id != null && $zaptap->last_updated_job_id == $feed['id']){
                    break;
                }
                if(isset($email_action)){
                    $alertData = [
                        'job_link'=>in_array("link", json_decode($email_action['body_items']))?$feed['link']:null,
                        'job_title'=>in_array("title", json_decode($email_action['body_items']))?$feed['title']:null,
                        'job_description'=>in_array("description", json_decode($email_action['body_items']))?$feed['description']:null,
                        'title'=>$zaptap['title'],
                        'subject'=>$email_action['subject'],
                    ];
                    Notification::route('mail', $email_action['to'])->notify(new PoolingTriggerNotification($alertData));
                }
                if(isset($slack_action)){
                    // array_push($alerts,['type'=>'slack','item'=>$item]);
                }

            }
            if(!$test && count($feeds)>0){
                $this->setLastUpdatedJobId($id,$feeds[0]['id']);
            }
        }
        return true;
    }


    public function setLastUpdatedJobId($id,$job_id)
    {
        $poolingTrigger = PoolingTrigger::find($id);
        $poolingTrigger->last_updated_job_id = $job_id;
        $poolingTrigger->save();
        return $poolingTrigger;
    }

    public function getIdFromURL($url = ''){
        $pattern = '/~([a-f0-9]{16})/';
        preg_match($pattern, $url, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return "";
        }
    }

    public function triggerZapTapAlertActions(){
        $zaptaps = PoolingTrigger::all();
        foreach ($zaptaps as $key => $zaptap) {
            $nextCall = \Carbon\Carbon::parse($zaptap->updated_at)->addMinutes($zaptap->interval);
            $now = \Carbon\Carbon::now();
            $diffInMinutes = $now->diffInMinutes($nextCall);
            if ($diffInMinutes < 0) {
                $this->sendZapTapAlertActions($zaptap->id);
            } 
        }
        return true;
    }

}
