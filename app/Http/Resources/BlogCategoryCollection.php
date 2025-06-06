<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($data) 
        {
            if ($this->collection->isEmpty()) 
            {
                return [];
            }
            
            return [
                
            'id' => $data->id,
            'title' => $data->title,
            'slug' => $data->slug,
            'banner' => $data->banner? asset($data->banner):null,
            'parent_title' => $data->blogCategory?->title,
                    
            ];
        });
    }
    public function with($request)
    {
        if ($this->collection->isEmpty()) 
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