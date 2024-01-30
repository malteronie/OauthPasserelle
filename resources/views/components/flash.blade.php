@if(session('success'))
<div class="border border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
    {{ session('success') }}
</div>
@endif

@if(session('warning'))
<div class="border border-orange-400 rounded-b bg-orange-100 px-4 py-3 text-orange-700">
    {{ session('warning') }}
</div>
@endif

@if(session('info'))
<div class="border border-blue-400 rounded-b bg-blue-100 px-4 py-3 text-blue-700">
    {{ session('info') }}
</div>
@endif

@if(session('error'))
<div class="border border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="border border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
    <ul class="my-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
