<?php

namespace Base\Http\Resources;

class ChannelResource extends BaseResource
{
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
