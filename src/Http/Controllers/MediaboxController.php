<?php

namespace Codrasil\Mediabox\Http\Controllers;

use Codrasil\Mediabox\Contracts\MediaboxInterface;
use Codrasil\Mediabox\Enums\FileKeys;
use Codrasil\Mediabox\File;
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
        return response()->json($this->mediabox->all());
    }

    /**
     * Add a file or folder to the media.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        return response()->json(
            $this->mediabox->add($request->input('name'), $request->all())->all()
        );
    }

    /**
     * Copy the file to a target destination.
     *
     * @return \Illuminate\Http\Response
     */
    public function copy()
    {
        //
    }

    /**
     * Move the file to a target destination.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        //
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
        return response()->json($this->mediabox->rename($file->filename(), $request->input('name')));
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
        return response()->json($file);
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
}
