<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FuvarozóApp')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="shadow-md p-4 flex justify-between" style="background-color:lightgreen">
        <h1 class="text-xl font-bold">FuvarozóApp</h1>
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Regisztráció</a>
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Bejelentkezés</a>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>

    <footer class="text-center text-gray-500 text-sm mt-10">
        &copy; {{ date('Y') }} FuvarozóApp Lakatos Tibor
    </footer>

</body>
</html>

