<?php

namespace Base\Http\Resources;

class ThreadResource extends BaseResource
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
            "channel" => new ChannelResource($this->whenLoaded("channel")),
        ]);
    }
}
