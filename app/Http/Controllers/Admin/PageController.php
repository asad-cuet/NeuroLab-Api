<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use Illuminate\Validation\Rule;
use Hash;
use \stdClass;
use App\Models\Page;


class PageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:page-view|page-create|page-update|page-delete', ['only' => ['index']]);
        $this->middleware('permission:page-create', ['only' => ['create','store']]);
        $this->middleware('permission:page-update', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title = 'Page';
        $info=new stdClass();
        $info->title = 'Pages';
        $info->first_button_title = 'Add Page';
        $info->first_button_route = 'admin.pages.create';
        $info->route_index = 'admin.pages.index';
        $info->description = 'These all are Pages';


        $with_data=[];

        $data = Page::query();

        

        

        $data =$data->orderBy('id', 'DESC');
        $data =$data->get();

        return view('admin.pages.index', compact('page_title', 'data', 'info'))->with($with_data);
        
    }


    public function create()
    {
        $page_title = 'Page Create';
        $info=new stdClass();
        $info->title = 'Pages';
        $info->first_button_title = 'All Page';
        $info->first_button_route = 'admin.pages.index';
        $info->form_route = 'admin.pages.store';

        return view('admin.pages.create',compact('page_title','info'));
    }

    public function store(Request $request)
    {
        $validation_rules=[
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    
            'author_admin_id' => 'nullable|integer',
                    
            'title' => 'required|string',

            'content' => 'nullable|string',

            'page_tags' => 'nullable|string',
                    
            'slug' => [
                'required',
                'string',
                Rule::unique('pages', 'slug'),
            ],
                    
            'meta_title' => 'nullable|string',
                    
            'meta_tags' => 'nullable|string',
                      
            'meta_description' => 'nullable|string',
                    
        ];

        $this->validate($request, $validation_rules);

        $row =new Page;
        
        $row->title = $request->title;
        
        $row->slug = $request->slug;

        $row->content = $request->content;

        $row->tags = $request->page_tags;
        
        $row->meta_title = $request->meta_title;
        
        $row->meta_tags = $request->meta_tags;
        
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
                
                return back()->with('warning',$file_response['message']);
            }

            $row->banner = $file_response['filename'];
        }

        $row->save();
        
        return redirect()->route('admin.pages.index')
        ->with('success','Page created successfully!');
    }

    public function show($id)
    {
        $page_title = 'Page Details';
        $info = new stdClass();
        $info->title = 'Pages Details';
        $info->first_button_title = 'Edit Page';
        $info->first_button_route = 'admin.pages.edit';
        $info->second_button_title = 'All Page';
        $info->second_button_route = 'admin.pages.index';
        $info->description = '';

        $data = Page::findOrFail($id);

        return view('admin.pages.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Page Edit';
        $info=new stdClass();
        $info->title = 'Pages';
        $info->first_button_title = 'Add Page';
        $info->first_button_route = 'admin.pages.create';
        $info->second_button_title = 'All Page';
        $info->second_button_route = 'admin.pages.index';
        $info->form_route = 'admin.pages.update';
        $info->route_destroy = 'admin.pages.destroy';

        $data=Page::where('id',$id)->first();

        return view('admin.pages.edit',compact('page_title','info','data'))->with('id',$id);
    }

    public function update(Request $request, $id)
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
        $this->validate($request, $validation_rules);
        $row = Page::find($id);    
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
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
                
                return back()->with('warning',$file_response['message']);
            }

            $old_file=$row->banner;
            FileManager::deleteFile($old_file);

            $row->banner = $file_response['filename'];
        }
        $row->save();
        
        return redirect()->route('admin.pages.show',$id)
        ->with('success','Page updated successfully!');
    }

    public function destroy($id)
    {
        
        $row=Page::where('id',$id)->first();
        
        if($row==null || $row=='')
        {
            return back()->with('warning','Id not Found');
        }
        
        
        if($row['banner']!='')
        {
            FileManager::deleteFile($row['banner']);
        }
        
        $row->delete();
        
        return redirect()->route('admin.pages.index')
        ->with('success','Page deleted successfully!');
    }
}