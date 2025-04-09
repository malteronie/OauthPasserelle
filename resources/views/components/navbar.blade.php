@auth
<div class="flex justify-between">
    <div class="">    
        <!-- Première section avec la marge gauche ajustée. Modifier mais ne pas dupliquer -->
        <div class="dropdown inline-block ml-12">
            <button class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-400 py-2 px-2 block whitespace-nowrap">Accueil</a>
            </button>
        </div>
        <!-- Fin de la première section -->

        @if (Auth::user()->active ==1)
        @php
        $menudroits = [\App\Enums\RoleEnum::SUPER_ADMIN->value, \App\Enums\RoleEnum::ADMINDROITS->value, \App\Enums\RoleEnum::ADMINMETIER->value];
        $menurolespermissions = [\App\Enums\RoleEnum::SUPER_ADMIN->value, \App\Enums\RoleEnum::ADMINDROITS->value];
        @endphp
        <!-- Copier cette div autant de fois que besoin de menu -->
        <div class="dropdown inline-block">           
            <x-navbar.menu>Clients </x-navbar.menu>        
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <x-navbar.sousmenu href="{{route('dashboard.clients')}}">Liste des Clients</x-navbar.sousmenu>
            <x-navbar.sousmenu href="{{route('add.client')}}">Créer un Client</x-navbar.sousmenu>
            @hasanyrole($menudroits)
                <x-navbar.sousmenu href="{{route('param.proxy')}}">
                Paramètres du Proxy
                </x-navbar.sousmenu>
            @endhasanyrole
            </ul>
        </div>
        <!-- Fin de la section à copier -->
        <div class="dropdown inline-block">
            <x-navbar.menu>Menu déroulant </x-navbar.menu>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <x-navbar.sousmenu href="">Premier sous menu</x-navbar.sousmenu>
            <x-navbar.sousmenu href="">Deuxième sous menu</x-navbar.sousmenu>
            <x-navbar.sousmenu href="">Troisième sous menu</x-navbar.sousmenu>
            </ul>
        </div>
        <div class="dropdown inline-block">
            <x-navbar.menu>Menu déroulant </x-navbar.menu>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <x-navbar.sousmenu href="">Premier sous menu</x-navbar.sousmenu>
            <x-navbar.sousmenu href="">Deuxième sous menu</x-navbar.sousmenu>
            <x-navbar.sousmenu href="">Troisième sous menu</x-navbar.sousmenu>
            </ul>
        </div>
        @endif
    </div>
    
    <div class="">
        @if (Auth::user()->active ==1)
        <!-- Menu d'administration des droits -->
        @php
        $menudroits = [\App\Enums\RoleEnum::SUPER_ADMIN->value, \App\Enums\RoleEnum::ADMINDROITS->value, \App\Enums\RoleEnum::ADMINMETIER->value];
        $menurolespermissions = [\App\Enums\RoleEnum::SUPER_ADMIN->value, \App\Enums\RoleEnum::ADMINDROITS->value];
        @endphp
        
        @hasanyrole($menudroits)
        <div class="dropdown inline-block">
            <x-navbar.menu>Administration des droits</x-navbar.menu>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <x-navbar.sousmenu href="{{ route('admin.droits.users.index') }}">Gestion des utilisateurs</x-navbar.sousmenu>
            @hasanyrole($menurolespermissions)
            <x-navbar.sousmenu href="{{ route('admin.droits.roles.index') }}">Gestion des rôles</x-navbar.sousmenu>
            <x-navbar.sousmenu href="{{ route('admin.droits.permissions.index') }}">Gestion des permissions</x-navbar.sousmenu>
            @endhasanyrole
        </ul>
        </div>
        @endhasanyrole
        <!-- Fin du menu d'administration des droits -->
        @endif
        <!-- Menu de l'utilisateur connecté -->
        @auth
        <div class="dropdown inline-block mr-12"> 
            <x-navbar.menu>{{ auth()->user()->login }}</x-navbar.menu>          
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            @if (Auth::user()->active == 1)  
            <x-navbar.sousmenu href="{{ route('profile', Auth::user()->id ) }}">Mon profil</x-navbar.sousmenu>
            <x-navbar.sousmenu href="{{ route('change.pwd') }}">Changer mon mot de passe</x-navbar.sousmenu>
            @endif
            @impersonating($guard = null)
            <x-navbar.sousmenu href="{{ route('impersonate.leave') }}">Redevenir soi même</x-navbar.sousmenu>
            @endImpersonating
            <x-navbar.sousmenu href="{{ route('logout') }}">Déconnexion</x-navbar.sousmenu>
            </ul>
        </div> 
        @endauth  
        <!-- Fin du menu de l'utilisateur connecté -->
    </div>
</div>    
@endauth