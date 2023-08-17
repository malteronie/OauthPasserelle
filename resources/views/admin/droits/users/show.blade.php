@extends('layouts.single')

@section('title', 'Fiche utilisateur')

@section('content')
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
    <div class="mt-4 bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
        <h1 class="text-3xl text-blue-600 text-center mb-5">Utilisateur : {{ ucfirst($user->name) }}</h1>
        <div class="bg-white rounded-2xl mt-5">
            <form method="get" class="" action="{{ route('admin.droits.users.update', $user->id) }}">
                @csrf
                <label for="username">Identifiant : </label>
                <input type="text" id="username" name="username" value="{{ $user->login }}" class="  px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" />
                {{-- <button class="mt-4 bg-red-500 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-red-200 hover:bg-red-700" type="submit">
                        Renommer
                </button> --}}
            </form>        
        </div>
        <form method="post" action="{{ route('reinit.pwd', $user) }}">
            @csrf
            <button class="bg-red-500 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-red-200 hover:bg-red-700" type="submit">
                    Réinitialiser le mot de passe
            </button>
        </form>
        <form method="post" action="{{ route('admin.droits.users.activate', $user->id) }}">
            @csrf
            @method('patch')
            <button class="w-full rounded-xl py-2 shadow text-white hover:shadow-lg {{ $user->active == 0 ? 'bg-green-700 hover:shadow-green-200 hover:bg-green-800' : 'bg-red-700 hover:shadow-red-200 hover:bg-red-800' }}" type="submit">
                    {{ $user->active == 0 ? 'Activer' : 'Désactiver' }}
            </button>                    
        </form>
        <h1 class="text-3xl {{ $user->active == 1 ? 'text-green-600' : 'text-red-600' }} text-center mb-2 mt-2">Compte {{ $user->active == 1 ? 'activé' : 'désactivé' }}</h1>           
   
        <div class="bg-white rounded-2xl pt-5 pb-2 px-4 space-y-2">
            @if($user->roles)
                @foreach ($user->roles as $user_role)
                <form class="mb-2 px-4 py-2 bg-black hover:bg-red-700 text-white rounded-md shadow hover:shadow-lg hover:shadow-red-200 hover:bg-red-700" method="POST" action="{{ route('admin.droits.users.roles.revoke', [$user->id, $user_role->id]) }}" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-white w-full rounded-xl" type="submit">
                    {{ $user_role->name }}
                    </button>
                </form>
                @endforeach
            @endif
        </div>
        <div class="bg-white rounded-2xl px-4 space-y-2">
            <form method="POST" action="{{ route('admin.droits.users.roles', $user->id) }}">
                @csrf
                <div class="">
                    <h4>Rôle :   </h4>
                    <select id="role" name="role" autocomplete="role-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($roles as $role)
                        @if ($role->name == 'admindroits')
                            @if (Auth::user()->can('create_droits'))
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endif
                        @elseif ($role->name == App\Enums\RoleEnum::SUPER_ADMIN->value)
                            @if (Auth::user()->hasrole(App\Enums\RoleEnum::SUPER_ADMIN->value))
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endif
                        @else
                            <option value="{{ $role->name }}">{{ $role->name }}</option>                        
                        @endif    
                        @endforeach
                    </select>
                </div>
                @error('name')
                    <span class="text-red-400 text-sm">{{ $message }}</span>
                @enderror
                <div class="">
                <button class="mt-4 bg-green-600 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-green-200 hover:bg-green-700" type="submit">
                        Ajouter
                </button>
                </div>
            </form>
        </div>
        
        <section x-data="{ open: false }" class="border border-red-400 rounded-lg">
        <div class="flex justify-center">
        <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0619 4.4295C12.6213 3.54786 11.3636 3.54786 10.9229 4.4295L3.89008 18.5006C3.49256 19.2959 4.07069 20.2317 4.95957 20.2317H19.0253C19.9142 20.2317 20.4923 19.2959 20.0948 18.5006L13.0619 4.4295ZM9.34196 3.6387C10.434 1.45376 13.5508 1.45377 14.6429 3.63871L21.6758 17.7098C22.6609 19.6809 21.2282 22 19.0253 22H4.95957C2.75669 22 1.32395 19.6809 2.3091 17.7098L9.34196 3.6387Z" fill="#1C1C1C"></path> <path d="M12 8V13" stroke="#DF1463" stroke-width="1.7" stroke-linecap="round"></path> <path d="M12 16L12 16.5" stroke="#DF1463" stroke-width="1.7" stroke-linecap="round"></path> </g></svg>
        <h3 class="text-center font-semibold text-lg mt-4 text-red-500 hover:cursor-pointer" @click="open = true">Supprimer cet utilisateur</h3>
        <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0619 4.4295C12.6213 3.54786 11.3636 3.54786 10.9229 4.4295L3.89008 18.5006C3.49256 19.2959 4.07069 20.2317 4.95957 20.2317H19.0253C19.9142 20.2317 20.4923 19.2959 20.0948 18.5006L13.0619 4.4295ZM9.34196 3.6387C10.434 1.45376 13.5508 1.45377 14.6429 3.63871L21.6758 17.7098C22.6609 19.6809 21.2282 22 19.0253 22H4.95957C2.75669 22 1.32395 19.6809 2.3091 17.7098L9.34196 3.6387Z" fill="#1C1C1C"></path> <path d="M12 8V13" stroke="#DF1463" stroke-width="1.7" stroke-linecap="round"></path> <path d="M12 16L12 16.5" stroke="#DF1463" stroke-width="1.7" stroke-linecap="round"></path> </g></svg>
        </div>
            <form x-show="open" x-cloak method="POST" action="{{ route('admin.droits.users.destroy', $user) }}">
                @csrf
                @method('DELETE')
                <div><textarea class="w-full max-w-md p-3 bg-red-200" placeholder="Motif de refus/suppression" name="content" required></textarea>
                <button type="submit" class="w-full rounded-xl py-2 shadow text-white hover:shadow-lg bg-red-700 hover:shadow-red-200 hover:bg-red-800">Confirmer la suppression</button>
                </div>
            </form>
        </section>




        <div class="bg-white rounded-2xl pb-3 px-4 space-y-2">
            <form method="get" action="{{ route('admin.droits.users.index') }}">
                @csrf
                <button class="mt-4 bg-orange-600 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-orange-200 hover:bg-orange-700" type="submit">
                        Retour
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
