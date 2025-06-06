<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminDetailShortCollection;
//IMPORT_CLASS
class PageDetailCollection extends JsonResource
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
            'banner' => $this->banner? asset($this->banner):null,
            'admin' => new AdminDetailShortCollection($this->admin),
            'content' => $this->content,
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