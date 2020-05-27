@if ($file->isDir())
  <a tabindex="-1" href="{{ $file->fragment() }}" class="contextmenu-target hover:text-blue-800 focus:outline-none focus:text-blue-800">
    <span class="pr-3"><i class="{{ $file->icon() }}">&nbsp;</i></span>
    {{ $file->name() }}
  </a>
@else
  <a tabindex="-1" data-action="preview" href="{{ route('media.show', [$file->filename(), 'p' => $file->dirname()]) }}" class="contextmenu-target hover:text-blue-800 focus:outline-none focus:text-blue-800">
    <span class="pr-3"><i class="{{ $file->icon() }}">&nbsp;</i></span>
    {{ $file->name() }}
  </a>
@endif
