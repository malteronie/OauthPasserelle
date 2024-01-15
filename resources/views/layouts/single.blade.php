<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
 
     
    @vite(['resources/css/app.css','resources/css/navbar.css', 'resources/js/app.js'])
    <style>
          [x-cloak] {display: none;}
    </style>
    
    @livewireStyles
</head>
<body>
    <div>
        <x-layouts.header />
        @include('partials.navbar')
        @include('partials.flash')
        @yield('content')
        <x-layouts.footer />
    </div>
    @livewireScripts
</body>
</html>