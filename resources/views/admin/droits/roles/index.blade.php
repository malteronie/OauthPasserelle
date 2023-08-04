@extends('layouts.single')

@section('title', 'Admin : Liste des rôles')

@section('content')

<div class="justify-center flex ">
<div class="w-3/12">

</div>
<div class="shadow shadow-lg w-6/12 rounded-2xl py-7 px-4 space-y-2">
    <h1 class="text-3xl text-blue-600 text-center mb-5">Liste des rôles</h1>

    <table class="w-full max-w-xl mx-auto rounded-lg border-collapse border-2 shadow-md p-5 mb-5">
        <thead>
        <th class="border whitespace-nowrap">Nom</th>
        <th class="border whitespace-nowrap">Permission(s) associée(s)</th>
        </thead>
        <tbody>
        @foreach ($roles as $role)
        <tr onclick="window.location='{{ url('admin/droits/roles', $role->id) }}';">
            <td class="border whitespace-nowrap text-center">{{ $role->name }}</td>
            <td class="border whitespace-nowrap px-12">
            @if($role->permissions)
                @foreach ($role->permissions as $role_permission)
                    {{ $role_permission->name }} <br>
                @endforeach
            @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ route('admin.droits.roles.create') }}">
            @csrf
            <button class="w-48 align-center bg-blue-700 text-white rounded-xl py-2 hover:shadow-lg hover:shadow-blue-200 hover:bg-blue-800" type="submit">
                    Ajouter
            </button>
        </form>
    </div>

    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ URL::previous() }}">
            @csrf
            <button class="w-48 align-center bg-orange-700 text-white rounded-xl py-2 hover:shadow-lg hover:shadow-orange-200 hover:bg-orange-800" type="submit">
                    Retour
            </button>
        </form>
    </div>
</div>
<div class="w-3/12">

</div>
</div>

@endsection
