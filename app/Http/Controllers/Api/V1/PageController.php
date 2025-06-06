<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Page;
use App\Http\Resources\PageCollection;
use App\Http\Resources\PageDetailCollection;

class PageController extends Controller
{

    public function __construct()
    {
        //CONSTRUCT_METHOD
    }



    public function index(Request $request)
    {
        $data = Page::where('is_active',1);

        if(isset($request->search) && trim($request->search)!='')
        {
            $search_columns = ['id','title','slug','meta_title','meta_tags'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        
        if($request->author_admin_name!='')
        {
            $data=$data->whereHas('admin', function ($query) use ($request) {
                $query->where('name', $request->author_admin_name);
            });
        }
                
        $data =$data->orderBy('id', 'DESC')->get();

        return new PageCollection($data);
        
    }

    


    public function store(Request $request)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'author_admin_id' => 'nullable|integer',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('pages', 'slug'),
            ],
                    
            'meta_title' => 'nullable|string',
                    
            'meta_tags' => 'nullable|string',
                    
            'content' => 'nullable|string',
                    
            'meta_description' => 'nullable|string',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row =new Page;
        
        $row->title = $request->title;
        
        $row->slug = $request->slug;
        
        $row->meta_title = $request->meta_title;
        
        $row->meta_tags = $request->meta_tags;
        
        $row->content = $request->content;
        
        $row->meta_description = $request->meta_description;
        
        $row->author_admin_id = $request->author_admin_id;
        
        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Pages',
                ['png','jpg','jpeg','gif']
            );

            if(isset($file_response['result']) && !$file_response['result'])
            {
                return apiResponse($result=false,$message=$file_response['message'],$data=null);
            }

            $row->banner = $file_response['filename'];
        }
        $row->save();
        
        return apiResponse($result=true,$message='Stored Successfully',$data=null);
    }

    public function show(Request $request,$id)
    {
        $data = Page::where('id',$id)->where('is_active',1);
        $data =$data->first();
        return new PageDetailCollection($data);
        
    }

    public function update(Request $request,$id)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'author_admin_id' => 'nullable|integer',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('pages', 'slug')->ignore($id),
            ],
                    
            'meta_title' => 'nullable|string',
                    
            'meta_tags' => 'nullable|string',
                    
            'content' => 'nullable|string',
                    
            'meta_description' => 'nullable|string',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row = Page::find($id);    
        
        if($row==null || $row=='')
        {
            return apiResponse($result=false,$message='Not Found',$data=null);
        }
        
        
        $row->title=$request->title;
        
        $row->slug=$request->slug;
        
        $row->meta_title=$request->meta_title;
        
        $row->meta_tags=$request->meta_tags;
        
        $row->content=$request->content;
        
        $row->meta_description=$request->meta_description;
        
        $row->author_admin_id=$request->author_admin_id;
        
        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Pages',
                ['png','jpg','jpeg','gif']
            );
            if(isset($file_response['result']) && !$file_response['result'])
            {
                return apiResponse($result=false,$message=$file_response['message'],$data=null);
            }

            $old_file=$row->banner;
            FileManager::deleteFile($old_file);

            $row->banner = $file_response['filename'];
        }
        $row->save();
        
        return apiResponse($result=true,$message='Updated Successfully',$data=null);
    }

    public function destroy(Request $request,$id)
    {
        
        $row=Page::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return apiResponse($result=false,$message='Not Found',$data=null);
        }
        
        
        if($row['banner']!='')
        {
            FileManager::deleteFile($row['banner']);
        }
        
        $row->delete();
        
        return apiResponse($result=true,$message='Deleted Successfully',$data=null);
    }
}