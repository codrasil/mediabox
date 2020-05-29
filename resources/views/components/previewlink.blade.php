<a data-action="preview" role="button" href="{{ route('storage.show', $file->filename()) }}" title="@lang($attributes['text'] ?? 'Preview')" class="rounded hover:bg-gray-100 text-gray-600 py-1 px-3 focus:shadow-inner text-sm">
  <i class="{{ $attributes['icon'] ?? 'mdi mdi-link' }}">&nbsp;</i>
</a>
