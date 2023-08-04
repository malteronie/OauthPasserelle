@extends('layouts.single')

@section('title', 'Admin : Ajout d\'un rôle')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <div class="mt-4 bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
        <h1 class="text-3xl text-blue-600 text-center mb-5">Nouveau rôle</h1>
        <form method='post' action="{{ route('admin.droits.roles.store') }}" class=" p-5 mb-5">
            @csrf                    
            <label for="name" class="block font-semibold text-gray-700 mb-2">Nom du rôle</label>            
            <input type='text' placeholder='Rôle' name='name' id='name' class="  px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" maxlength='32' autofocus>                       
            
            <button type="submit" class="bg-blue-500 text-white hover:bg-blue-700 transition ease-in-out duration-500 rounded-md shadow-md w-full block px-4 py-2 mt-3">Créer</button>
        
            <input class="bg-orange-500 text-white hover:bg-orange-700 transition ease-in-out duration-500 rounded-md shadow-md w-full block px-4 py-2 mt-3" type="button" value="Retour" onclick="history.back()"  />
    
        </form>
    </div>
</div>
@endsection





