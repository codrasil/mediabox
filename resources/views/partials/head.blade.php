<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
  <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no">

  <title>
    @section('head:title'){{ config('app.name') }}@show
    @yield('head:subtitle')
  </title>

  @stack('tokens')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @show

  @stack('css')
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.2.45/css/materialdesignicons.min.css">
  @show
</head>
<body>
