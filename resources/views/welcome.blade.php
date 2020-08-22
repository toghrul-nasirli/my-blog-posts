<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRUD Single Page Application</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand pl-4" href="#">CRUD Single Page Application</a>
        </nav>

        <div class="container">
            <posts></posts>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>