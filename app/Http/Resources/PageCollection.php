<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
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
            'banner' => $data->banner? asset($data->banner):null,
            'author_admin_name' => $data->admin?->name,
            'content' => $data->content,
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