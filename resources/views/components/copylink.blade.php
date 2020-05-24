{{-- COPY FORM --}}
<form action="{{ route('media.copy', $file->filename()) }}" method="post">
  @csrf
  <input type="hidden" name="name" value="{{ $file->getCopyName() }}">
  <button data-action="copy" title="@lang('Make a copy')" class="rounded hover:bg-gray-100 text-gray-600 py-1 px-3 focus:shadow-inner text-sm">
    <i class="mdi mdi-content-copy">&nbsp;</i>
  </button>
</form>
{{-- COPY FORM --}}
