<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class BlogComment extends Model
{
    use TorkActivityLogTrait;
    protected $table='blog_comments';
    protected $guarded = [];     
    
    
    public function scopeWithUser($query)
    {
        return $query->leftJoin('users', 'blog_comments.user_id', '=', 'users.id');
    }
                            
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function scopeWithBlogComment($query)
    {
        return $query->leftJoin('blog_comments', 'blog_comments.parent_id', '=', 'blog_comments.id');
    }
    
    public function scopeWithApproved($query)
    {
        return $query->where('status','approved');
    }
        
    public function parentBlogComment()
    {
        return $this->belongsTo(BlogComment::class,'parent_id','id');
    }
    
    public function childBlogComments()
    {
        return $this->hasMany(BlogComment::class,'parent_id');
    }
    //RELATIONAL METHOD
                        
                        
                            
                        
                            
}

?>
