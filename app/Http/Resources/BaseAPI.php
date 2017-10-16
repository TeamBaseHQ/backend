<?php

namespace Base\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BaseAPI extends Resource
{
    public function __construct($resource = null)
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
        return [
            "title" => config('app.name', "Base") . " API",
            "version" => env('APP_VERSION', '1.0'),
        ];
    }
}
