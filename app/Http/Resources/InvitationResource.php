<?php

namespace Base\Http\Resources;

class InvitationResource extends BaseResource
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
            "team" => $this->whenLoaded('team'),
        ]);
    }
}
