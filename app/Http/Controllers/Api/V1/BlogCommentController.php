<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\BlogComment;
use App\Http\Resources\BlogCommentCollection;
use App\Http\Resources\BlogCommentDetailCollection;

class BlogCommentController extends Controller
{

    public function __construct()
    {
        //CONSTRUCT_METHOD
    }



    public function index(Request $request)
    {
        $data = BlogComment::where('is_active',1)->withApproved();

        if(isset($request->search) && trim($request->search)!='')
        {
            $search_columns = ['id','name','phone','email','description'];
            $data=keywordBaseSearch(
                $searh_key=$request->search,
                $columns_array=$search_columns,
                $model_query=$data
            );
        }
        
        if($request->user_id!='')
        {
            $data=$data->whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->user_id);
            });
        }
                
        if($request->parent_id!='')
        {
            $data=$data->whereHas('blogComment', function ($query) use ($request) {
                $query->where('id', $request->parent_id);
            });
        }
                
        $data =$data->orderBy('id', 'DESC')->get();

        return new BlogCommentCollection($data);
        
    }


    public function store(Request $request)
    {
        
        $validation_rules=[
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'name' => 'required|string',
                    
            'phone' => 'nullable|string',
                    
            'email' => 'nullable|email',
                    
            'user_id' => 'required|integer',
                    
            'parent_id' => 'nullable|integer',
                    
            'status' => 'required|string|in:approved,pending,cancelled',
                    
            'description' => 'nullable|string',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row =new BlogComment;
        
        $row->name = $request->name;
        
        $row->phone = $request->phone;
        
        $row->email = $request->email;
        
        $row->description = $request->description;
        
        $row->user_id = $request->user_id;
        
        $row->parent_id = $request->parent_id;
        
        $row->status = $request->status;
        
        if($request->hasfile('image')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('image'),
                'storage/Blog-Comments',
                ['png','jpg','jpeg','gif']
            );

            if(isset($file_response['result']) && !$file_response['result'])
            {
                return apiResponse($result=false,$message=$file_response['message'],$data=null);
            }

            $row->image = $file_response['filename'];
        }
        $row->save();
        
        return apiResponse($result=true,$message='Stored Successfully',$data=null);
    }

    public function show(Request $request,$id)
    {
        $data = BlogComment::where('id',$id)->where('is_active',1);
        $data =$data->first();
        return new BlogCommentDetailCollection($data);
        
    }

    public function update(Request $request,$id)
    {
        
        $validation_rules=[
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'name' => 'required|string',
                    
            'phone' => 'nullable|string',
                    
            'email' => 'nullable|email',
                    
            'user_id' => 'required|integer',
                    
            'parent_id' => 'nullable|integer',
                    
            'status' => 'required|string|in:approved,pending,cancelled',
                    
            'description' => 'nullable|string',
                    
        ];
        
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            return apiResponse($result=false,$message='Error',$data=$error_arr,$code=200);
        }
        
        
        $row = BlogComment::find($id);    
        
        if($row==null || $row=='')
        {
            return apiResponse($result=false,$message='Not Found',$data=null);
        }
        
        
        $row->name=$request->name;
        
        $row->phone=$request->phone;
        
        $row->email=$request->email;
        
        $row->description=$request->description;
        
        $row->user_id=$request->user_id;
        
        $row->parent_id=$request->parent_id;
        
        $row->status=$request->status;
        
        if($request->hasfile('image')) 
        {
            $file_response=FileManager::saveFile(
                $request->file('image'),
                'storage/Blog-Comments',
                ['png','jpg','jpeg','gif']
            );
            if(isset($file_response['result']) && !$file_response['result'])
            {
                return apiResponse($result=false,$message=$file_response['message'],$data=null);
            }

            $old_file=$row->image;
            FileManager::deleteFile($old_file);

            $row->image = $file_response['filename'];
        }
        $row->save();
        
        return apiResponse($result=true,$message='Updated Successfully',$data=null);
    }

    public function destroy(Request $request,$id)
    {
        
        $row=BlogComment::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return apiResponse($result=false,$message='Not Found',$data=null);
        }
        
        
        if($row['image']!='')
        {
            FileManager::deleteFile($row['image']);
        }
        
        $row->delete();
        
        return apiResponse($result=true,$message='Deleted Successfully',$data=null);
    }

}