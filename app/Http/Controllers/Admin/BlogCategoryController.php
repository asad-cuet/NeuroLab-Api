<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\BlogCategory;


class BlogCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-category-view|blog-category-create|blog-category-update|blog-category-delete', ['only' => ['index']]);
        $this->middleware('permission:blog-category-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-category-update', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Blog Category';
        $info=new stdClass();
        $info->title = 'Blog Categories';
        $info->first_button_title = 'Add Blog Category';
        $info->first_button_route = 'admin.blog-categories.create';
        $info->route_index = 'admin.blog-categories.index';
        $info->description = 'These all are Blog Categories';


        $with_data=[];

        $data = BlogCategory::query();

        

        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->get();

        return view('admin.blog-categories.index', compact('page_title', 'data', 'info'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Blog Category Create';
        $info=new stdClass();
        $info->title = 'Blog Categories';
        $info->first_button_title = 'All Blog Category';
        $info->first_button_route = 'admin.blog-categories.index';
        $info->form_route = 'admin.blog-categories.store';

        return view('admin.blog-categories.create',compact('page_title','info'));
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
                Rule::unique('blog_categories', 'slug'),
            ],
                    
            'parent_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
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
                
                return back()->with('warning',$file_response['message']);
            }

            $row->banner = $file_response['filename'];
        }
        $row->save();
        
        return redirect()->route('admin.blog-categories.index')
        ->with('success','Blog Category created successfully!');
    }

    public function show($id)
    {
        
        $page_title = 'Blog Category Details';
        $info = new stdClass();
        $info->title = 'Blog Categories Details';
        $info->first_button_title = 'Edit Blog Category';
        $info->first_button_route = 'admin.blog-categories.edit';
        $info->second_button_title = 'All Blog Category';
        $info->second_button_route = 'admin.blog-categories.index';
        $info->description = '';


        $data = BlogCategory::findOrFail($id);


        return view('admin.blog-categories.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Blog Category Edit';
        $info=new stdClass();
        $info->title = 'Blog Categories';
        $info->first_button_title = 'Add Blog Category';
        $info->first_button_route = 'admin.blog-categories.create';
        $info->second_button_title = 'All Blog Category';
        $info->second_button_route = 'admin.blog-categories.index';
        $info->form_route = 'admin.blog-categories.update';
        $info->route_destroy = 'admin.blog-categories.destroy';

        $data=BlogCategory::where('id',$id)->first();

        return view('admin.blog-categories.edit',compact('page_title','info','data'))->with('id',$id);
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
                Rule::unique('blog_categories', 'slug')->ignore($id),
            ],
                    
            'parent_id' => 'nullable|integer',
                    
        ];
        $this->validate($request, $validation_rules);
        $row = BlogCategory::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
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
                
                return back()->with('warning',$file_response['message']);
            }

            $old_file=$row->banner;
            FileManager::deleteFile($old_file);

            $row->banner = $file_response['filename'];
        }
        $row->save();
        
        return redirect()->route('admin.blog-categories.show',$id)
        ->with('success','Blog Category updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=BlogCategory::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        if($row['banner']!='')
        {
            FileManager::deleteFile($row['banner']);
        }
        
        $row->delete();
        
        return redirect()->route('admin.blog-categories.index')
        ->with('success','Blog Category deleted successfully!');
    }
}