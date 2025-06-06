<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCommentDetailShortCollection extends JsonResource
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
            'image' => $this->image? asset($this->image):null,
            'description' => $this->description,
            'status' => $this->status,
            ];
    }


    public function with($request)
    {
            if ($this->resource === null) 
            {
                return [
                    'success' => false,
                    'result' => false,
                    'status' => 200
                ];
            }
            return [
                'success' => true,
                'result' => true,
                'status' => 200
            ];
    }
}