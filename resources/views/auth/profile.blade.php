@extends('layouts.single')

@section('title', 'Mon profil')

@section('content')
<h1 class="text-3xl text-blue-600 text-center mb-5">Fiche profil de {{ $user->first_name }} {{ $user->last_name }}</h1>
<div class="justify-center flex mt-4">
    <div class="3/12">
 
    </div>
    <div class="justify-center shadow shadow-lg w-6/12 rounded-2xl py-3 px-4">
        <div class="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">Grade : </h2>
            <h2 class="text-xl mt-2 text-gray-400"> &nbsp{{ $user->rank }}</h2>
        </div>
        <div class="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">Nom : </h2>
            <h2 class="text-xl mt-2 text-gray-400"> &nbsp{{ $user->last_name }}</h2>
        </div>
        <div class="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">Prénom : </h2>
            <h2 class="text-xl mt-2 text-gray-400">&nbsp{{ $user->first_name }}</h2>
        </div>
        <div class="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">identifiant : </h2>
            <h2 class="text-xl mt-2 text-gray-400"> &nbsp{{ $user->login }}</h2>
        </div>
        <div class="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">E-Mail : </h2>
            <h2 class="text-xl mt-2 text-gray-400"> &nbsp{{ $user->email }}</h2>
        </div>
        <div class="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">Etat du compte : </h2>
            <h2 class="text-xl mt-2 {{ $user->active == 0 ? 'text-red-600' : 'text-green-600' }}"> &nbsp{{ $user->active == 1 ? ' Activé' : ' Désactivé' }}</h2>
        </div>
        <div class ="flex">
            <h2 class="text-xl mt-2 font-semibold text-blue-400">Affectation :  </h2>
            <h2 class="text-xl mt-2 text-gray-400"> &nbsp{{ $user->affectation_annudef }}</h2>
        </div>
        <div class ="flex">
        <h2 class="text-xl mt-2 font-semibold text-blue-400">Rôles attribués :</h2> 
        @foreach ($user->roles as $role)

            <h2 class="text-xl mt-2 text-gray-400"> &nbsp{{ $role->name }} </h2>
            
        @endforeach    
        </div> 
        
        <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ route('dashboard') }}" class="w-48">
            <x-button class="btn-back">Retour</x-button>
        </form>
        </div>
    </div>
    <div class="3/12">

    </div>


</div>
@endsection