<?php

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Setting;
use App\Mail\DynamicEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

function PermissionsByRole($role_id)
{
    $permissions = DB::table('role_has_permissions')->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')->select('permissions.name')->where('role_has_permissions.role_id', $role_id)->get()->toArray();
    return $permissions;
}

function Roles()
{
    return \Spatie\Permission\Models\Role::orderby('id', 'DESC')->get();
}


function ArrayToColumns($model, $ids, $column_index)
{
    return $model_values =  app($model)->select('id', $column_index)->whereIn('id', $ids)->get();
}



function activeModelData($model_name,$order_by='id',$sort_type='DESC')
{
    return app($model_name)->where('is_active', 1)->orderby($order_by, $sort_type)->get();
}


function mapActivityOld($activity)
{
    $mapped = collect($activity)->map(function ($item, $key) {
        //defining some variable
        $causer_id = $item['causer_id'];

        $item['link_title']='';
        $item['link']='';




        //getting causer Model
        $causer_model = $item['causer_type'];
        //getting subject Model
        $subject_model = $item['subject_type'];

        //getting causer details
        $causer_details = app($causer_model)->where('id', $item['causer_id'])->first();

        $causer_name = '';

        if ($causer_details != null) {
            $causer_name = $causer_details->name;
        }

        $subject_name = 'Unknown';


        if(class_exists($subject_model)){

            //getting subject details
            $subject_details = app($subject_model)->where('id', $item['subject_id'])->first();

            if ($subject_details != null) {
                if ($subject_model == 'App\Models\Setting') {
                    $subject_name = $subject_details->title;
                } else if ($subject_model == 'App\Models\AdminProfileSetting') {
                    $subject_name = '';
                } else {
                    $subject_name = $subject_details->name;
                }
            }

        }


        //making details
        $subject_model = explode('Models', $subject_model);
        $subject_model = stripslashes($subject_model[1]);


        if ($item['event'] == 'created') 
        {
            $item['class'] = 'text-success';
            $details = "New $subject_model created as <span class='fw-semibold'>$subject_name</span> by <a href='/admin/admins/$causer_id' class='text-btn text-primary fw-semibold'>$causer_name</a>";
        }
        
        if ($item['event'] == 'updated') 
        {
            $item['class'] = 'text-warning';
            $details = '';
            if ($item['subject_id'] > 0) 
            {
                $details = $subject_model;
                if($subject_name!=''){$details .= " <span class='fw-semibold'>$subject_name's</span> data"; }
                $details .= " updated by <a href='/admin/admins/$causer_id' class='text-btn text-primary fw-semibold'>$causer_name</a>";
            } else 
            {
                $details = "$subject_model updated by <a href='/admin/admins/$causer_id' class='text-btn text-primary fw-semibold'>$causer_name</a>";
            }
        }
        
        if ($item['event'] == 'deleted') 
        {
            $item['class'] = 'text-danger';
            $subject_name = isset($item['properties']['old']['name'])? $item['properties']['old']['name']:'Unknown';
            $details = "$subject_model <span class='fw-semibold'>$subject_name</span> deleted by <a href='/admin/admins/$causer_id' class='text-btn text-primary fw-semibold'>$causer_name</a>";
        }
        
        
        

        


        return [
            'details' => $details,
            'class' => $item['class'],
            'updated_at' => date('jS M, Y h:i', strtotime($item['updated_at'])),
            'link' => $item['link'],
            'link_title' => $item['link_title'],

        ];
    });
    return $mapped;
}

function mapActivity($activity)
{
    $mapped = collect($activity)->map(function ($item, $key) {
        $causer_id = $item['causer_id'];
        $item['link_title'] = '';
        $item['link'] = '';

        $causer_model = $item['causer_type'];
        $subject_model = $item['subject_type'];
        $causer_details = app($causer_model)->where('id', $causer_id)->first();

        $causer_name = $causer_details->name ?? 'Unknown';

        $subject_name = 'Unknown';
        if (class_exists($subject_model)) {
            $subject_details = app($subject_model)->where('id', $item['subject_id'])->first();
            if ($subject_details) {
                $subject_name = match ($subject_model) {
                    'App\Models\Setting' => $subject_details->title,
                    'App\Models\AdminProfileSetting' => '',
                    default => $subject_details->name,
                };
            }
        }

        $subject_model = explode('Models', $subject_model);
        $subject_model = stripslashes($subject_model[1] ?? 'Unknown');

        $details = '';
        $class = '';
        $icon_class = '';

        switch ($item['event']) {
            case 'created':
                $class = 'timeline__icon--green';
                $details = "New $subject_model created as <span class='timeline__highlight'>$subject_name</span> by <a href='/admin/admins/$causer_id' class='timeline__link'>$causer_name</a>";
                break;
            case 'updated':
                $class = 'timeline__icon--orange';
                $details = "$subject_model <span class='timeline__highlight'>$subject_name's</span> data updated by <a href='/admin/admins/$causer_id' class='timeline__link'>$causer_name</a>";
                break;
            case 'deleted':
                $class = 'timeline__icon--red';
                $subject_name = $item['properties']['old']['name'] ?? 'Unknown';
                $details = "$subject_model <span class='timeline__highlight'>$subject_name</span> deleted by <a href='/admin/admins/$causer_id' class='timeline__link'>$causer_name</a>";
                break;
            default:
                $class = 'timeline__icon--blue';
                $details = "Unknown event for $subject_model by <a href='/admin/admins/$causer_id' class='timeline__link'>$causer_name</a>";
        }

        return [
            'updated_at' => date('h:i A • j M, Y', strtotime($item['updated_at'])),
            'details' => $details,
            'icon_class' => $class,
        ];
    });

    return $mapped;
}



function getSetting($key, $default = null, $lang = false)
{
    $settings = Setting::all();

    $setting = $settings->where('key', $key)->first();
    
    return $setting == null ? $default : $setting->value;
}

function sendEmail($email,$email_data) {

    $mail=DB::table('email_settings')->first();
    $config = array(
            'driver' => $mail->driver,
            'host' => $mail->host,
            'port' => $mail->port,
            'from' => array('address' => $mail->from_address, 'name' => $mail->from_name),
            'encryption' => $mail->encryption,
            'username' => $mail->username,
            'password' => $mail->password,
            'sendmail' => '/usr/sbin/sendmail -bs',
            'pretend' => False
        );
    Config::set('mail',$config);


    $toEmail    =   $email;
    $data       =   array(
        "subject"    =>   isset($email_data['subject'])? $email_data['subject']:Null,
        "head"    =>   isset($email_data['head'])? $email_data['head']:Null,
        "greeting"    =>   isset($email_data['greeting'])? $email_data['greeting']:Null,
        "body"    =>   isset($email_data['body'])? $email_data['body']:Null,
        "button_url"    =>   isset($email_data['button_url'])? $email_data['button_url']:Null,
        "button_title"    =>   isset($email_data['button_title'])? $email_data['button_title']:Null,
        "footer"    =>   isset($email_data['footer'])? $email_data['footer']:Null
    );

    // pass dynamic message to mail class
    Mail::to($toEmail)->send(new DynamicEmail($data));

    if(Mail::failures() != 0) {
        return True;
    }

    else {
        return False;
    }
}

function baseURL()
{
    return URL::to('');
}



function setEnv($name, $value)
{
    $path = base_path('.env');

    $old = env($name);

    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            "$name=".$old, "$name=".$value, file_get_contents($path)
        ));
    }
}


function ModelDataDesc($model_name)
{
    return app($model_name)->orderby('id', 'DESC')->get();
}

function ModelColumnById($model_name,$column,$id)
{
    return app($model_name)->find($id)?->$column;
}

function avatarUrl()
{
    return "assets/images/avatar/avatar.png";
}


function isNull($val)
{
    if(is_array($val))
    {
        if(empty($val))
        {
            return 0;
        }
    }
    else
    {
        $val=str_replace(' ', '', $val);
        if(trim($val=='' || $val==null))
        {
            return 1;
        }
    
        return 0;
    }

}

function AuthResponse($token,$user,$message)
{
    return response()->json([
        'result' => true,
        'data'=>[
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' =>$message,
            'user_id' => $user->id
        ]
    ], 201);
}

function apiResponse($result,$message,$data=null,$code=200)
{
    return response()->json([
        'result' => $result,
        'message' => $message,
        'data' => $data
    ],$code);
}

function keywordBaseSearch($searh_key,$columns_array,$model_query)
{
    $terms = explode(" ", $searh_key);
    if(count($terms)==0)
    {
        $terms = [$searh_key];
    }
    
    if(count($terms)>0)
    {
        foreach ($terms as $key=>$term) 
        {
            $model_query = $model_query->where(function ($query) use ($term,$columns_array)
            {
                $search_columns = $columns_array;
                foreach ($search_columns as $column) 
                {
                        $query->orWhere($column, 'like', '%'.$term.'%');
                }
            });
        }
    }

    

    return $model_query;
}

function showRoleName($user)
{
    $roles=$user->getRoleNames();
    $roles=json_decode($roles);
    $roles=implode(', ',$roles);

    return $roles;
}

function currentLangFlag()
{
    $root='assets/images/flags/';
    $current_lang=session('locale');
    if($current_lang)
    {
        return $root.$current_lang.'.svg';
    }
    return $root.'en.svg';
}

function CutString($text, $maxchar, $end = '...')
{



    if ($maxchar <= 0) {

        $output = $text;
    } elseif (strlen($text) > $maxchar) {
        $words = preg_split('/\s/', $text);
        // return dd($text);
        $output = '';
        $i = 0;
        while (1) {
            $length = strlen($output) + strlen($words[$i]);

            if ($length > $maxchar) {
                if ($i > 0) {
                    break;
                } else {
                    $output = substr($words[$i], 0, $maxchar);
                    break;
                }
            } else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } else {
        $output = $text;
    }

    return $output;
}


function renderCKEditorScript($id)
{
    $text="<script>
        document.addEventListener('DOMContentLoaded', (event) => {
            ClassicEditor
            .create(document.querySelector('#".$id."'))
            .catch(error => {
                console.error(error);
            });
        });
    </script>";
    return $text;
}

function renderCKEditorHtml($column,$isRequired=0,$value='')
{
    $text='<textarea type="text" name="'.$column.'" id="'.$column.'"
        class="ckeditor"';
    if($isRequired)
    {
        $text.='required';
    }
    $text.=' >
        '.$value.'
    </textarea>';
    return $text;
}


function getYearArray($from,$to=0)
{

    if(!$to)
    {
        $year_to = Carbon::now()->year;
    }
    else
    {
        $year_to = $to;
    }

    $array=[];
    for($i=$from; $i<=$year_to;$i++)
    {
        $array[]=$i;
    }

    return $array;
}


function languageArray()
{
    $language = [
        ' Select Language...',
        'Bahasa Indonesia - Indonesian',
        'Bahasa Melayu - Malay',
        'Català - Catalan',
        'Čeština - Czech',
        'Dansk - Danish',
        'Deutsch - German',
        'English',
        'English UK - British English',
        'Español - Spanish',
        'Euskara - Basque (beta)',
        'Filipino',
        'Français - French',
        'Gaeilge - Irish (beta)',
        'Galego - Galician (beta)',
        'Hrvatski - Croatian',
        'Italiano - Italian',
        'Magyar - Hungarian',
        'Nederlands - Dutch',
        'Norsk - Norwegian',
        'Polski - Polish',
        'Português - Portuguese',
        'Română - Romanian',
        'Slovenčina - Slovak',
        'Suomi - Finnish',
        'Svenska - Swedish',
        'Tiếng Việt - Vietnamese',
        'Türkçe - Turkish',
        'Ελληνικά - Greek',
        'Български език - Bulgarian',
        'Русский - Russian',
        'Српски - Serbian',
        'Українська мова - Ukrainian',
        'עִבְרִית - Hebrew',
        'اردو - Urdu (beta)',
        'العربية - Arabic',
        'فارسی - Persian',
        'मराठी - Marathi',
        'हिन्दी - Hindi',
        'বাংলা - Bangla',
        'ગુજરાતી - Gujarati',
        'தமிழ் - Tamil',
        'ಕನ್ನಡ - Kannada',
        'ภาษาไทย - Thai',
        '한국어 - Korean',
        '日本語 - Japanese',
        '简体中文 - Simplified Chinese',
        '繁體中文 - Traditional Chinese'
   ];
   return $language;
}

function timeZoneArray()
{
    $time_zone = [
        '(GMT-11:00) International Date Line West',
        '(GMT-11:00) Midway Island',
        '(GMT-11:00) Samoa',
        '(GMT-10:00) Hawaii',
        '(GMT-08:00) Alaska',
        '(GMT-07:00) Pacific Time (US &amp; Canada)',
        '(GMT-07:00) Tijuana',
        '(GMT-07:00) Arizona',
        '(GMT-06:00) Mountain Time (US &amp; Canada)',
        '(GMT-06:00) Chihuahua',
        '(GMT-06:00) Mazatlan',
        '(GMT-06:00) Saskatchewan',
        '(GMT-06:00) Central America',
        '(GMT-05:00) Central Time (US &amp; Canada)',
        '(GMT-05:00) Guadalajara',
        '(GMT-05:00) Mexico City',
        '(GMT-05:00) Monterrey',
        '(GMT-05:00) Bogota',
        '(GMT-05:00) Lima',
        '(GMT-05:00) Quito',
        '(GMT-04:00) Eastern Time (US &amp; Canada)',
        '(GMT-04:00) Indiana (East)',
        '(GMT-04:00) Caracas',
        '(GMT-04:00) La Paz',
        '(GMT-04:00) Georgetown',
        '(Canad (GMT-03:00) Atlantic Time (Canada)',
        '(GMT-03:00) Santiago',
        '(GMT-03:00) Brasilia',
        '(GMT-03:00) Buenos Aires',
        '(GMT-02:30) Newfoundland',
        '(GMT-02:00) Greenland',
        '(GMT-02:00) Mid-Atlantic',
        '(GMT-01:00) Cape Verde Is.',
        '(GMT) Azores',
        '(GMT) Monrovia',
        '(GMT) UTC',
        '(GMT+01:00) Dublin',
        '(GMT+01:00) Edinburgh',
        '(GMT+01:00) Lisbon',
        '(GMT+01:00) London',
        '(GMT+01:00) Casablanca',
        '(GMT+01:00) West Central Africa',
        '(GMT+02:00) Belgrade',
        '(GMT+02:00) Bratislava',
        '(GMT+02:00) Budapest',
        '(GMT+02:00) Ljubljana',
        '(GMT+02:00) Prague',
        '(GMT+02:00) Sarajevo',
        '(GMT+02:00) Skopje',
        '(GMT+02:00) Warsaw',
        '(GMT+02:00) Zagreb',
        '(GMT+02:00) Brussels',
        '(GMT+02:00) Copenhagen',
        '(GMT+02:00) Madrid',
        '(GMT+02:00) Paris',
        '(GMT+02:00) Amsterdam',
        '(GMT+02:00) Berlin',
        '(GMT+02:00) Bern',
        '(GMT+02:00) Rome',
        '(GMT+02:00) Stockholm',
        '(GMT+02:00) Vienna',
        '(GMT+02:00) Cairo',
        '(GMT+02:00) Harare',
        '(GMT+02:00) Pretoria',
        '(GMT+03:00) Bucharest',
        '(GMT+03:00) Helsinki',
        '(GMT+03:00) Kiev',
        '(GMT+03:00) Kyiv',
        '(GMT+03:00) Riga',
        '(GMT+03:00) Sofia',
        '(GMT+03:00) Tallinn',
        '(GMT+03:00) Vilnius',
        '(GMT+03:00) Athens',
        '(GMT+03:00) Istanbul',
        '(GMT+03:00) Minsk',
        '(GMT+03:00) Jerusalem',
        '(GMT+03:00) Moscow',
        '(GMT+03:00) St. Petersburg',
        '(GMT+03:00) Volgograd',
        '(GMT+03:00) Kuwait',
        '(GMT+03:00) Riyadh',
        '(GMT+03:00) Nairobi',
        '(GMT+03:00) Baghdad',
        '(GMT+04:00) Abu Dhabi',
        '(GMT+04:00) Muscat',
        '(GMT+04:00) Baku',
        '(GMT+04:00) Tbilisi',
        '(GMT+04:00) Yerevan',
        '(GMT+04:30) Tehran',
        '(GMT+04:30) Kabul',
        '(GMT+05:00) Ekaterinburg',
        '(GMT+05:00) Islamabad',
        '(GMT+05:00) Karachi',
        '(GMT+05:00) Tashkent',
        '(GMT+05:30) Chennai',
        '(GMT+05:30) Kolkata',
        '(GMT+05:30) Mumbai',
        '(GMT+05:30) New Delhi',
        '(GMT+05:30) Sri Jayawardenepura',
        '(GMT+05:45) Kathmandu',
        '(GMT+06:00) Astana',
        '(GMT+06:00) Dhaka',
        '(GMT+06:00) Almaty',
        '(GMT+06:00) Urumqi',
        '(GMT+06:30) Rangoon',
        '(GMT+07:00) Novosibirsk',
        '(GMT+07:00) Bangkok',
        '(GMT+07:00) Hanoi',
        '(GMT+07:00) Jakarta',
        '(GMT+07:00) Krasnoyarsk',
        '(GMT+08:00) Beijing',
        '(GMT+08:00) Chongqing',
        '(GMT+08:00) Hong Kong',
        '(GMT+08:00) Kuala Lumpur',
        '(GMT+08:00) Singapore',
        '(GMT+08:00) Taipei',
        '(GMT+08:00) Perth',
        '(GMT+08:00) Irkutsk',
        '(GMT+08:00) Ulaan Bataar',
        '(GMT+09:00) Seoul',
        '(GMT+09:00) Osaka',
        '(GMT+09:00) Sapporo',
        '(GMT+09:00) Tokyo',
        '(GMT+09:00) Yakutsk',
        '(GMT+09:30) Darwin',
        '(GMT+09:30) Adelaide',
        '(GMT+10:00) Canberra',
        '(GMT+10:00) Melbourne',
        '(GMT+10:00) Sydney',
        '(GMT+10:00) Brisbane',
        '(GMT+10:00) Hobart',
        '(GMT+10:00) Vladivostok',
        '(GMT+10:00) Guam',
        '(GMT+10:00) Port Moresby',
        '(GMT+10:00) Solomon Is.',
        '(GMT+11:00) Magadan',
        '(GMT+11:00) New Caledonia',
        '(GMT+12:00) Fiji',
        '(GMT+12:00) Kamchatka',
        '(GMT+12:00) Marshall Is.',
        '(GMT+12:00) Auckland',
        '(GMT+12:00) Wellington',
        '(GMT+13:00) Nukualofa'
   ];

   return $time_zone;
}

function myNotifications()
{
    $notifications=\App\Models\AdminNotification::where('admin_id',auth()->id());

    $unseen_count=$notifications->where('is_seen','!=',1)->count();

    $all=$notifications->orderBy('is_seen','desc')
    ->orderBy('created_at','desc')
    ->take(10)
    ->get();


    return [
        'unseen_count'=>$unseen_count,
        'all'=>$all
    ];
}

function pushAdminNotify($admin_id)
{
    $data=[];
    event(new \App\Events\AdminNotification($data,$admin_id));
}

function filesAsset($files)
{
    $prepared_files=[];
    if($files && is_iterable($files))
    {
        foreach($files as $file)
        {
            $prepared_files[]=asset($file);
        }
    }
    return $prepared_files;
}

function loginUsingUser($user, $res_message)
{

    $token = $user->createToken('authToken')->plainTextToken;


    if(env('USER_ONE_DEVICE_LOGIN'))
    {
        $currentToken = $user->tokens->last();
    
        $user->tokens->except($currentToken->id)->each(function ($token) {
            $token->delete();
        });

        DB::table('sessions')
        ->where('user_id', $user->getAuthIdentifier())
        ->delete();
    }

    return response()->json([
        'result' => true,
        'message' => $res_message,
        'data' => [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'user_id' => $user->id
        ]
    ], 200);
}


function singleSms($msisdn, $messageBody, $csmsId)
{
    // $msisdn -> phone
    // $messageBody -> message
    // $csmsId -> an unique id

    $params = [
        "api_token" => env('SSL_SMS_API_TOKEN'),
        "sid" => env('SSL_SMS_SID'),
        "msisdn" => $msisdn,
        "sms" => $messageBody,
        "csms_id" => $csmsId
    ];

    Log::channel('sms')->info("SMS Request phone: ".$msisdn);

    // https://smsplus.sslwireless.com/api/v3/send-sms
    $url = trim('https://smsplus.sslwireless.com', '/')."/api/v3/send-sms";
    $params = json_encode($params);

    return callApi($url, $params);
}


function callApi($url, $params)
{
    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($params),
        'accept:application/json'
    ));

    $response = curl_exec($ch);

    curl_close($ch);

    Log::channel('sms')->info("Sms Response: ".$response);

    return $response;
}


function sendSSLSMS($phone, $text)
{

    if(gettype($phone)!='string')
    {
        $phone = (string) $phone;
    }
    $msisdn=$phone;
    $messageBody=$text;
    $csmsId=uniqid();

    // return 1;
    $data=json_decode(singleSms($msisdn, $messageBody, $csmsId));

    return $data;


    //Response Demo: {"status":"SUCCESS","status_code":200,"error_message":"","smsinfo":[{"sms_status":"SUCCESS","status_message":"Success","msisdn":"8801781856861","sms_type":"EN","sms_body":"This is a test message","csms_id":"644f9ad337562","reference_id":"644f9ad37a867181381"}]}

}


function get_hashtags($string, $str = 1) {
    preg_match_all('/#(\w+)/',$string,$matches);
    $i = 0;
    $keywords='';
    if ($str) {
        foreach ($matches[1] as $match) {
            $count = count($matches[1]);
            $keywords .= "$match";
            $i++;
            if ($count > $i) $keywords .= ", ";
        }
    } else {
        foreach ($matches[1] as $match) {
            $keyword[] = $match;
        }
        $keywords = $keyword;
    }
    return $keywords;
}

function popularTags($tag_array) {
    $p = array();
    foreach($tag_array as $tags) {
        $tags_arr = array_map('trim', explode(',', $tags));
        foreach($tags_arr as $tag) {
            $p[$tag] = array_key_exists($tag, $p) ? $p[$tag]+1 : 1;
        }
    }
    arsort($p);
    return $p;
}


function getTrendingTags($datas,$column)   //$datas is rows data of db 
{
    $tags=[];

    foreach($datas as $data)
    {
        $tags[]=str_replace(' ','',get_hashtags($data[$column]));
    }

    $tags_text= implode(',',$tags);

    $all_tags_array= explode(',',$tags_text);
    
    $popular_tags_ascociative_arr=popularTags($all_tags_array); // keys is tags

    $popular_tags_array=array_keys($popular_tags_ascociative_arr);

    return $popular_tags_array;

}


function removeIfFirstZero($phone)
{
    // Check if the first character of the phone number is '0'
    if (substr($phone, 0, 1) == '0') {
        // If it starts with 0, remove the first character
        $phone = substr($phone, 1);
    }

    return $phone;
}


function logOutFromOtherDevice()
{
    $user = Auth::user(); 
    $currentSessionId = session()->getId(); 

    // Delete all other sessions for the user
    DB::table('sessions')
        ->where('user_id', $user->getAuthIdentifier())
        ->where('id', '!=', $currentSessionId)
        ->delete();

    $user->tokens->each(function ($token) {
        $token->delete();
    });
}


function formatDuration($minutes) 
{
    if ($minutes >= 43200) { // 1 month (assuming 30 days)
        $months = floor($minutes / 43200);
        return "$months month" . ($months > 1 ? 's' : '');
    } elseif ($minutes >= 1440) { // 1 day
        $days = floor($minutes / 1440);
        return "$days day" . ($days > 1 ? 's' : '');
    } elseif ($minutes >= 60) { // 1 hour
        $hours = floor($minutes / 60);
        return "$hours hour" . ($hours > 1 ? 's' : '');
    } else {
        return "$minutes minute" . ($minutes > 1 ? 's' : '');
    }
}