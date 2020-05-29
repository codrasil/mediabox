<a data-action="download" role="button" href="{{ route('storage.download', $file->filename()) }}" title="@lang($attributes['text'] ?? 'Download')" class="rounded hover:bg-gray-100 text-gray-600 py-1 px-3 focus:shadow-inner text-sm">
  <i class="{{ $attributes['icon'] ?? 'mdi mdi-download-outline' }}">&nbsp;</i>
</a>
