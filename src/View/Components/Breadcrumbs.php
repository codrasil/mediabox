<?php

namespace Codrasil\Mediabox\View\Components;

use Codrasil\Mediabox\Mediabox;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * The Mediabox instance.
     *
     * @var \Codrasil\Mediabox\Mediabox
     */
    public $mediabox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Mediabox $mediabox)
    {
        $this->mediabox = $mediabox;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('mediabox::components.breadcrumbs')->withBreadcrumbs($this->mediabox->breadcrumbs());
    }
}
