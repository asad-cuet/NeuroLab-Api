<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
//Activity Log
use App\Traits\TorkActivityLogTrait;

use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;


class Admin extends Authenticatable implements CanVisit, HasMedia
{
    use Notifiable, HasRoles, TorkActivityLogTrait, HasVisits, InteractsWithMedia, SoftDeletes;



    protected $guard = 'admin';

    protected $table = 'admins';
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'avatar', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isSuperAdmin()
    {
        if($this->hasRole('Super Admin'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function roles()
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            'role_id'
        );
    }

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new AdminResetPasswordNotification($token));
    // }

    public function registerMediaCollections(): void
    {
        $this->addMediaConversion('thumb')
        ->width(100)
            ->height(100);


        $this->addMediaConversion('preview')
        ->fit(
            Manipulations::FIT_CROP,
            300,
            300
        )
            ->nonQueued();
    }

}
