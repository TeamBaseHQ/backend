<?php

namespace Base\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class InputError extends BaseResource
{
    const ERROR_MESSAGE = "The given data was invalid.";

    const ERROR_CODE = 422;

    public function __construct(array $errors)
    {
        parent::__construct($errors);
    }

    public static function build($errors)
    {
        return (new static($errors))
            ->response()
            ->setStatusCode(self::ERROR_CODE);
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
            "message" => self::ERROR_MESSAGE,
            "errors" => $this->resource,
        ];
    }
}
