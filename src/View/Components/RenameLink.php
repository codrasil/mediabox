<?php

namespace Codrasil\Mediabox\View\Components;

use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Mediabox;
use Illuminate\View\Component;

class RenameLink extends Component
{
    /**
     * The File instance.
     *
     * @var \Codrasil\Mediabox\File
     */
    public $file;

    /**
     * Create a new component instance.
     *
     * @param  \Codrasil\Mediabox\File $file
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('mediabox::components.renamelink')->withFile($this->file);
    }
}
