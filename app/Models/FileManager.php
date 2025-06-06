<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;

class FileManager extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table='file_managers';
    protected $guarded=[];

    protected $fillable = [
        'name', 'is_active', 'created_by', 'updated_by',
    ];


    public function registerMediaCollections(): void
{

            $this
                ->addMediaConversion('thumb')
                ->width(100)
                ->height(100);


                $this
        ->addMediaConversion('preview')
        ->fit(Manipulations::FIT_CROP, 300, 300)
        ->nonQueued();
}

}
