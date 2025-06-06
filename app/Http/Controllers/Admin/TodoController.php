<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Todo;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        $data=[
            'admin_id'=>auth()->id(),
            'task'=>$request->new_todo,
            'is_complete'=>0
        ];
        $todo=Todo::create($data);

        $data=[
            'status'=>'success',
            'todo'=>$todo,
        ];
        return $data;
    }


    public function toggle(Request $request)
    {
        $todo=Todo::where('id',$request->todo_id)->where('admin_id',auth()->id())->first();
        $todo->is_complete=!$todo->is_complete;
        $todo->update();
        
        $data=[
            'status'=>'success',
            'id'=>$todo->id,
            'user_id'=>2,
            'task'=>$todo->task,
            'is_complete'=>$todo->is_complete
        ];
        return $data;
    }


    public function delete(Request $request)
    {
        if(Todo::where('id',$request->todo_id)->where('admin_id',auth()->id())->exists())
        {
            Todo::destroy($request->todo_id);
            return 'Deleted';
        }
        else
        {
            return 'Not Exist';
        }
        
        
    }
}
