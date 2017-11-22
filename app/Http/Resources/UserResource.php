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

        $media = $this->resource->media->first();
        if ($media) {
            $media = (new MediaResource($media))->toArray($request);
        }

        return array_merge($data, [
            'picture' => $this->when(!is_null($media), $media),
        ]);
    }
}
