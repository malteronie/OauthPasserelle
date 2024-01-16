@extends('layouts.single')

@section('title', 'Admin : Ajout d\'un rôle')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <div class="mt-4 bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
        <h1 class="text-3xl text-blue-600 text-center mb-5">Nouveau rôle</h1>
        <form method='post' action="{{ route('admin.droits.roles.store') }}" class="p-5">
            @csrf                    
            <label for="name" class="block font-semibold text-gray-700 mb-2">Nom du rôle</label>            
            <x-input type='text' placeholder='Rôle' name='name' id='name' maxlength='32' autofocus/>             
            <x-button class="btn-create">Créer</x-button>
        </form>
        <form method="get" action="{{ route('admin.droits.roles.index') }}" class="px-5">
            <x-button class="btn-back mb-5">Retour</x-button>
        </form>
    </div>
</div>
@endsection





