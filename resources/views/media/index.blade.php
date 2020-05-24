@extends('mediabox::layouts.master')

@section('page:content')
  <div class="flex mb-4 mt-4 pb-20">
    <div class="w-4/5 md:w-2/3 mx-auto">
      <div class="flex content-center mb-8">
        <div class="w-full">
          <div class="flex justify-between">
            <h2 class="inline-block text-2xl tracking-tight font-semi-bold">{{ $mediabox->getRootFolderName() }}</h2>
          </div>
        </div>
      </div>

      <div class="flex content-center mb-1">
        <div class="w-full">
          <x-mediabox-breadcrumbs></x-mediabox-breadcrumbs>
        </div>
      </div>

      <div class="flex content-center mb-8">
        <div class="overflow-x-auto w-full">
          <table class="table table-auto w-full text-left">
            <thead>
              <tr class="border-t border-b border-gray-300">
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100">
                  <x-mediabox-sort-link label="Name" key="name"></x-mediabox-sort-link>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-right">
                  <x-mediabox-sort-link label="Size" key="size"></x-mediabox-sort-link>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100">
                  <x-mediabox-sort-link label="Type" key="mimetype"></x-mediabox-sort-link>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100">
                  <x-mediabox-sort-link label="Owner" key="ownername"></x-mediabox-sort-link>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-right">
                  <x-mediabox-sort-link label="Permission" key="permission"></x-mediabox-sort-link>
                </th>
                <th class="text-gray-600 font-semibold mb-0 text-xs uppercase p-2 bg-gray-100 text-right">
                  <x-mediabox-sort-link label="Last modified" key="modified"></x-mediabox-sort-link>
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
                    @if ($file->isDir())
                      <a tabindex="-1" href="{{ $file->fragment() }}" class="contextmenu-target hover:text-blue-800">
                        <span class="pr-2"><i class="{{ $file->icon() }}">&nbsp;</i></span>
                        {{ $file->name() }}
                      </a>
                    @else
                      <a tabindex="-1" data-action="preview" target="_blank" href="{{ route('media.show', $file->filename()) }}" class="contextmenu-target hover:text-blue-800">
                        <span class="pr-2"><i class="{{ $file->icon() }}">&nbsp;</i></span>
                        {{ $file->name() }}
                      </a>
                    @endif
                  </td>
                  <td class="text-gray-900 p-2 text-right">
                    @if ($file->isDir())
                      {{ $file->count() }} @lang($file->count() > 1 ? 'items' : 'item')
                    @else
                      {{ $file->size() }}
                    @endif
                  </td>
                  <td class="text-gray-900 p-2 truncate w-32" title="{{ $file->mimetype() }}">{{ $file->mimetype() }}</td>
                  <td class="text-gray-900 p-2">{{ $file->ownername() }}</td>
                  <td class="text-gray-900 p-2 text-right">{{ $file->permission() }}</td>
                  <td class="text-gray-900 p-2 text-right">{{ $file->modified()->diffForHumans() }}</td>
                  <td class="text-gray-900 p-2 mx-auto text-right">
                    <div class="inline-flex space-x-2">
                      <x-mediabox-copy-link :file="$file"></x-mediabox-copy-link>
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
