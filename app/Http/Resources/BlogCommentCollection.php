<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCommentCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->processCollection($this->collection);
    }

    protected function processCollection($collection)
    {
        return $collection->map(function ($data) use ($collection) {

            if ($collection->isEmpty()) {
                return [];
            }

            $childs = $this->processCollection($data->childBlogComments()->orderBy('id','desc')->get());

            return [
                'id' => $data->id,
                'name' => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
                'status' => $data->status,
                'image' => $data->image? asset($data->image):null,
                'user_name' => $data->user?->name,
                'parent_id' => $data->blogComment?->id,
                'description' => $data->description,
                'childs' => $childs,
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