<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\BlogComment;


class BlogCommentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-comment-view|blog-comment-create|blog-comment-update|blog-comment-delete', ['only' => ['index']]);
        $this->middleware('permission:blog-comment-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-comment-update', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-comment-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Blog Comment';
        $info=new stdClass();
        $info->title = 'Blog Comments';
        $info->first_button_title = 'Add Blog Comment';
        $info->first_button_route = 'admin.blog-comments.create';
        $info->route_index = 'admin.blog-comments.index';
        $info->description = 'These all are Blog Comments';


        $with_data=[];

        $data = BlogComment::query();

        

        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->get();

        return view('admin.blog-comments.index', compact('page_title', 'data', 'info'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Blog Comment Create';
        $info=new stdClass();
        $info->title = 'Blog Comments';
        $info->first_button_title = 'All Blog Comment';
        $info->first_button_route = 'admin.blog-comments.index';
        $info->form_route = 'admin.blog-comments.store';

        return view('admin.blog-comments.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'name' => 'required|string',

            'blog_id' => 'required|integer',
                    
            'phone' => 'nullable|string',
                    
            'email' => 'nullable|email',
                    
            'user_id' => 'required|integer',
                    
            'parent_id' => 'nullable|integer',
                    
            'status' => 'required|string|in:approved,pending,cancelled',
                    
            'description' => 'nullable|string',
                    
        ];
        $this->validate($request, $validation_rules);
        $row =new BlogComment;
        
        $row->blog_id = $request->blog_id;

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
                
                return back()->with('warning',$file_response['message']);
            }

            $row->image = $file_response['filename'];
        }
        $row->save();
        
        return redirect(route('admin.blogs.show',$row->blog_id).'?tab=comments')
        ->with('success','Blog Comment created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Blog Comment Details';
        $info = new stdClass();
        $info->title = 'Blog Comments Details';
        $info->first_button_title = 'Edit Blog Comment';
        $info->first_button_route = 'admin.blog-comments.edit';
        $info->second_button_title = 'All Blog Comment';
        $info->second_button_route = 'admin.blog-comments.index';
        $info->description = '';


        $data = BlogComment::findOrFail($id);


        return view('admin.blog-comments.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Blog Comment Edit';
        $info=new stdClass();
        $info->title = 'Blog Comments';
        $info->first_button_title = 'Add Blog Comment';
        $info->first_button_route = 'admin.blog-comments.create';
        $info->form_route = 'admin.blog-comments.update';
        $info->route_destroy = 'admin.blog-comments.destroy';

        $data=BlogComment::where('id',$id)->first();

        return view('admin.blog-comments.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'name' => 'required|string',
                    
            'phone' => 'nullable|string',
                    
            'email' => 'nullable|email',
                    
            'user_id' => 'nullable|integer',
                    
            'parent_id' => 'nullable|integer',
                    
            'status' => 'required|string|in:approved,pending,cancelled',
                    
            'description' => 'nullable|string',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = BlogComment::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
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
                
                return back()->with('warning',$file_response['message']);
            }

            $old_file=$row->image;
            FileManager::deleteFile($old_file);

            $row->image = $file_response['filename'];
        }
        $row->save();
        
        return redirect(route('admin.blogs.show',$row->blog_id).'?tab=comments')
        ->with('success','Blog Comment updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=BlogComment::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        if($row['image']!='')
        {
            FileManager::deleteFile($row['image']);
        }

        $blog_id=$row->blog_id;
        
        $row->delete();
        
        return redirect(route('admin.blogs.show',$blog_id).'?tab=comments')
        ->with('success','Blog Comment deleted successfully!');
    }
}