@extends('layouts.single')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="py-7 text-blue-900 w-screen overflow-hidden flex justify-center items-center flex-col gap-7">        
    <div class="border border-gray-400 bg-white rounded-2xl py-7 px-4 space-y-2 w-96">
        <form action="{{ route('forgotpwd.submit') }}" method="post" class="flex flex-col gap-7">
            @csrf
            <label class="">
                <span class="">Email : </span>
                <input type="email" name="email" class="px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100"/>
            </label>

            <button class="bg-indigo-500 text-white w-full rounded-2xl py-2 hover:shadow-indigo-300 hover:shadow-lg" type="submit">
                Demander un nouveau mot de passe
            </button>
        </form>
    </div>
    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ URL::previous() }}">
            <button class="w-48 align-center bg-orange-700 text-white rounded-xl py-2 hover:shadow-lg hover:shadow-orange-200 hover:bg-orange-800" type="submit">
                    Retour
            </button>
        </form>
    </div>
</div>    
@endsection