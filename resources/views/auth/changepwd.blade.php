@extends('layouts.single')

@section('title', 'Changement de mot de passe')

@section('content')
<div class="text-blue-900 w-screen overflow-hidden flex justify-center items-center flex-col gap-7">
    <div class="border border-gray-400 bg-white rounded-2xl py-4 px-4 space-y-2 w-96">
            <form method='POST' action="{{ route('pwd') }}">
                @csrf
                <h2 class="text-xl mb-3">Changer le mot de passe : </h2>
                <div>
                    <label for="pwd">Mot de passe actuel :</label><br>
                    <input type="password" name="pwd" autofocus minlength="6" maxlength="255" class="w-full px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" required>
                </div>
                <div class="form-group">
                    <label for="new_pwd">Nouveau mot de passe :</label><br>
                    <input type="password" name="new_pwd" minlength="9" maxlength="255" class="w-full px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" required>
                </div>

                <div class="form-group">
                    <label for="new_pwd2">Confimer le mot de passe :</label><br>
                    <input type="password" name="new_pwd2" minlength="9" maxlength="255" class="w-full px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" required>
                </div>

                <button class="mt-4 bg-indigo-500 text-white w-full rounded-2xl py-2 hover:shadow-indigo-300 hover:shadow-lg" type="submit">
                    Modifier
                </button>

            </form>
        </div>
</div>
@endsection
