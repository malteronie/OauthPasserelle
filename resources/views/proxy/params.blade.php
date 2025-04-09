@extends('layouts.single')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Les Paramètres du Proxy') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="/changeParams/URL_SERVER">
                        
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
                                    <td>URL du serveur</td>
                                    <td>
                                        <input type="text" class="form-control" name="URL_SERVER" value="{{ env('URL_SERVER') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Id Client</td>
                                    <td>
                                        <input type="text" class="form-control" name="APP_CLIENT_ID" value="{{ env('APP_CLIENT_ID') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Clé secrète</td>
                                    <td>
                                        <input type="text" class="form-control" name="APP_CLIENT_SECRET" value="{{ env('APP_CLIENT_SECRET') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>URL de redirection</td>
                                    <td>
                                        <input type="text" class="form-control" name="APP_CLIENT_REDIRECT_URL" value="{{ env('APP_CLIENT_REDIRECT_URL') }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <center><button type="submit" class="btn">Modifier</button></center>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
