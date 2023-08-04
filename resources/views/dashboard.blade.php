@extends('layouts.single')

@section('title', 'Accueil')

@section('content')

@if (Auth::user()->active == 0)
<div class="justify-center flex ">

    @include('shared.presentation')
    <div class="text-blue-900 w-3/12 overflow-hidden p-2 justify-center items-center">
        <h1 class="text-blue-700 text-3xl text-center mt-36">Bienvenue {{ auth()->user()->name }}</h1>
        <h2 class="text-red-600 text-2xl text-center mt-8">Votre compte n'est pas encore activé</h2>
        <h2 class="text-blue-600 text-2xl text-center mt-8">Lorsque cela serait fait, vous serez avertis par mail.</h2>
    </div>        
</div>
@else
    <h1 class="text-blue-700 text-3xl text-center mt-8">Bienvenue {{ auth()->user()->name }}</h1>
    <h2 class="text-blue-600 text-2xl text-center mt-8">Vous êtes sur le tableau de bord de l'application {{ env('APP_NAME') }}</h2>
@endif

@endsection