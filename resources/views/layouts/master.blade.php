@include('mediabox::partials.head')

@section('page')

  <div class="container mx-auto">
    <div class="w-full">
      @yield('page:title')
    </div>
    <div class="w-full">
      @yield('page:content')
    </div>
  </div>

@show

@include('mediabox::partials.footer')
