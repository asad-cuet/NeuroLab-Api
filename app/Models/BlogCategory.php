<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class BlogCategory extends Model
{
    use TorkActivityLogTrait;
    protected $table='blog_categories';
    protected $guarded = [];     
    
    
    public function scopeWithBlogCategory($query)
    {
        return $query->leftJoin('blog_categories', 'blog_categories.parent_id', '=', 'blog_categories.id');
    }
        
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class,'parent_id','id');
    }
    
    public function blogCategories()
    {
        return $this->hasMany(BlogCategory::class,'parent_id');
    }
    
    public function blogs()
    {
        return $this->hasMany(Blog::class,'blog_category_id');
    }
    //RELATIONAL METHOD
                        
                        
                        
                            
}

?>
