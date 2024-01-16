@extends('layouts.single')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="py-7 text-blue-900 w-screen overflow-hidden flex justify-center items-center flex-col gap-7">        
    <div class="border border-gray-400 bg-white rounded-2xl py-7 px-4 space-y-2 w-96">
        <form action="{{ route('forgotpwd.submit') }}" method="post" class=" flex-col gap-7">
            @csrf
            
            <x-input type="email" name="email" id="email">Email : </x-input>

            <x-button class="btn-create">Demander un nouveau mot de passe</x-button>
           
        </form>
    </div>
    <div class="bg-white rounded-2xl py-3 px-4 w-48">
        <form method="get" action="{{ URL::previous() }}">
           
            <x-button class="btn-back">Retour</x-button>
        </form>
    </div>
</div>    
@endsection