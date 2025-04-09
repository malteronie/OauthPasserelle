@extends('layouts.single')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@section('content')
<link rel="stylesheet" href="{{asset('delete.css')}}">
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Liste des Clients</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Client ID</th>
                                <th>Redirect URL</th>
                                <th>Client Secret</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td><strong>{{ $client->name }}</strong></td>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->redirect }}</td>
                                    <td>{{ $client->secret }}</td>
                                    <td>
                                        <form method="POST" action="/delete/{{ $client->id }}" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="button" type="submit">
                                                <div class="trash">
                                                    <div class="top">
                                                        <div class="paper"></div>
                                                    </div>
                                                    <div class="box"></div>
                                                    <div class="check">
                                                        <svg viewBox="0 0 8 6">
                                                            <polyline points="1 3.4 2.71428571 5 7 1"></polyline>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <span>Trash this</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($clients->isEmpty())
                        <p class="text-center text-muted">Aucun client enregistré pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
