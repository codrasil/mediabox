<?php

namespace Codrasil\Mediabox\Http\Controllers;

use Codrasil\Mediabox\Contracts\MediaboxInterface;
use Codrasil\Mediabox\Enums\FileKeys;
use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Http\Requests\MediaRequest;
use Codrasil\Mediabox\Http\Requests\UploadRequest;
use Codrasil\Mediabox\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MediaboxController extends Controller
{
    /**
     * The Mediabox instance.
     *
     * @var \Codrasil\Mediabox\Mediabox
     */
    protected $mediabox;

    /**
     * Create a new controller instance.
     *
     * @param \Codrasil\Mediabox\Contracts\MediaboxInterface $mediabox
     */
    public function __construct(MediaboxInterface $mediabox)
    {
        $this->mediabox = $mediabox;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('mediabox.routes.web.views.index'))->withMediabox($this->mediabox);
    }

    /**
     * Add a file or folder to the media.
     *
     * @param  \Codrasil\Mediabox\Http\Requests\MediaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function add(MediaRequest $request)
    {
        $this->mediabox->add($request->input('name'), $request->all());

        return back();
    }

    /**
     * Upload the passed in file to storage.
     *
     * @param  \Codrasil\Mediabox\Http\Requests\UploadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function upload(UploadRequest $request)
    {
        $this->mediabox->upload($request->file('file'), $request->input('parent'));

        return back();
    }

    /**
     * Copy the file to a target destination.
     *
     * @param  \Codrasil\Mediabox\File $file
     * @return \Illuminate\Http\Response
     */
    public function copy(File $file)
    {
        $this->mediabox->copy($file->getRealpath(), $file->getCopyName());

        return back();
    }

    /**
     * Move the file to a target destination.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $this->mediabox->move($request->input('name'), $request->input('target'));

        return back();
    }

    /**
     * Move the file to a target destination.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Codrasil\Mediabox\File  $file
     * @return \Illuminate\Http\Response
     */
    public function rename(Request $request, File $file)
    {
        $this->mediabox->rename($file->filename(), $request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Codrasil\Mediabox\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, File $file)
    {
        return view(config('mediabox.routes.web.views.show'))->withMediabox($this->mediabox)->withFile($file);
    }

    /**
     * Remove the specified file from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $this->mediabox->delete($request->input('name'));

        return back();
    }
}
