<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Blog;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogDetailCollection;

class BlogController extends Controller
{

    public function __construct()
    {
        //CONSTRUCT_METHOD
    }



    public function index(Request $request)
    {
        $data = Blog::withPublished()->where('is_active',1);

        if(isset($request->search) && trim($request->search)!='')
        {
            $search_columns = ['title','slug','meta_title','meta_tags','short_description','description'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        
        if($request->blog_category_slug!='')
        {
            $data=$data->whereHas('blogCategory', function ($query) use ($request) {
                $query->where('slug', $request->blog_category_slug);
            });
        }

        if($request->tags!='') 
        {
            $data = $data->where('description','like', "%{$request->tags}%");
        }
                
        $data =$data->orderBy('id', 'DESC')->get();

        return new BlogCollection($data);
        
    }

    

    public function store(Request $request)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('blogs', 'slug'),
            ],
                    
            'meta_title' => 'nullable|string',
                    
            'meta_tags' => 'nullable|string',
                    
            'blog_category_id' => 'required|integer',
                    
            'status' => 'required|string|in:draft,published',
                    
            'short_description' => 'nullable|string',
                    
            'description' => 'nullable|string',
                    
            'meta_description' => 'nullable|string',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row =new Blog;
        
        $row->title = $request->title;
        
        $row->slug = $request->slug;
        
        $row->meta_title = $request->meta_title;
        
        $row->meta_tags = $request->meta_tags;
        
        $row->short_description = $request->short_description;
        
        $row->description = $request->description;
        
        $row->meta_description = $request->meta_description;
        
        $row->blog_category_id = $request->blog_category_id;
        
        $row->status = $request->status;
        
        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Blogs',
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
        $data = Blog::where('id',$id)->where('is_active',1);
        $data =$data->first();
        return new BlogDetailCollection($data);
        
    }

    public function update(Request $request,$id)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('blogs', 'slug')->ignore($id),
            ],
                    
            'meta_title' => 'nullable|string',
                    
            'meta_tags' => 'nullable|string',
                    
            'blog_category_id' => 'required|integer',
                    
            'status' => 'required|string|in:draft,published',
                    
            'short_description' => 'nullable|string',
                    
            'description' => 'nullable|string',
                    
            'meta_description' => 'nullable|string',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row = Blog::find($id);    
        
        if($row==null || $row=='')
        {
            return apiResponse($result=false,$message='Not Found',$data=null);
        }
        
        
        $row->title=$request->title;
        
        $row->slug=$request->slug;
        
        $row->meta_title=$request->meta_title;
        
        $row->meta_tags=$request->meta_tags;
        
        $row->short_description=$request->short_description;
        
        $row->description=$request->description;
        
        $row->meta_description=$request->meta_description;
        
        $row->blog_category_id=$request->blog_category_id;
        
        $row->status=$request->status;
        
        if($request->hasfile('banner')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('banner'),
                'storage/Blogs',
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
        
        $row=Blog::where('id',$id)->first();
        
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

    public function blogTrendingTags()
    {
        $datas=Blog::orderBy('id','desc')->where('description','like', "%#%")->where('is_active',1)->get();
        $trending_tags = getTrendingTags($datas,'description');

        return response()->json(['tags' => $trending_tags]);

    }

}