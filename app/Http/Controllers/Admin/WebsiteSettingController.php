<?php


namespace App\Http\Controllers\Admin;

use App\Classes\SelfCoder\FileManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Models\FooterSetting;
use DB;
use Auth;
use \stdClass;


class WebsiteSettingController extends Controller
{
     /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     function __construct()
     {
          $this->middleware('permission:website-setting-view|website-setting-create|website-setting-update|website-setting-delete', ['only' => ['index']]);
          $this->middleware('permission:website-setting-create', ['only' => ['create', 'store']]);
          $this->middleware('permission:website-setting-update', ['only' => ['edit','update']]);
          $this->middleware('permission:website-setting-delete', ['only' => ['destroy']]);

          $this->language = languageArray();

          $this->time_zone = timeZoneArray();
     }

     /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function index(Request $request)
     {
          $settings=WebsiteSetting::pluck('value','key');



          $arr=[
               'data'=>$settings,
          ];

          return view('admin.website-settings.index',$arr);
     }


     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
     }


     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request,$id)
     {
          $validate_rules=[
               'title'=>'required',
               'email'=>'required',
               'phone'=>'required',
               'address'=>'required',
               'meta_title'=>'required',
               'meta_description'=>'required',
               'company_name'=>'required',
               'company_email'=>'required',
               'company_language'=>'required',
               'company_time_zone'=>'required',
          ];
          $this->validate($request,$validate_rules);
          
          
          if($request->hasfile('light_logo'))
          {
               $image_response=FileManager::saveFile(
                    $request->file('light_logo'),
                    'storage/General-Settings',
                    ['png','jpg','jpeg','gif']
                );

               if(isset($image_response['result']) && !$image_response['result'])
               {
                    return back()->with('warning',$image_response['message']);
               }


               $setting=WebsiteSetting::where('key','light_logo')->first();
               $old_logo=$setting->value;
               FileManager::deleteFile($old_logo); 

               $setting->value=$image_response['filename'];
               $setting->save();
          }
          
          if($request->hasfile('dark_logo'))
          {
               $image_response=FileManager::saveFile(
                    $request->file('dark_logo'),
                    'storage/General-Settings',
                    ['png','jpg','jpeg','gif']
                );

               if(isset($image_response['result']) && !$image_response['result'])
               {
                    return back()->with('warning',$image_response['message']);
               }


               $setting=WebsiteSetting::where('key','dark_logo')->first();
               $old_logo=$setting->value;
               FileManager::deleteFile($old_logo); 

               $setting->value=$image_response['filename'];
               $setting->save();
          }

          if($request->hasfile('favicon'))
          {
               $image_response=FileManager::saveFile(
                    $request->file('favicon'),
                    'storage/General-Settings',
                    ['png','jpg','jpeg','gif']
                );

               if(isset($image_response['result']) && !$image_response['result'])
               {
                    return back()->with('warning',$image_response['message']);
               }

               $setting=WebsiteSetting::where('key','favicon')->first();  
               $old_favicon=$setting->value;
               FileManager::deleteFile($old_favicon); 

               $setting->value=$image_response['filename'];
               $setting->save();
          }
          

          
          $new_data=[];
          $new_data['title']=$request->title;
          $new_data['meta_title']=$request->meta_title;
          $new_data['meta_description']=$request->meta_description;
          $new_data['email']=$request->email;
          $new_data['phone']=$request->phone;
          $new_data['address']=$request->address;


          $new_data['company_name']=$request->company_name;
          $new_data['company_email']=$request->company_email;
          $new_data['company_language']=$request->company_language;
          $new_data['company_time_zone']=$request->company_time_zone;
          
          
          foreach($new_data as $key=>$value)
          {
               $setting=WebsiteSetting::where('key',$key)->first();  
               if(!$setting)
               {
                    $setting=new WebsiteSetting;  
                    $setting->key=$key;  

               }
               $setting->value=$value;
               $setting->save();
          }
          
          return back()->with('status',"Updated Successfully");
     }
     public function companyInfoUpdate(Request $request)
     {
          $validate_rules=[
               'company_name'=>'required',
               'company_email'=>'required',
               'company_language'=>'required',
               'company_time_zone'=>'required',
          ];
          $this->validate($request,$validate_rules);
          

          

          
          $new_data=[];
          $new_data['company_name']=$request->company_name;
          $new_data['company_email']=$request->company_email;
          $new_data['company_language']=$request->company_language;
          $new_data['company_time_zone']=$request->company_time_zone;
          
          
          foreach($new_data as $key=>$value)
          {
               $setting=WebsiteSetting::where('key',$key)->first();  
               if(!$setting)
               {
                    $setting=new WebsiteSetting; 
                    $setting->root='comapny_info';  
                    $setting->root_title='Company Info';
                    $setting->key=$key;  

               }
               $setting->value=$value;
               $setting->save();
          }
          
          return back()->with('status',"Updated Successfully");
     }
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
          //
     }


     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
     }


     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */


     public function policyUpdate(Request $request)
     {
          $new_data=[];
          $new_data['about_us']=$request->about_us;
          $new_data['privacy_policy']=$request->privacy_policy;
          $new_data['copyright_policy']=$request->copyright_policy;


          foreach($new_data as $key=>$value)
          {
               $setting=WebsiteSetting::where('key',$key)->first();  
               if(!$setting)
               {
                    $setting=new WebsiteSetting;  
                    $setting->root='policy';  
                    $setting->root_title='Policy Setting';
                    $setting->key=$key;  

               }
               $setting->value=$value;
               $setting->save();
          }

          return back()->with('success',"Updated Successfully");
     }

     public function themeUpdate(Request $request)
     {
          $new_data=[];
          $new_data['sidebar_theme']=$request->sidebar_theme;


          foreach($new_data as $key=>$value)
          {
               $setting=WebsiteSetting::where('key',$key)->first();  
               if(!$setting)
               {
                    $setting=new WebsiteSetting;  
                    $setting->root='theme';  
                    $setting->root_title='Theme Setting';  
                    $setting->key=$key;  

               }
               $setting->value=$value;
               $setting->save();
          }

          return back()->with('success',"Updated Successfully");
     }
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
     }
}
