<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserDetailShortCollection;
use App\Http\Resources\BlogCommentDetailShortCollection;
use App\Http\Resources\BlogCommentCollection;

class BlogCommentDetailCollection extends JsonResource
{

    public function toArray($request)
    {
            if ($this->resource === null) 
            {
                return [];
            }
            
            return [  
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'status' => $this->status,
                'image' => $this->image? asset($this->image):null,
                'description' => $this->description,
                'user' => new UserDetailShortCollection($this->user),
                'parent' => new BlogCommentDetailShortCollection($this->parentBlogComment),
                'childs'=> new BlogCommentCollection($this->childBlogComments()->withApproved()->get()),
            ];
    }


    public function with($request)
    {
            if ($this->resource === null) 
            {
                return [
                    'success' => false,
                    'result' => false,
                    'status' => 404
                ];
            }
            return [
                'success' => true,
                'result' => true,
                'status' => 200
            ];
    }
}