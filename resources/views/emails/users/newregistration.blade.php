<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Le {{ $data['short_rank'] }} {{ $data['name'] }} vient de demander un accès à l'application {{ env('APP_NAME') }}.

    Vous devez valider sa demande et lui affecter un rôle afin qu'il puisse l'utiliser.

    <a href="{{ route('admin.droits.users.show',$data['id']) }}">ACTIVER</a>
</body>
</html>