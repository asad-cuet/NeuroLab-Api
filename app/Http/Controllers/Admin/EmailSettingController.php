<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Auth;
use DB;
use Mail;

class EmailSettingController extends Controller
{
    function __construct()
     {
          $this->middleware('permission:email-setting-view|email-setting-create|email-setting-update|email-setting-delete', ['only' => ['index']]);
          $this->middleware('permission:email-setting-create', ['only' => ['create', 'store']]);
          $this->middleware('permission:email-setting-update', ['only' => ['edit','update']]);
            $this->middleware('permission:email-setting-delete', ['only' => ['destroy']]);

     }
    public function index()
    {
        $email_setting = Setting::where('is_active', true)->first();
        $credential = '';
        if(!empty($email_setting)){
            $credential = json_decode($email_setting->value);
        }
        return view('admin.general-settings.email_settings.index',compact('email_setting', 'credential'));
    }


    public function store(Request $request)
    {
        $mail_setting = Setting::where('key', $request->driver)->first();
        $mails_config = Setting::where('type', 'mail')->get();
        DB::beginTransaction();
        foreach($mails_config as $config){
            $mail = Setting::find($config->id);
            $mail->is_active = false;
            $mail->save();
        }
        if(!empty($mail_setting)){
            $requestData = request()->all();
            unset($requestData['driver']);
            unset($requestData['_token']);
            $credential = json_encode($requestData);
            $mail_setting->title = 'Email setup for '. $request->driver;
            $mail_setting->key = $request->driver;
            $mail_setting->value = $credential;
            $mail_setting->type = 'mail';
            $mail_setting->is_active = true;
            $mail_setting->save();

            //Set Env
            foreach($requestData as $key => $env){
                setEnv($key, $env);
            }

        }else{
            $requestData = request()->all();
            unset($requestData['driver']);
            unset($requestData['_token']);
            $credential = json_encode($requestData);
            $setting = new Setting();
            $setting->title = 'Email setup for '. $request->driver;
            $setting->key = $request->driver;
            $setting->value = $credential;
            $setting->type = 'mail';
            $setting->is_active = true;
            $setting->save();

            //Set Env
            foreach($requestData as $key => $env){
                setEnv($key, $env);
            }
        }
        DB::commit();

        return redirect()->back()
        ->with('success','Email setup successfully!');
    }

    public function ajaxFilter(Request $request)
    {
        $email_setting = Setting::where('key', $request->driver)->first();
        $credential = '';
        if(!empty($email_setting)){
            $credential = json_decode($email_setting->value);
        }
        return response()->json($credential);
    }

    public function emailSend(Request $request)
    {

        // if (config('mail.driver', 'smtp')) {
        //     return "Okk";
        // } else {
        //     return "Not Okk";
        // }
        // \Artisan::call('config:clear');
        // $config = app()->make('config');
        // $emailSettings = \DB::table('settings')->where('type', 'mail')->where('is_active', true)->first();
        // $config->set('mail.host', $emailSettings->host ?? '');
        //         $config->set('mail.port', $emailSettings->port ?? '');
        //         $config->set('mail.username', $emailSettings->username ?? '');
        //         $config->set('mail.password', $emailSettings->password ?? '');
        //         $config->set('mail.encryption', $emailSettings->encryption ?? '');
        // \Artisan::call('config:cache');
        $details = [
            'title' => $request->subject,
            'body' => $request->message,
            ];
        Mail::to($request->email)->send(new \App\Mail\TestMail($details));

        return redirect()->back()
            ->with('Success', 'Mail Sent Successfully');
    }
}
