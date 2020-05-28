<a data-action="add" role="button" href="#modal-add-folder" title="@lang($attributes['text'] ?? 'New folder')" class="rounded hover:bg-gray-100 text-gray-600 py-1 px-3 focus:shadow-inner text-sm">
  <i class="{{ $attributes['icon'] ?? 'mdi mdi-folder-plus' }}">&nbsp;</i>
  @lang($attributes['text'] ?? 'New folder')
</a>

<div id="modal-add-folder" tabindex="0" class="modal-window fixed pin z-50 overflow-auto top-0 left-0 w-screen h-screen bg-black bg-opacity-25 flex m-0">
  <div class="modal relative w-1/3 mx-auto flex-col p-8 flex">
    <form action="{{ route('media.add') }}" method="post" autocomplete="off">
      @csrf
      <div class="bg-white border border-gray-200 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-8">
          <div class="text-xl mb-3 block text-left font-semi-bold"><h4>@lang($attributes['title'] ?? 'New folder')</h4></div>
          <div class="mb-4">
            <input type="hidden" name="parent" value="{{ request()->get('p') }}">
            <input autocomplete="off" class="appearance-none shadow-inner block w-full bg-gray-200 text-gray-700 border border-gray-300 rounded py-3 px-2 leading-tight focus:outline-none focus:bg-white focus:border-blue-500 {{ $errors->has('name') ? 'border-red-500' : null }}" name="name" type="text" placeholder="@lang($attributes['placeholder'] ?? null)" value="{{ old('name') }}">
            @if ($errors->has('name'))
              <p class="text-red-500 mt-2 text-xs italic">{{ $errors->first('name') }}</p>
            @endif
          </div>
        </div>
        <div class="flex items-center justify-start space-x-4">
          <button type="submit" class="align-baseline bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 border border-blue-400 rounded shadow focus:shadow-inner">@lang('Okay')</button>
          <a role="button" class="align-baseline bg-white hover:bg-gray-200 text-gray-700 py-2 px-4 hover:text-gray-800 border rounded shadow focus:shadow-inner" href="#">@lang('Cancel')</a>
        </div>
      </div>
    </form>
  </div>
</div>
