<?php

namespace Base\Http\Resources;

class MediaResource extends BaseResource
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
        $data = parent::toArray($request);

        // Remove unwanted properties
        array_forget($data, ['model_id', 'model_type', 'order_column', 'disk']);

        return array_merge($data, [
            'url' => $this->getUrlsForAllConversions()
        ]);
    }

    /**
     * Get URLs for all the conversions.
     *
     * @return array Expected output: [ 'conversionName' => 'conversionUrl' ]
     */
    protected function getUrlsForAllConversions()
    {
        // [ 'icon', 'thumb', 'medium', 'large', 'original' ]
        $conversions = collect($this->resource->getMediaConversionNames())
            ->mapWithKeys(function ($conversionName) {
                return [$conversionName => $this->resource->getFullUrl($conversionName)];
            })->toArray();

        return array_merge($conversions, [
            'original' => $this->resource->getFullUrl(),
        ]);
    }
}
