<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Category extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // print_r($request);
        // die();
        // return parent::toArray($request);
        file_put_contents('abc.text',$request);
        // return [
        //     'id' => $this->resource->id,
        // ];
    }
}
