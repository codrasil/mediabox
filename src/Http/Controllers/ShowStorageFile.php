<?php

namespace Codrasil\Mediabox\Http\Controllers;

use Codrasil\Mediabox\Contracts\MediaboxInterface;
use Codrasil\Mediabox\File;
use Illuminate\Routing\Controller;

class ShowStorageFile extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Codrasil\Mediabox\File                        $file
     * @param  \Codrasil\Mediabox\Contracts\MediaboxInterface $mediabox
     * @return \Illuminate\Http\Response
     */
    public function __invoke(File $file, MediaboxInterface $mediabox)
    {
        return $mediabox->fetch($file);
    }
}
