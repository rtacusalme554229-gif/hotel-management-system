<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <div class="d-flex">

        @auth
            @include('partials.sidebar')
        @endauth

        <div class="flex-grow-1 p-4">
    @auth
        @include('partials.navbar')
    @endauth

    <div class="container-fluid">
        @include('partials.alerts')
        @yield('content')
    </div>
</div>
    </div>

</body>
</html>