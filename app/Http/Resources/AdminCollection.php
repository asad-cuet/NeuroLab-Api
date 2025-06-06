<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            if ($this->collection->isEmpty()) 
            {
                return [];
            }
            return [
            'id' => $data->id,
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'avatar' => $data->avatar? asset($data->avatar):null,
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