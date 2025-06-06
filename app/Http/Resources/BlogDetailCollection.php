<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BlogCategoryDetailShortCollection;
//IMPORT_CLASS
class BlogDetailCollection extends JsonResource
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
            'meta_title' => $this->meta_title,
            'meta_tags' => $this->meta_tags,
            'status' => $this->status,
            'banner' => $this->banner? asset($this->banner):null,
            'blogCategory' => new BlogCategoryDetailShortCollection($this->blogCategory),
            'short_description' => $this->short_description,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
            
            //MORE_KEYS
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