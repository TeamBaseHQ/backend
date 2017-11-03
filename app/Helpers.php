<?php

namespace Base;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

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
}
