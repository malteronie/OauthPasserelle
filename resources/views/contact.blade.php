@extends('layouts.single')

@section('title', 'Contact')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <form method='post' action="{{ route('postcontact') }}" class="p-5 mb-5">    
        @csrf
        <label for="objet" class="block font-semibold text-gray-700 mb-2">Objet de la demande</label>
        <x-input type='text' placeholder='Objet' name='objet' id='objet' maxlength='32' autofocus></x-input>
        <label for="objet" class="block font-semibold text-gray-700 mb-2">Votre demande</label>            
        <textarea placeholder='Votre demande' name='message' id='message' cols="35" rows="15"
                    class="px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100"></textarea>
    
        <x-button class="btn-blue py-2 shadow-md">Envoyer</x-button>
    </form>
</div>

@endsection