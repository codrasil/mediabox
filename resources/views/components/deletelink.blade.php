<a data-action="delete" role="button" href="#modal-delete-{{ $file->fragment() }}" title="@lang($attributes['text'] ?? 'Delete')" class="rounded hover:bg-gray-100 text-gray-600 py-1 px-3 focus:shadow-inner text-sm">
  <i class="{{ $attributes['icon'] ?? 'mdi mdi-delete-outline' }}">&nbsp;</i>
</a>

<div id="modal-delete-{{ $file->fragment() }}" tabindex="0" class="modal-window fixed pin z-50 overflow-auto top-0 left-0 w-screen h-screen bg-black bg-opacity-25 flex m-0 space-x-0">
  <div class="modal relative w-1/3 mx-auto flex-col p-8 flex">
    <form action="{{ route('media.delete', $file->filename()) }}" method="post">
      @csrf
      @method('delete')
      <div class="bg-white border border-gray-200 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-8">
          <div class="text-xl mb-3 block text-left font-semi-bold"><h4>@lang($attributes['title'] ?? 'Delete')</h4></div>
          <div class="text-left mb-4">
            <p>@lang('Are you sure you want to delete the file?')</p>
            <input type="hidden" name="name" value="{{ $file->filename() }}">
          </div>
        </div>
        <div class="flex items-center justify-start space-x-4">
          <button type="submit" class="align-baseline bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 border border-blue-400 rounded shadow focus:shadow-inner">@lang($attributes['text'] ?? 'Delete')</button>
          <a role="button" class="align-baseline bg-white hover:bg-gray-200 text-gray-700 py-2 px-4 hover:text-gray-800 border rounded shadow focus:shadow-inner" href="#">@lang('Cancel')</a>
        </div>
      </div>
    </form>
  </div>
</div>
