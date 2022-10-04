<!DOCTYPE html>
<html lang="de">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100">
@livewire('main-navigation')
<div class="p-6">
    @yield('content')
</div>
@livewireScripts
</body>
</html>
