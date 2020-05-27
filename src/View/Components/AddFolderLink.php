<?php

namespace Codrasil\Mediabox\View\Components;

use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Mediabox;
use Illuminate\View\Component;

class AddFolderLink extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('mediabox::components.addfolderlink');
    }
}
