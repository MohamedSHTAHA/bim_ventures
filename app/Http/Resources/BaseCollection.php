<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class BaseCollection extends ResourceCollection
{
    public $pagination;
    public $presenter;
    public function __construct($resource, $presenter = null)
    {
        // Ensure we call the parent constructor
        parent::__construct($resource);
        $this->pagination = $resource instanceof Paginator ? new PaginationResource($resource) : false;
        $this->resource = $resource instanceof Paginator ? $resource->getCollection() : $resource;

        $this->presenter = $presenter ?? BaseResource::class; // $apple param passed
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $data =  [
            'collection' => ($this->presenter)::collection($this->collection)
        ];
        if ($this->pagination)
            $data['links'] =  $this->pagination;
        return $data;
    }
}
