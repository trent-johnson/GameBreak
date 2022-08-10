<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @livewireStyles
</head>
<body>
    <div>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    @livewireScripts
</body>
</html>
