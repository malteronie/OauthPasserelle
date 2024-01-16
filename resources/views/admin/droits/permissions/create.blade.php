@extends('layouts.single')

@section('title', 'Admin : Ajout d\'une permission')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <div class="mt-4 bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
        <h1 class="text-3xl text-blue-600 text-center mb-5">Nouvelle permission</h1>
        <form method='post' action="{{ route('admin.droits.permissions.store') }}" class="p-5">
            @csrf                    
            <label for="name" class="block font-semibold text-gray-700 mb-2">Nom de la permission</label>            
            <x-input type='text' placeholder='Permission' name='name' id='name' maxlength='32' autofocus></x-input>            
            <x-button class="btn-create">Créer</x-button>
        </form>
        <form method="get" action="{{ route('admin.droits.permissions.index') }}" class="px-5">
            <x-button class="btn-back mb-5">Retour</x-button>
        </form>
    </div>
</div>
@endsection





