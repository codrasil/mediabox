<?php

namespace Codrasil\Mediabox\Http\Views\Composers;

use Codrasil\Mediabox\Mediabox;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilesComposer
{
    /**
     * The Request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * The Mediabox instance.
     *
     * @var \Codrasil\Mediabox\Mediabox
     */
    public $mediabox;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(Request $request, Mediabox $mediabox)
    {
        $this->request = $request;
        $this->mediabox = $mediabox;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('files', $this->getFiles());
    }

    /**
     * Retrieve the mediabox files.
     *
     * @return \Illuminate\Collections\Collection
     */
    protected function getFiles()
    {
        $files = $this->mediabox->all();

        switch ($this->request->get('order')) {
            case 'asc':
                $files = $files->sortBy($this->request->get('sort'));
                break;

            case 'desc':
                $files = $files->sortByDesc($this->request->get('sort'));
                break;
        }

        return $files;
    }
}
