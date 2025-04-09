@extends('layouts.single')

@section('title', 'Identification')

@section('content')
<div class="justify-center flex ">

    <x-presentation />

    <!-- Bloc d'identification -->
    <div class="text-blue-900 w-3/12 overflow-hidden flex justify-center items-center">        
        <div class="border border-gray-400 bg-white rounded-2xl py-7 px-4 space-y-2 w-96">
            <form action="{{ route('login.submit') }}" method="post" class="flex flex-col gap-5">
                @csrf
                
                <x-input type="text" id="login" name="login">Identifiant : </x-input>
                
                <x-input type="password" id="password" name="password">Mot de passe : </x-input>
                <a href="{{route('oauth.redirect')}}"><img src="{{asset('oauth.png')}}" style="width: 50px; height:50px" alt="oauth"></a>
                <a class="mt-1 text-right text-xs" href="{{ route('forgotpwd') }}">Mot de passe oublié?</a>

                <x-button class="btn-blue py-2">Connexion</x-button>
            </form>
            @if (env('APP_ONLINE'))
                <div class="flex-center gap-4 py-3">
                    <hr class="flex-1"/>
                    <p class="text-xs text-center">OU</p>
                    <hr class="flex-1"/>
                </div>

                <div class="flex justify-center items-center gap-7">
                    <form action="{{ route('oauth.redirect') }}" method="get">
                        <x-button class="btn-add">OpenIdConnect</x-button>
                    </form>
                </div>                                
            @endif
        </div>
    </div>
</div>
@endsection