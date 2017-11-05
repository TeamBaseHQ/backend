<?php

namespace Base;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

abstract class Helpers
{
    public static function requireAllFilesInDirectory(string $dir = "")
    {
        $directoryIterator = new RecursiveDirectoryIterator($dir);
        $iterator = new RecursiveIteratorIterator($directoryIterator);

        foreach ($iterator as $file) {
            $fileName = $file->getFilename();
            $filePath = $file->getRealPath();
            $fileIsValid = !$file->isDir() && ($fileName !== "." || $fileName !== "..");

            if ($fileIsValid) {
                require_once $filePath;
            }
        }
    }

    /**
     * Registers Media Conversions.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $conversions
     */
    public static function registerConversions(Model $model, array $conversions)
    {
        foreach ($conversions as $name => $conversion) {
            $mediaConversion = $model->addMediaConversion($name);

            foreach ($conversion as $prop => $value) {
                $mediaConversion->{$prop}($value);
            }
        }
    }
}
