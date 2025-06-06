<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CommonThingsController extends Controller
{
    public function toggleSwitchStatus(Request $request) {
        $table=$request->table;
        $column=$request->column;
        $id=$request->id;
        $value=$request->value;

        DB::table($table)->where('id',$id)->update([
            $column=>$request->value
          ]);


        return 1;
    }
}
