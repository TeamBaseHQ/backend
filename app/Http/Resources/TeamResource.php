<?php

namespace Base\Http\Resources;

class TeamResource extends BaseResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            "owner" => new UserResource($this->resource->owner),
        ]);
    }
}
