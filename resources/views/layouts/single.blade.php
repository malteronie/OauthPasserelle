<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css"  rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" rel="stylesheet" />
     
    @vite(['resources/css/app.css','resources/css/navbar.css', 'resources/js/app.js'])
    <style>
          [x-cloak] {display: none;}
    </style>
    
    @livewireStyles
</head>
<body>
    <div>
        @include('partials.header')
        @include('partials.navbar')
        @include('partials.flash')
        @yield('content')
        @include('partials.footer')
    </div>
    @livewireScripts
</body>
</html>