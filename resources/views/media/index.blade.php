@extends('mediabox::layouts.master')

@section('page:header')
  <div class="top-0 bg-white w-full">
    <div class="flex mb-4 mt-4">
      <div class="w-4/5 md:w-2/3 mx-auto">
        <div class="flex items-center content-center mb-4 mt-4">
          <div class="w-full">
            <div class="flex items-center">
              <a href="{{ url()->getRequest()->fullUrlWithQuery(['p' => null]) }}" class="mr-2 text-2xl tracking-tight font-semi-bold hover:text-blue-800 focus:text-blue-800">{{ $mediabox->getRootFolderName() }}</a>
              <x-mediabox-breadcrumbs/>
            </div>
          </div>
          <div class="w-full">
            <div class="flex items-center justify-end">
              <x-mediabox-add-folder-link/>
              <x-mediabox-upload-link/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page:content')
  <div class="flex mb-4 mt-4 pb-20">
    <div class="w-4/5 md:w-2/3 mx-auto">
      <div class="flex content-center mb-8">
        <div class="overflow-x-auto w-full">
          <table style="min-width: max-content;" class="table table-auto w-full text-left">
            <thead>
              <tr class="border-t border-b border-gray-300">
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100">
                  <x-mediabox-sort-link label="Name" key="name"/>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-right">
                  <x-mediabox-sort-link label="Size" key="size"/>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100">
                  <x-mediabox-sort-link label="Type" key="mimetype"/>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100">
                  <x-mediabox-sort-link label="Owner" key="ownername"/>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-right">
                  <x-mediabox-sort-link label="Permission" key="permission"/>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-right">
                  <x-mediabox-sort-link label="Last modified" key="modified"/>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-center"></th>
              </tr>
            </thead>

            <tbody>
              @if ($mediabox->isEmpty())
                <tr>
                  <td colspan="100%" class="p-8 text-gray-600 text-center">
                    <i class="mdi mdi-weather-windy text-6xl"></i>
                    <div>@lang('Folder is empty')</div>
                    <a href="{{ request()->fullUrlWithQuery(['p' => null]) }}" class="text-blue-500 hover:text-blue-800 block py-4">@lang('Back to') {{ $mediabox->getRootFolderName() }}</a>
                  </td>
                </tr>
              @endif

              @foreach ($files as $file)
                <tr data-fragment="{{ $file->fragment() }}" class="{{ $file->type() }} contextmenu focus:bg-gray-200 hover:bg-gray-200" tabindex="0">
                  <td class="text-gray-900 p-2 truncate block">
                    <x-mediabox-file-link :file="$file"/>
                  </td>
                  <td class="text-gray-900 p-2 text-right">
                    @if ($file->isDir())
                      {{ $file->count() }} @lang($file->count() > 1 ? 'items' : 'item')
                    @else
                      {{ $file->size() }}
                    @endif
                  </td>
                  <td class="text-gray-900 p-2 truncate w-32 inline-block" title="{{ $file->mimetype() }}">{{ $file->mimetype() }}</td>
                  <td class="text-gray-900 p-2">{{ $file->ownername() }}</td>
                  <td class="text-gray-900 p-2 text-right">{{ $file->permission() }}</td>
                  <td class="text-gray-900 p-2 text-right">{{ $file->modified()->diffForHumans() }}</td>
                  <td class="text-gray-900 p-2 mx-auto text-right">
                    <div class="inline-flex">
                      <x-mediabox-copy-link icon="mdi mdi-content-copy" :file="$file"/>
                      <x-mediabox-rename-link icon="mdi mdi-form-textbox" :file="$file"/>
                      <x-mediabox-delete-link icon="mdi mdi-delete-outline" :file="$file"/>
                      <x-mediabox-download-link icon="mdi mdi-download-outline" :file="$file"/>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('page:footer')
  @include('mediabox::partials.statusbar')
@endsection
