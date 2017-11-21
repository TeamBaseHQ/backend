<?php

namespace Base\Media;

use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class MediaPathGenerator implements PathGenerator
{
    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'c/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     * @return string
     */

    public function getPath(Media $media): string
    {
        return $media->name . '/';
    }
}
