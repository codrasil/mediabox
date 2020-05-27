@extends('mediabox::layouts.master')

@section('page:content')
  <div class="flex mb-4 mt-4 pb-20">
    <div class="w-4/5 md:w-2/3 mx-auto">
      <div class="flex content-center mb-4 mt-4">
        <div class="w-full">
          <div class="flex items-center">
            <a href="{{ route('media.index') }}" class="mr-2 text-2xl tracking-tight font-semi-bold hover:text-blue-800 focus:text-blue-800">{{ $mediabox->getRootFolderName() }}</a>
            <x-mediabox-breadcrumbs/>
          </div>
        </div>
      </div>
      <div class="flex content-center mt-4 mb-4">
        <div class="w-full">
          <a href="{{ url()->previous() }}" class="mr-2 text-sm tracking-tight hover:text-gray-800 focus:text-gray-800">
            <i class="mdi mdi-chevron-left">&nbsp;</i>
            @lang('Back')
          </a>
        </div>
      </div>

      <div class="flex content-center mb-8">
        <div class="w-full h-auto rounded shadow-lg bg-transparent border border-gray-200 overflow-x-hidden">
          <embed style="min-height: 800px;" class="w-full block object-scale-down bg-gray-300" width="100%" height="auto" src="{{ route('storage.show', $file->filename()) }}" type="{{ $file->mimetype() }}">
        </div>
      </div>
    </div>
  </div>
@endsection
