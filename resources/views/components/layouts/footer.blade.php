<div class="w-full mt-6 h-28">
    <div class="text-center">
        @auth
            @if (env('APP_ONLINE'))
                <a href="{{ route('contact') }}">Contacter l'administrateur</a>
            @else
                <a href=""></a>
            @endif
        @endauth
        @guest
            <a href=""></a>
        @endguest        
    </div>
</div>