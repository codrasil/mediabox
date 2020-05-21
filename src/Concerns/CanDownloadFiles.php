<?php

namespace Codrasil\Mediabox\Concerns;

use Codrasil\Mediabox\Enums\FileKeys;
use Codrasil\Mediabox\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
     * Download the given file.
     *
     * @param  \Codrasil\Mediabox\File $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(File $file)
    {
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
     * @return string
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
