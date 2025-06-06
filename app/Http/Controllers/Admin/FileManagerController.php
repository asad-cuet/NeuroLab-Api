<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\FileManager;
use Auth;
class FileManagerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:file-manager-view|file-manager-create|file-manager-update|file-manager-delete', ['only' => ['index']]);
        $this->middleware('permission:file-manager-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:file-manager-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:file-manager-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        return redirect()->route('admin.file-managers.create');
    }


    public function create(FileManager $file_managers)
    {
        // $file_managers = FileManager::get();
        $file_managers = FileManager::get();

        return view('admin.file-managers.create', compact('file_managers'));
    }

    public function store(Request $request)
    {
        $file_manager = FileManager::create([
            'created_by' => Auth::id(),
            'name' => $request->file_manager,
        ]);

        if ($images = $request->file('files')) {
            $file_manager->clearMediaCollection('files');
            foreach ($images as $file) {
                $file_manager->addMedia($file)->toMediaCollection('files');
               // dd($file_manager);
            }
        }
        

        return redirect(route('admin.file-managers.create'))->with('success',"Folder Created Successfully!");
    }

    public function share($id)
    {
        $upload=FileManager::find($id);
        return view('admin.file-managers.share',compact('upload'));
    }


    public function edit($id)
    {
        $file_manager=FileManager::find($id);
        return view('admin.file-managers.edit',compact('file_manager'));
    }


    public function update(Request $request,$id)
    {
        $file_manager = FileManager::findOrFail($id);
        $file_manager->update([
            'updated_by' => Auth::id(),
            'name' => $request->file_manager,
            'is_active' => $request->is_active,
        ]);

        return redirect(route('admin.file-managers.index'))->with('success',"Updated Successfully");

    }

    public function show($id)
    {
        $file_manager = FileManager::findOrFail($id);
        return view('admin.file-managers.show', compact('file_manager'));
    }

    public function fileUpload(Request $request, $id)
    {
        return $id;
    }


    public function destroy($id)
    {
        $upload=FileManager::find($id);

        $old_image=$upload->name;
        if(File::exists($old_image))
        {
            File::delete($old_image);
        }
        $upload->delete();

        return redirect(route('admin.file-managers.index'))->with('success',"Deleted Successfully");
    }
}
