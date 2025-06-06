<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryDetailShortCollection extends JsonResource
{
    public function toArray($request)
    {
            if ($this->resource === null) 
            {
                return [];
            }
            
            return [
                
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'banner' => $this->banner? asset($this->banner):null,
            
            
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