<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminDetailShortCollection extends JsonResource
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
                'avatar' => $this->avatar!=''? asset($this->avatar):'',
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