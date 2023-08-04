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
<h1 class="text-3xl font-semibold text-blue-600">Bienvenue dans l'application <a href="{{ env('APP_URL') }}">{{ env('APP_NAME') }}</a>.</h1>
<h2 class="text-xl mt-2 font-semibold text-green-600">Votre compte a bien été activé.</h2>
</div>

</body>
</html>


