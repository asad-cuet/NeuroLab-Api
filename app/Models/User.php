<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Auth;

//Activity Log
use App\Traits\TorkActivityLogTrait;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia,MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TorkActivityLogTrait;
    use SoftDeletes;
    use HasVisits,InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country_code',
        'notify_by',
        'signup_by',
        'email',
        'phone',
        'avatar',
        'provider',
        'password',
        'facebook_id',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'notify_by',
        'signup_by',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    // protected $appends = ['avatar']; // Append the custom attribute

    // public function getAvatarAttribute()
    // {
    //     return $this->attributes['avatar'] ? asset($this->attributes['avatar']) : null;
    // }

    public function registerMediaColections()
    {
        $this->addMediaCollection('avatars')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    //RELATIONAL METHOD
}
