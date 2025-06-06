<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class UserClassification extends Model
{
    use TorkActivityLogTrait;
    protected $table='user_classifications';
    protected $guarded = [];     
    
    
    public function scopeWithUser($query)
    {
        return $query->leftJoin('users', 'user_classifications.user_id', '=', 'users.id');
    }
        
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    //RELATIONAL METHOD
                        
                            
}

?>
