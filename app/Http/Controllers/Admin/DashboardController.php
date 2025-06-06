<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use App\Models\Todo;
use App\Models\User;
use App\Models\Admin;
use App\Models\Blog;
use Auth;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;


class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(Request $req)
    {

        //fetch the most visited pages for today and the past week
        // $analytics=Analytics::fetchMostVisitedPages(Period::days(7));
        // $analytics=Analytics::fetchVisitorsAndPageViews(Period::days(7));
        // $analytics=Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
        // $analytics=Analytics::fetchTopReferrers(Period::days(7));
        // $analytics=Analytics::fetchUserTypes(Period::days(7));
        // $analytics=Analytics::fetchTopBrowsers(Period::days(7));
        // $analytics=Analytics::fetchTopCountries(Period::days(7));
        // $analytics=Analytics::fetchTopOperatingSystems(Period::days(7));
        // return $analytics;
        
        $admin=Admin::where('id',Auth::id())->first();
        $admin->visit()->withSession();

        $page_title = 'Dashboard';
        $page_description = 'This is the base Admin Panel of Tork';
        $all_menu = ActiveModelData('App\Models\AdminMenu');


        $todos=Todo::orderBy('id','desc')->where('admin_id',auth()->id())->get();


        $users=User::orderBy('id','desc')->get();
        $new_arrivals=[];
        foreach($users as $user)
        {
            $new_arrivals[]=(object)[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_verified' => $user->email_verified_at? 1:0
            ];
        }


        $todays_visitors=Admin::popularToday()->get();

        
        if(Auth::user()->isSuperAdmin())
        {
            $activities = Activity::orderBy('id', 'desc')->where('causer_id','!=',Null)->take(10)->get();
        }
        else
        {
            $activities = Activity::orderBy('id', 'desc')->where('causer_id',Auth::user()->id)->take(10)->get();
            if(!$activities) 
            {
                $activities=[];
            }

        }

        $activities=mapActivity($activities)?? [];


        $today = now(); // Get the current date
        $today_visitors_pages = Analytics::fetchTotalVisitorsAndPageViews(Period::create($today->startOfDay(), $today->endOfDay()))->toArray();

        $top_analytics=[
            'totol_users'=>User::count(),
            'totol_blogs'=>Blog::where('is_active',1)->count(),
            'today_visitors'=>count($today_visitors_pages)? $today_visitors_pages[0]['activeUsers']?? 0:0,
        ];

        $data=[
            'all_menu'  => $all_menu,
            'todos'  => $todos,
            'new_arrivals'  => $new_arrivals,
            'todays_visitors'  => $todays_visitors,
            'activities' => $activities,
            'top_analytics' => $top_analytics,
        ];
 
        return view('admin.dashboard.index', compact('page_title', 'page_description', 'data'));
    }

    public function countriesAnalytics(Request $request)
    {
        if($request->range_type=='today')
        {
            $today = now();
            $period=Period::create($today->startOfDay(), $today->endOfDay());
        }
        else if($request->range_type=='lastWeek')
        {
            $period=Period::days(7);
        }
        else if($request->range_type=='lastMonth')
        {
            $period=Period::days(30);
        }
        else if($request->range_type=='sixMonths')
        {
            $period=Period::days(30*6);
        }
        else if($request->range_type=='oneYear')
        {
            $period=Period::days(365);
        }
        else
        {
            $period=Period::days(365);
        }

        $data=[
            'top_countries'=>Analytics::fetchTopCountries($period)->toArray(),
        ];


        return apiResponse(true,'success',$data);
    }

    public function topPagesAnalytics(Request $request)
    {
        if($request->range_type=='today')
        {
            $today = now();
            $period=Period::create($today->startOfDay(), $today->endOfDay());
        }
        else if($request->range_type=='lastWeek')
        {
            $period=Period::days(7);
        }
        else if($request->range_type=='lastMonth')
        {
            $period=Period::days(30);
        }
        else if($request->range_type=='sixMonths')
        {
            $period=Period::days(30*6);
        }
        else if($request->range_type=='oneYear')
        {
            $period=Period::days(365);
        }
        else
        {
            $period=Period::days(365);
        }

        $data=[
            'top_pages'=>Analytics::fetchMostVisitedPages($period)->toArray(),
        ];


        return apiResponse(true,'success',$data);
    }

    public function topDeviceAnalytics(Request $request)
    {
        if($request->range_type=='today')
        {
            $today = now();
            $period=Period::create($today->startOfDay(), $today->endOfDay());
        }
        else if($request->range_type=='lastWeek')
        {
            $period=Period::days(7);
        }
        else if($request->range_type=='lastMonth')
        {
            $period=Period::days(30);
        }
        else if($request->range_type=='sixMonths')
        {
            $period=Period::days(30*6);
        }
        else if($request->range_type=='oneYear')
        {
            $period=Period::days(365);
        }
        else
        {
            $period=Period::days(365);
        }

        $data=[
            'top_devices'=>Analytics::fetchTopOperatingSystems($period)->toArray(),
        ];


        return apiResponse(true,'success',$data);
    }

    public function visitorPagesAnalytics(Request $request)
    {

        $data=[
            'visitors_pages'=>Analytics::fetchTotalVisitorsAndPageViews(Period::days(365))->toArray(),
        ];


        return apiResponse(true,'success',$data);
    }

    
}
