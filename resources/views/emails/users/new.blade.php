<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css'])
</head>
<body>

<div class="mb-2 mt-2">
<h1 class="text-3xl font-semibold text-blue-600">Bienvenue dans l'application {{ env('APP_NAME') }}.</h1>
<h2 class="text-xl mt-2 font-semibold text-blue-400">Votre compte a bien été créé.</h2>
<h2 class="text-xl mt-2 font-semibold text-orange-400">Lorsqu'un administrateur l'aura validé, vous recevera un mail et vous pourrez alors vous connecter.</h2>
</div>

<div class="text-gray-700 text-lg">
Votre mot depasse par défaut est <b>{{ $password }}</b></br> veillez à le changer lors de votre première connexion en mode secours.
</div>


</body>
</html>


