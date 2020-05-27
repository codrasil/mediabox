<?php

namespace Codrasil\Mediabox\Concerns;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait CanUploadFiles
{
    /**
     * Retrieve the file to storage.
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile|array $file
     * @param  string                                                    $destination
     * @return __CLASS__
     */
    public function upload($file, $destination = null)
    {
        if (is_array($file)) {
            $file = new UploadedFile($file['tmp_name'], $file['name']);
        }

        if ($file instanceof UploadedFile) {
            $file->move($this->rootPath($destination), $file->getClientOriginalName());
        }

        return $this;
    }
}
