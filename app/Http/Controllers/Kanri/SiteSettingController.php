<?php

namespace App\Http\Controllers\Kanri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Http\Requests\SiteSettingRequest;

class SiteSettingController extends Controller
{
    private $siteSetting;
    
    public function __construct(SiteSetting $siteSetting)
    {
        $this->siteSetting = $siteSetting;
    }

    /**
     * Site Setting
     */
    public function index()
    {
        $data = $this->siteSetting->find(1);
        return view('kanri.site-setting.index')->with(compact('data'));
    }

    public function update(SiteSettingRequest $request)
    {
        $input = $request->only([
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_encryption',
            'mail_username',
            'mail_password',
            'channel_id',
            'channel_secret',
            'channel_token',
            'liffId',
            'liffId_waiting',
            'liff_channel_id',
            'yoyaku_url'
        ]);
        $input['yoyaku_url'] = rtrim($input['yoyaku_url'], '/');
        $this->siteSetting->find(1)->update($input);
        session()->flash('message', '更新されました。');
        return redirect()->route('kanri.site-setting');
    }

    /**
     * Yoyaku Setting
     */
    public function yoyaku()
    {
        return view('kanri.site-setting.yoyaku');
    }
}
