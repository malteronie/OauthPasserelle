<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>L'utilisateur {{ Auth::user()->name }} vous envoie la demande suivante dans l'application {{ env('APP_NAME') }}</h1>
    <h2>{{ $data['message']}}</h2>
</body>
</html>


