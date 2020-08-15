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

class MediaboxApiController extends Controller
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
        return MediaResource::collection($this->mediabox->all());
    }

    /**
     * Add a file or folder to the media.
     *
     * @param  \Codrasil\Mediabox\Http\Requests\MediaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function add(MediaRequest $request)
    {
        return response()->json(
            $this->mediabox->add($request->input('name'), $request->all())->all()
        );
    }

    /**
     * Copy the file to a target destination.
     *
     * @param  \Codrasil\Mediabox\File $file
     * @return \Illuminate\Http\Response
     */
    public function copy(File $file)
    {
        return response()->json($this->mediabox->copy($file->getRealpath(), $file->getCopyName()));
    }

    /**
     * Move the file to a target destination.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        return response()->json();
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
        return response()->json($this->mediabox->rename($file->filename(), $request->all()));
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
        return new MediaResource($file);
    }

    /**
     * Remove the specified file from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        return response()->json(
            $this->mediabox->delete($request->input('paths'))
        );
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
}
