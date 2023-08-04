@extends('layouts.single')

@section('title', 'Identification')

@section('content')
<div class="justify-center flex ">

    @include('shared.presentation')

    <!-- Bloc d'identification -->
    <div class="text-blue-900 w-3/12 overflow-hidden flex justify-center items-center">        
        <div class="border border-gray-400 bg-white rounded-2xl py-7 px-4 space-y-2 w-96">
            <form action="{{ route('login.submit') }}" method="post" class="flex flex-col gap-7">
                @csrf
                <label class="">
                    <span class="">Identifiant : </span>
                    <input type="text" name="login" class="px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100"/>
                </label>

                <label class="">
                    <span class="">Mot de passe : </span>
                    <input type="password" name="password" class="px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100"/>
                </label>

                <a class="mt-1 text-right text-xs" href="{{ route('forgotpwd') }}">Mot de passe oublié?</a>

                <button class="bg-indigo-500 text-white w-full rounded-2xl py-2 hover:shadow-indigo-300 hover:shadow-lg" type="submit">
                    Connexion
                </button>
            </form>

            <div class="flex-center gap-4 py-3">
                <hr class="flex-1"/>
                <p class="text-xs text-center">OU</p>
                <hr class="flex-1"/>
            </div>

            <div class="flex justify-center items-center gap-7">
                <a href="{{ route('oauth.redirect') }}" class="bg-indigo-500 p-2 text-center text-white rounded-xl w-48 hover:shadow-indigo-300 hover:shadow-lg">
                    OpenIdConnect
                </a>
            </div>
        </div>
    </div>



</div>
@endsection