<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no">

  <title>
    @section('app:title'){{ config('app.name') }}@show
    @yield('app:subtitle')
  </title>

  @section('css')
  @mediaboxStyles
  @show

</head>
<body>
