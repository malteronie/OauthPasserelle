@extends('layouts.single ')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Clients') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="mt-3 pg-6 bd-white border-b border-gray-200">
                        <form method="POST" action="/oauth/clients">
                        
                            <table class="table table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Paramètre</th>
                                        <th>Valeur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @csrf
                                    <tr>
                                        <td>Name</td>
                                        <td>
                                            <input style="margin-left: 20px; border:1px solid black" type="text" placeholder="Name" name="name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Redirect</td>
                                        <td>
                                            <input style="margin-left: 20px; border:1px solid black" type="text" name="redirect" placeholder="http://my-url.com/callback">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <center><button type="submit" class="btn">Modifier</button></center><br>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
