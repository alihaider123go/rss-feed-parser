<?php

namespace App\Console\Commands;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\Models\User;
use Facades\Services\ZapTapService;
use App\Notifications\PoolingTriggerNotification;

use Illuminate\Support\Facades\Notification;

class ZapTapTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // $result = ZapTapService::triggerZapTapAlertActions();
        // dd($result);


        $zaptap = ZapTapService::testZapTap(1);
        dd($zaptap);

        $zaptap = ZapTapService::getZapTapById(1);
        $feed = ZapTapService::parseRssFeed($zaptap->feed_url);
        dd($feed);

        foreach ($zaptap->alertActions as $key => $alertAction) {
            if($alertAction->alert_type == 'email'){
                $email_action = [
                    'to' => $alertAction->recipient_address,
                    'subject' => $alertAction->subject,
                    'body_items' => $alertAction->items
                ];
            }
            if($alertAction->alert_type == 'slack'){
                $slack_action = [
                    'to' => $alertAction->recipient_address,
                    'subject' => $alertAction->subject,
                    'body_items' => $alertAction->items
                ];
            }
        }
        


        $data = [
            [
                'link'=>'https://getbootstrap.com/docs/5.2/components/badge/',
                'title'=>'Hello Title 1!',
                'description'=>'Hello Description 1!'
            ]
        ];

        foreach ($data as $key => $item) {
            if(isset($email_action)){
                $alertData = [
                    'job_link'=>$item['link'],
                    'job_title'=>$item['title'],
                    'job_description'=>$item['description'],
                    'title'=>$zaptap['title'],
                    'subject'=>$email_action['subject'],
                ];
                Notification::route('mail', $email_action['to'])->notify(new PoolingTriggerNotification($alertData));
            }
            if(isset($slack_action)){
                // array_push($alerts,['type'=>'slack','item'=>$item]);
            }

        }

        dd($alertData);


        Notification::route('mail', 'accesstoalihaider@gmail.com')
            ->route('slack', 'https://hooks.slack.com/services/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')
            ->notify(new PoolingTriggerNotification(ZapTapService::getZapTapById(3)));



        // Notification::route('slack', 'https://hooks.slack.com/services/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')
        //     ->notify(new PoolingTriggerNotification());





        // $user = User::find(1);    
        // $user->notify(new PoolingTriggerNotification());


        dd(200);    


        // $zaptap = ZapTapService::getZapTapByUserId(1);
        // dd($zaptap[0]->alertActions);


        $request = new Request([
            'feed_url'=> 'www.google.com',
            'title' => 'Ali Test 1',
            'interval' => 4,
            // 'email_address' => 'alihaider123go@gmail.com',
            'email_subject' => 'Upwork test alert',
            'email_body' => ['link','title','description'],
            'slack_address' => 'alihaider123go@gmail.com',
            'slack_subject' => 'Upwork test alert',
            'slack_body' => ['link','title','description']
        ]);

        $data_set = ZapTapService::setZapTapRequestFormat($request->all());
        dd($data_set);
        // $data_set = [
        //     'feed_url'=>$request->get('feed_url'),
        //     'title'=>$request->get('title'),
        //     'interval'=>$request->get('interval'),
        //     'alert_actions'=>[
        //         [
        //             'recipient_address'=>$request->get('email_address'),
        //             'subject'=>$request->get('email_subject'),
        //             'body_items'=>$request->get('email_body'),
        //             'alert_type'=>'email',
        //         ],
        //         [
        //             'recipient_address'=>$request->get('slack_address'),
        //             'subject'=>$request->get('slack_address'),
        //             'body_items'=>$request->get('email_body'),
        //             'alert_type'=>'slack',
        //         ]
        //     ],

        // ];

        $zaptap = ZapTapService::createZapTap($data_set,$user);
        dd($zaptap);

    }
}
