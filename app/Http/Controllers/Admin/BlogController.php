<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\Blog;


class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-view|blog-create|blog-update|blog-delete', ['only' => ['index']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-update', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Blog';
        $info=new stdClass();
        $info->title = 'Blogs';
        $info->first_button_title = 'Add Blog';
        $info->first_button_route = 'admin.blogs.create';
        $info->route_index = 'admin.blogs.index';
        $info->description = 'These all are Blogs';


        $with_data=[];

        $data = Blog::query();

        

        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->get();

        return view('admin.blogs.index', compact('page_title', 'data', 'info'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Blog Create';
        $info=new stdClass();
        $info->title = 'Blogs';
        $info->first_button_title = 'All Blog';
        $info->first_button_route = 'admin.blogs.index';
        $info->form_route = 'admin.blogs.store';

        return view('admin.blogs.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                'alpha_dash',
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
        $this->validate($request, $validation_rules);
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
        

        if ($request->hasFile('banner')) {
            $row->addMediaFromRequest('banner')
            ->toMediaCollection('banners');
        }


        // if($request->hasfile('banner')) 
        // {
        //     $file_response=FileManager::saveFile(
        //         $request->file('banner'),
        //         'storage/Blogs',
        //         ['png','jpg','jpeg','gif']
        //     );

        //     if(isset($file_response['result']) && !$file_response['result'])
        //     {
                
        //         return back()->with('warning',$file_response['message']);
        //     }

        //     $row->banner = $file_response['filename'];
        // }


        $row->save();
        
        return redirect()->route('admin.blogs.index')
        ->with('success','Blog created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Blog Details';
        $info = new stdClass();
        $info->title = 'Blogs Details';
        $info->form_route = 'admin.blogs.update';
        $info->first_button_title = 'Edit Blog';
        $info->first_button_route = 'admin.blogs.edit';
        $info->second_button_title = 'All Blog';
        $info->second_button_route = 'admin.blogs.index';
        $info->description = '';


        $data = Blog::findOrFail($id);


        return view('admin.blogs.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Blog Edit';
        $info=new stdClass();
        $info->title = 'Blogs';
        $info->first_button_title = 'Add Blog';
        $info->first_button_route = 'admin.blogs.create';
        $info->second_button_title = 'All Blog';
        $info->second_button_route = 'admin.blogs.index';
        $info->form_route = 'admin.blogs.update';
        $info->route_destroy = 'admin.blogs.destroy';

        $data=Blog::where('id',$id)->first();

        return view('admin.blogs.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
    {
        
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'title' => 'required|string',
                    
            'slug' => [
                'required',
                'string',
                'alpha_dash',
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
        $this->validate($request, $validation_rules);
        $row = Blog::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
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
        

        if ($request->hasFile('banner')) {
            $row->addMediaFromRequest('banner')->withResponsiveImages()->toMediaCollection('banner');
        }


        // if($request->hasfile('banner')) 
        // {
        //     $file_response=FileManager::saveFile(
        //         $request->file('banner'),
        //         'storage/Blogs',
        //         ['png','jpg','jpeg','gif']
        //     );
        //     if(isset($file_response['result']) && !$file_response['result'])
        //     {
                
        //         return back()->with('warning',$file_response['message']);
        //     }

        //     $old_file=$row->banner;
        //     FileManager::deleteFile($old_file);

        //     $row->banner = $file_response['filename'];
        // }

        $row->save();
        
        return redirect()->route('admin.blogs.show',$id)
        ->with('success','Blog updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=Blog::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        // if($row['banner']!='')
        // {
        //     FileManager::deleteFile($row['banner']);
        // }
        
        $row->delete();
        
        return redirect()->route('admin.blogs.index')
        ->with('success','Blog deleted successfully!');
    }
}