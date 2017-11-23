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
        $data = parent::toArray($request);
        array_forget($data, ['media']);

        $media = $this->resource->getMedia('team_picture')->first();

        if ($media) {
            $media = (new MediaResource($media))->toArray($request);
        }

        return array_merge($data, [
            "owner" => new UserResource($this->resource->owner),
            'picture' => $this->when(!is_null($media), $media),
        ]);
    }
}
