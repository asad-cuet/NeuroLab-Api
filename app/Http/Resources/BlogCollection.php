<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCollection extends ResourceCollection
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
            'meta_title' => $data->meta_title,
            'meta_tags' => $data->meta_tags,
            'status' => $data->status,
            'banner' => $data->banner? asset($data->banner):null,
            'blog_category_title' => $data->blogCategory?->title,
                    'short_description' => $data->short_description,
            'description' => $data->description,
            'meta_description' => $data->meta_description,
            
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