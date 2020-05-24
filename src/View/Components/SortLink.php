<?php

namespace Codrasil\Mediabox\View\Components;

use Codrasil\Mediabox\Mediabox;
use Illuminate\View\Component;

class SortLink extends Component
{
    /**
     * The text to display.
     *
     * @var string
     */
    public $label;

    /**
     * The key value used to sort.
     *
     * @var string
     */
    public $key;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $key)
    {
        $this->label = $label;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('mediabox::components.sortlink')->withLabel($this->label)->withKey($this->key);
    }
}
