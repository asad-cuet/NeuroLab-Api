<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
//Activity Log
use App\Traits\TorkActivityLogTrait;

class WebsiteSetting extends Model
{
    use TorkActivityLogTrait;
    protected $guarded = [];
    protected $table = 'website_settings';


}
