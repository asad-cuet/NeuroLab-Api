<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\BlogComment;


class MediaLibraryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:media-library-view|media-library-create|media-library-update|media-library-delete', ['only' => ['index']]);
        $this->middleware('permission:media-library-create', ['only' => ['create','store']]);
        $this->middleware('permission:media-library-update', ['only' => ['edit','update']]);
        $this->middleware('permission:media-library-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('admin.media-library.index');
        
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
                    
            'phone' => 'nullable|string',
                    
            'email' => 'nullable|email',
                    
            'user_id' => 'required|integer',
                    
            'parent_id' => 'nullable|integer',
                    
            'status' => 'required|string|in:approved,pending,cancelled',
                    
            'description' => 'nullable|string',
                    
        ];
        $this->validate($request, $validation_rules);
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
                
                return back()->with('warning',$file_response['message']);
            }

            $row->image = $file_response['filename'];
        }
        $row->save();
        
        return redirect()->route('admin.blog-comments.index')
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
        $info->second_button_title = 'All Blog Comment';
        $info->second_button_route = 'admin.blog-comments.index';
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
                    
            'user_id' => 'required|integer',
                    
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
        
        return redirect()->route('admin.blog-comments.show',$id)
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
        
        $row->delete();
        
        return redirect()->route('admin.blog-comments.index')
        ->with('success','Blog Comment deleted successfully!');
    }
}