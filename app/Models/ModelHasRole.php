<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
//Activity Log
use App\Traits\TorkActivityLogTrait;

class ModelHasRole extends Model
{
    use HasFactory,TorkActivityLogTrait;

    protected $guarded = [];

}
