@extends('layouts.single')

@section('title', 'Admin : Ajout d\'un utilisateur')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <div class="mt-4 bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
        <h1 class="text-3xl text-blue-600 text-center mb-5">Nouvel utilisateur</h1>

        <form method='post' action="{{ route('admin.droits.users.store') }}" class="p-5">
        @csrf                    
            <label for="login" class="block font-semibold text-gray-700 mb-2">Identifiant (identique à l'Intradef)</label>            
            <input type='text' placeholder='Identifiant' name='login' id='login' class="  px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" maxlength='32' autofocus>                       
            <label for="email" class="block font-semibold text-gray-700 mt-2 mb-2">E-mail</label>            
            <input type='email' placeholder='E-mail' name='email' id='email' class="mb-2  px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" maxlength='32' autofocus>                       
            <x-button class="btn-create py-2">Créer</x-button>
        </form>
        <form method="get" action="{{ route('admin.droits.users.index') }}" class="px-5">
            <x-button class="btn-back mb-5">Retour</x-button>
        </form>
    </div>
</div>
@endsection