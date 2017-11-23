<?php

namespace Base\Http\Resources;

use Base\Models\User;
use Illuminate\Http\Resources\MissingValue;

class MessageResource extends BaseResource
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
        if ($this->sentByUser()) {
            $sender = new UserResource($this->resource->sender);
        } else {
            $sender = new UserResource($this->resource->sender);
        }

        $attachments = $this->resource->attachments;

        return array_merge(parent::toArray($request), [
            "sender" => $sender,
            "attachments" => $this->when($attachments && count($attachments), new MediaCollection($attachments)),
        ]);
    }

    private function sentByUser()
    {
        return $this->resource->sender instanceof User;
    }

    private function sentByBot()
    {
        return !$this->resource->sender instanceof User;
    }
}
