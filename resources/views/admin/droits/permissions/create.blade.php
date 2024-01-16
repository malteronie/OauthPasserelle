@extends('layouts.single')

@section('title', 'Admin : Ajout d\'une permission')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <div class="mt-4 bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
        <h1 class="text-3xl text-blue-600 text-center mb-5">Nouvelle permission</h1>
        <form method='post' action="{{ route('admin.droits.permissions.store') }}" class=" p-5 mb-5">
            @csrf                    
            <label for="name" class="block font-semibold text-gray-700 mb-2">Nom de la permission</label>            
            <x-input type='text' placeholder='Permission' name='name' id='name' maxlength='32' autofocus></x-input>
            
            <x-button class="btn-create">Créer</x-button>
            
            <input class="bg-orange-500 text-white hover:bg-orange-700 transition ease-in-out duration-500 rounded-md shadow-md w-full block px-4 py-2 mt-3" type="button" value="Retour" onclick="history.back()"  />
            <x-button class="btn-back block">Retour</x-button>
        </form>
    </div>
</div>
@endsection





