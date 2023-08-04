<div>
    <button wire:click="active({{$user}})" 
    class="w-48 align-center text-white rounded-xl  hover:shadow-lg 
    {{ $user->active == 0 ? 'bg-green-700 hover:shadow-green-200 hover:bg-green-800' : 'bg-red-700 hover:shadow-red-200 hover:bg-red-800' }}">
        {{ $user->active == 0 ? 'Activer' : 'Désactiver' }}
    </button>
</div>