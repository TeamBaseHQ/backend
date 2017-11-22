<?php

namespace Base\Http\Resources;

class MediaCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @param mixed $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
