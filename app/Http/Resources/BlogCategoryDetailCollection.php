<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BlogCategoryDetailShortCollection;
use App\Http\Resources\BlogCategoryCollection;
use App\Http\Resources\BlogCollection;
//IMPORT_CLASS
class BlogCategoryDetailCollection extends JsonResource
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
            'blogCategory' => new BlogCategoryDetailShortCollection($this->blogCategory),
            
            'blogCategories'=> new BlogCategoryCollection($this->blogCategories),
            'blogs'=> new BlogCollection($this->blogs),
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