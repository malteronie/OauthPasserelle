@auth()
    <div class="w-full mt-6 h-28">
        <div class="text-center">
            <a href="{{ route('contact') }}">Contacter l'administrateur</a>
        </div>
    </div>
@endauth
@guest()
    <div class="w-full mt-6 h-28">
        <div class="text-center">
            <a href=""></a>
        </div>
    </div>
@endguest