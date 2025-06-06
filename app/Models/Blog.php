<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Blog extends Model implements HasMedia
{
    use TorkActivityLogTrait,InteractsWithMedia;
    protected $table='blogs';
    protected $guarded = [];     
    
    
    public function scopeWithBlogCategory($query)
    {
        return $query->leftJoin('blog_categories', 'blogs.blog_category_id', '=', 'blog_categories.id');
    }
                            
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id','id');
    }
                            
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class,'blog_id','id');
    }

    public function scopeWithPublished($query)
    {
        return $query->where('status','published');
    }


    public function registerMediaColections()
    {
        $this->addMediaCollection('banners')
            ->singleFile();
    }
    
    //RELATIONAL METHOD
                        
                            
}

?>
