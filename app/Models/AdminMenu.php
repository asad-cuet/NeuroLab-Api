<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\TorkActivityLogTrait;

class AdminMenu extends Model
{

    use TorkActivityLogTrait;

    protected $table='admin_menus';

    protected $guarded=[];
    //Activity Log start here






}
