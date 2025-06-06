<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\BlogCategory;
use App\Http\Resources\BlogCategoryCollection;
use App\Http\Resources\BlogCategoryDetailCollection;

class BlogCategoryController extends Controller
{

    public function __construct()
    {
        //CONSTRUCT_METHOD
    }



    public function index(Request $request)
    {
        $data = BlogCategory::where('is_active',1);

        if(isset($request->search) && trim($request->search)!='')
        {
            $search_columns = ['id','title','slug'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        
        if($request->parent_slug!='')
        {
            $data=$data->whereHas('blogCategory', function ($query) use ($request) {
                $query->where('slug', $request->parent_slug);
            });
        }
                
        $data =$data->orderBy('id', 'DESC')->get();

        return new BlogCategoryCollection($data);
        
    }


    public function store(Request $request)
    {
        
        $validation_rules=[
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('blog_categories', 'slug'),
            ],
                    
            'parent_id' => 'nullable|integer',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row =new BlogCategory;
        
        $row->title = $request->title;
        
        $row->slug = $request->slug;
        
        $row->parent_id = $request->parent_id;
        
        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Blog-Categories',
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
        $data = BlogCategory::where('id',$id)->where('is_active',1);
        $data =$data->first();
        return new BlogCategoryDetailCollection($data);
        
    }

    public function update(Request $request,$id)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('blog_categories', 'slug')->ignore($id),
            ],
                    
            'parent_id' => 'nullable|integer',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row = BlogCategory::find($id);    
        
        if($row==null || $row=='')
        {
            return apiResponse($result=false,$message='Not Found',$data=null);
        }
        
        
        $row->title=$request->title;
        
        $row->slug=$request->slug;
        
        $row->parent_id=$request->parent_id;
        
        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Blog-Categories',
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
        
        $row=BlogCategory::where('id',$id)->first();
        
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