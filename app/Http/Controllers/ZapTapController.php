<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Facades\Services\ZapTapService;

class ZapTapController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        return view('zaptap.index', [
            'zaptaps' => ZapTapService::getZapTapByUserId(Auth::user()->id),
        ]);
    }

    public function create(): View
    {
        return view('zaptap.create');
    }

    public function show($id): View
    {
        return view('zaptap.show',['zaptap'=>ZapTapService::getZapTapById($id)]);
    }

    public function edit($id): View
    {
        $zaptap = ZapTapService::getZapTapById($id);
        foreach($zaptap->alertActions as $alertAction){
            if($alertAction->alert_type == 'email'){
                $emailAction = $alertAction; 
            }
            if($alertAction->alert_type == 'slack'){
                $slackAction = $alertAction; 
            }
        }
        $data_set = [
            'id'=> $zaptap->id,
            'feed_url'=> $zaptap->feed_url,
            'title' => $zaptap->title,
            'interval' => $zaptap->interval,
            'email_address' => isset($emailAction)?$emailAction->recipient_address:'',
            'email_subject' => isset($emailAction)?$emailAction->subject:'',
            'email_body' => isset($emailAction)?json_decode($emailAction->body_items):[],
            'slack_address' => isset($slackAction)?$slackAction->recipient_address:'',
            'slack_subject' => isset($slackAction)?$slackAction->subject:'',
            'slack_body' => isset($slackAction)?json_decode($slackAction->body_items):[],
        ];
        return view('zaptap.edit',['zaptap'=>$data_set]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'feed_url' => 'required|url',
            'title' => 'required|string|max:255',
            'interval' => 'required|integer',
        ]);

        $zaptap = ZapTapService::createZapTap(ZapTapService::setZapTapRequestFormat($request->all()),Auth::user());
        return redirect()->route('dashboard')->with('success', 'ZapTap created successfully!');
    }


  public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'feed_url' => 'required|url',
            'title' => 'required|string|max:255',
            'interval' => 'required|integer',
        ]);

        $zaptap = ZapTapService::updateZapTap(ZapTapService::setZapTapRequestFormat($request->all()),$id);

        return redirect()->route('dashboard')->with('success', 'ZapTap updated successfully!');
    }


    public function destroy($id)
    {
        $zaptap = ZapTapService::deleteZapTap($id);
        return redirect()->route('dashboard')->with('success', 'ZapTap deleted successfully!');
    }


    public function test($id)
    {
        $zaptap = ZapTapService::testZapTap($id);
        return redirect()->route('dashboard')->with('success', 'ZapTap tested successfully!');
    }





}
