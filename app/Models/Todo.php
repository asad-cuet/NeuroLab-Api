<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class Todo extends Model
{
    use HasFactory,TorkActivityLogTrait;
    protected $table='todos';
    protected $guarded=[];

}
