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
        
        <!-- Copier cette div autant de fois que besoin de menu -->
        <div class="dropdown inline-block">
            <button class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <span class="hover:text-gray-400 py-2 px-2 block whitespace-nowrap">Menu déroulant</span>
                <svg class="fill-current h-4 w-4" viewbox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Premier sous menu</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Deuxième sous menu</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Troisième sous menu</li></a>
            </ul>
        </div>
        <!-- Fin de la section à copier -->
        <div class="dropdown inline-block">
            <button class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <span class="hover:text-gray-400 py-2 px-2 block whitespace-nowrap">Menu déroulant</span>
                <svg class="fill-current h-4 w-4" viewbox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Premier sous menu</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Deuxième sous menu</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Troisième sous menu</li></a>
            </ul>
        </div>
        <div class="dropdown inline-block">
            <button class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <span class="hover:text-gray-400 py-2 px-2 block whitespace-nowrap">Menu déroulant</span>
                <svg class="fill-current h-4 w-4" viewbox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Premier sous menu</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Deuxième sous menu</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="">Troisième sous menu</li></a>
            </ul>
        </div>
        @endif
    </div>






    
    <div class="">
        @if (Auth::user()->active ==1)
        <!-- Menu d'administration des droits -->
        @canany(['read_users','read_droits'])
        <div class="dropdown inline-block">
            <button class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <span class="hover:text-gray-400 py-2 px-2 block whitespace-nowrap">Administration des droits</span>
                <svg class="fill-current h-4 w-4" viewbox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>    
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="{{ route('admin.droits.users.index') }}">Gestion des utilisateurs</li></a>
            @canany(['read_droits'])
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="{{ route('admin.droits.roles.index') }}">Gestion des rôles</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="{{ route('admin.droits.permissions.index') }}">Gestion des permissions</li></a>
            @endcanany 
        </ul>
        </div>
        @endcanany
        <!-- Fin du menu d'administration des droits -->
        @endif
        <!-- Menu de l'utilisateur connecté -->
        @auth
        <div class="dropdown inline-block mr-12">
            <button class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                <a class="hover:text-gray-400 py-2 px-2 block whitespace-nowrap" href="#">{{ auth()->user()->login }}</a>
                <svg class="fill-current h-4 w-4" viewbox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>          
            <ul class="dropdown-menu hidden absolute text-gray-500 pt-1">
            @if (Auth::user()->active == 1)  
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="{{ route('profile', Auth::user()->id ) }}">Mon profil</li></a>
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block " href="{{ route('change.pwd') }}">Changer mon mot de passe</li></a>
            @endif
            @impersonating($guard = null)
                <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block" href="{{ route('impersonate.leave') }}">Redevenir soi même</li></a>
            @endImpersonating
            <li class=""><a class="bg-gray-200 hover:bg-gray-400 hover:text-white py-2 px-2 block whitespace-nowrap" href="{{ route('logout') }}">Déconnexion</li></a>
            </ul>
        </div> 
        @endauth  
        <!-- Fin du menu de l'utilisateur connecté -->
    </div>
</div>    
@endauth