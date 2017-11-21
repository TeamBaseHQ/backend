<?php

namespace Base\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @param mixed $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        array_forget($data, ['media']);

        return array_merge($data, [
            'picture' => new MediaResource($this->resource->media->first()),
        ]);
    }
}
