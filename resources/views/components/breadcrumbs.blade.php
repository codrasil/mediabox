<p class="text-sm text-gray-700 mb-0">
  @if (isset($attributes['home']) && $attributes['home'])
    <a href="{{ request()->fullUrlWithQuery(['p' => null]) }}" class="pr-1 text-blue-500 hover:text-blue-800 focus:text-blue-800" title="@lang('Home')"><i class="mdi mdi-home">&nbsp;</i></a>
  @endif
  @foreach ($breadcrumbs as $crumb)
    <a href="{{ route("$name.index") }}{{ $crumb->url }}" class="mx-1 text-blue-500 hover:text-blue-800">
      <span class="mr-2">/</span>
      <span>@lang($crumb->text)</span>
    </a>
  @endforeach
</p>
