<?php

namespace Codrasil\Mediabox\Concerns;

use Codrasil\Mediabox\Enums\FileKeys;
use Codrasil\Mediabox\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ZipArchive;

trait CanDownloadFiles
{
    /**
     * The ZipArchive instance.
     *
     * @var \ZipArchive
     */
    protected $zip;

    /**
     * Retrieve the url from path.
     *
     * @param  \Codrasil\Mediabox\File $file
     * @param  array                   $headers
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function fetch(File $file, $headers = [])
    {
        if (! $file->exists()) {
            throw new NotFoundHttpException('Media not found.');
        }

        return new BinaryFileResponse($file, 200, $headers);
    }

    /**
     * Download the given file.
     *
     * @param  \Codrasil\Mediabox\File $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(File $file)
    {
        if (! $file->exists()) {
            throw new NotFoundHttpException('Media not found.');
        }

        if ($file->isDir()) {
            $file = $this->zip($file->getRealPath());
        }

        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }

    /**
     * Zip the given file or folder.
     *
     * @param  string $path
     * @return mixed
     */
    public function zip($path)
    {
        $zipFileName = $path.'.zip';
        $this->zip = new ZipArchive;
        $this->zip->open($zipFileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        $this->zipFile($path);
        $this->zip->close();

        return $zipFileName;
    }

    /**
     * Zip the files in the given directory.
     *
     * @param  string $directory
     * @param  string $subDirectory
     * @return void
     */
    protected function zipFile($directory, $subDirectory = null)
    {
        $directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $files = scandir($directory.$subDirectory);

        if (count($files) <= 2) {
            $this->zip->addFromString('__EMPTY__', '');
        }

        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            if (is_file($directory.$subDirectory.$file)) {
                $this->zip->addFile($directory.$subDirectory.$file, $subDirectory.$file);
            } elseif (is_dir($directory.$subDirectory.$file)) {
                $this->zip->addEmptyDir($subDirectory.$file);
                $this->zipFile(
                    $directory,
                    $subDirectory.$file.DIRECTORY_SEPARATOR
                );
            }
        }
    }
}
