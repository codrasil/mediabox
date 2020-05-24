@include('mediabox::partials.head')

@section('page')
  @yield('page:header')
  @yield('page:content')
  @yield('page:footer')
@show

@include('mediabox::partials.footer')
