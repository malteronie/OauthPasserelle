@extends('layouts.single')
@section('title', 'Admin : Liste des permissions')

@section('content')

<div class="justify-center flex ">
<div class="w-3/12">

</div>

<div class="shadow shadow-lg w-6/12 rounded-2xl py-7 px-4 space-y-2">
    <h1 class="text-3xl text-blue-600 text-center mb-5">Liste des permissions</h1>
    <table class="w-full max-w-3xl mx-auto rounded-lg border-collapse border-2 shadow-md p-5 mb-5">
        <thead class="border-gray-300 border-2 text-xl">
            <th class="border whitespace-nowrap">Nom</th>
            <th class="border whitespace-nowrap">Actions</th>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
            <tr class="odd:bg-blue-50 even:bg-white">
                <td class="border whitespace-nowrap text-center px-12">{{ $permission->name }}</td>
                <td class="border whitespace-nowrap px-12">
                    <x-button class="btn-blue"><a href="{{ route('admin.droits.permissions.show', $permission->id) }}">Editer</a></x-button>
                    <x-button class="btn-red mb-3"><a href="{{ route('admin.droits.permissions.show', $permission->id) }}">Supprimer</a></x-button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $permissions->links('pagination::tailwind') }}
    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ route('admin.droits.permissions.create') }}">
            <x-button class="btn-add">Ajouter</x-button>
        </form>
    </div>
</div>
<div class="w-3/12">

</div>
</div>

@endsection
