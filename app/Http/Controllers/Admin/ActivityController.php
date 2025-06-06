<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Auth;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        
        $activities = Activity::orderBy('id', 'desc');

        $admins=[];

        $per_page = request('per_page', 20);

        if(Auth::user()->hasRole('Super Admin'))
        {
            $admins = Admin::orderBy('id', 'DESC')->get();

            $activities=$activities->where('causer_id','!=',Null);
            if($request->admin_id!='')
            {
                $activities=$activities->where('causer_id',$request->admin_id);
            }
        }
        else
        {
            $activities=$activities->where('causer_id',Auth::user()->id);
        }

        if ($request->search!='' && trim($request->search)!='') 
        {
            $data=keywordBaseSearch(
                $searh_key=trim($request->search),
                $columns_array=['name','email','phone'],
                $model_query=$data
            );
        }
        

        $activities=$activities->paginate($per_page);

        
        $mapped_activities=mapActivity($activities->toArray()['data'])->toArray();
        

        $total_activities=Activity::where('causer_id','!=',Null)->count();

        $arr=[
            'mapped_activities'=>$mapped_activities,
            'activities'=>$activities,
            'total_activities'=>$total_activities,
            'admins'=>$admins,
            'per_page'=>$per_page,
        ];
        return view('admin.activity-log.all-activities',$arr);
    }
}
