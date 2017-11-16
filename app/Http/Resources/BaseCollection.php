<?php

namespace Base\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

abstract class BaseCollection extends ResourceCollection
{
    /**
     * The Resource Suffix.
     *
     * @var string
     */
    const RESOURCE_SUFFIX = "Resource";

    /**
     * Get the resource that this resource collects.
     *
     * @return string|null
     */
    protected function collects()
    {
        if ($this->collects) {
            return $this->collects;
        }

        if (Str::endsWith(class_basename($this), 'Collection') &&
            class_exists($class = Str::replaceLast('Collection', self::RESOURCE_SUFFIX, get_class($this)))) {
            return $class;
        }
    }
}
