<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
//Activity Log
use App\Traits\TorkActivityLogTrait;

class Setting extends Model
{
    use TorkActivityLogTrait;
    protected $guarded = [];


}
