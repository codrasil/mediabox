<p class="text-sm text-gray-700 mb-0">
  <a href="{{ request()->fullUrlWithQuery(['p' => null]) }}" class="pr-1 text-blue-500 hover:text-blue-800" title="@lang('Home')"><i class="mdi mdi-home">&nbsp;</i></a>
  @foreach ($breadcrumbs as $crumb)
    <a href="{{ $crumb->url }}" class="mx-1 text-blue-500 hover:text-blue-800">
      <span class="mr-2">/</span>
      <span>@lang($crumb->text)</span>
    </a>
  @endforeach
</p>
