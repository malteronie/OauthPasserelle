<div class="w-full mt-6 h-28">
    <div class="text-center">
        @auth
            <a href="{{ route('contact') }}">Contacter l'administrateur</a>
        @endauth
        @guest
            <a href=""></a>
        @endguest        
    </div>
</div>