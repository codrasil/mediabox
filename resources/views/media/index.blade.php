@extends('mediabox::layouts.master')

@section('page:content')

  <div>
    @foreach ($mediabox->breadcrumbs() as $crumb)
      <a href="{{ $crumb->url }}">{{ $crumb->text }}</a>
    @endforeach
  </div>

  <div class="flex p-4">
    <div class="overflow-x-auto">
      <table style="min-width: max-content;" class="table-auto w-full text-left table-collapse">
        <thead>
          <tr class="border-t border-b border-gray-300">
            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">@lang('File')</th>
            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100 text-right">@lang('Size')</th>
            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">@lang('Type')</th>
            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">@lang('Owner')</th>
            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100 text-right">@lang('Permission')</th>
            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100 text-right">@lang('Last Modified')</th>
            <th class="text-sm text-center font-semibold text-gray-700 p-2 bg-gray-100">@lang('Actions')</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mediabox->all() as $file)
            <tr>

            @if ($file->isDir())
              <td>{{ $file->name() }}</td>
            @else
              <td>{{ $file->name() }}</td>
            @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
