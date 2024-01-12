@extends('layouts.single')

@section('title', 'Admin : Liste des utilisateurs')

@section('content')

<div class="justify-center flex mb-5">
<div class="w-1/12">

</div>
<div class="shadow shadow-lg w-11/12 rounded-2xl py-7 px-4 space-y-2">
    <h1 class="text-3xl text-blue-600 text-center mb-5">Liste des utilisateurs</h1>
    <div>
        <table class="w-full max-w-3xl mx-auto rounded-lg border-collapse border-2 shadow-md p-5 mb-5">
            <thead class="border-gray-300 border-2 text-xl">
                <th class="p-2 border whitespace-nowrap">Grade</th>
                <th class="p-2 border whitespace-nowrap">Nom</th>
                <th class="p-2 border whitespace-nowrap">Prénom</th>
                <th class="p-2 border whitespace-nowrap">identifiant</th>
                <th class="p-2 border whitespace-nowrap">E-mail</th>
                <th class="p-2 border whitespace-nowrap">Affectation ANNUDEF</th>
                <th class="p-2 border whitespace-nowrap">Rôle(s) attribué(s)</th>
                <th class="p-2 border whitespace-nowrap">Permission(s) héritée(s)</th>
                <th class="p-2 border whitespace-nowrap">Actions</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="odd:bg-blue-50 even:bg-white">
                    <td class="p-2 border whitespace-nowrap text-center">{{ $user->short_rank }}</td>
                    <td class="p-2 border whitespace-nowrap text-center">{{ $user->last_name }}</td>
                    <td class="p-2 border whitespace-nowrap text-center">{{ $user->first_name }}</td>
                    <td class="p-2 border whitespace-nowrap text-center">{{ $user->login }}</td>
                    <td class="p-2 border whitespace-nowrap text-center">{{ $user->email }}</td>
                    <td class="p-2 border whitespace-nowrap text-center">{{ $user->affectation_annudef }}</td>
                    <td class="p-2 border whitespace-nowrap text-center">
                    @if($user->roles)
                        @foreach ($user->roles as $user_role)
                            {{ $user_role->name }} <br>
                        @endforeach
                    @endif
                    </td>
                    <td class="p-2 border whitespace-nowrap px-12">
                    @if($user->roles)
                        @foreach ($user->getAllPermissions() as $user_permission)
                            {{ $user_permission->name }} <br>
                        @endforeach
                    @endif
                    </td>                    
                    <td class="p-2 border text-center">
                    <livewire:active-user :user="$user" />
                    <x-button class="btn-profil"><a href="{{ route('admin.droits.users.show', $user->id) }}">Profil</a></x-button>
                    @canImpersonate($guard = null)
                        @canBeImpersonated($user, $guard = null)                                    
                        <button class="mt-2 w-48 align-center bg-blue-700 text-white rounded-xl  hover:shadow-lg hover:shadow-blue-200 hover:bg-blue-800">
                            <a href="{{ route('impersonate', $user->id) }}">Se faire passer pour...</a>
                        </button>
                        
                        @endCanBeImpersonated
                    @endCanImpersonate
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>

    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ route('admin.droits.users.create') }}">
            <button class="w-48 align-center bg-blue-700 text-white rounded-xl py-2 hover:shadow-lg hover:shadow-blue-200 hover:bg-blue-800" type="submit">
                    Ajouter
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
<div class="w-1/12">

</div>
</div>
@endsection