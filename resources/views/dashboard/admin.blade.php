<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - SIPALING</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="mt-6 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Logout
        </button>
    </form>
    <div class="text-center">
        <h1 class="text-4xl font-bold">Dashboard Admin</h1>
        <p class="mt-4">Selamat datang Admin SIPALING!</p>
    </div>
</body>
</html>
