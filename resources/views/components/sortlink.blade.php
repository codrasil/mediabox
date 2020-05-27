@if ($key == request()->get('sort'))
  @switch (request()->get('order'))
    @case ('asc')
      <a href="{{ request()->fullUrlWithQuery(['sort' => $key, 'order' => 'desc']) }}">
        @lang($label)
        <i class="{{ $attributes['ascending-icon'] ?? 'mdi mdi-sort-ascending' }}">&nbsp;</i>
      </a>
      @break
    @case ('desc')
      <a href="{{ request()->fullUrlWithQuery(['sort' => null, 'order' => null]) }}">
        @lang($label)
        <i class="{{ $attributes['descending-icon'] ?? 'mdi mdi-sort-descending' }}">&nbsp;</i>
      </a>
      @break
  @endswitch
@else
  <a href="{{ request()->fullUrlWithQuery(['sort' => $key, 'order' => 'asc']) }}">
    @lang($label)
  </a>
@endif
