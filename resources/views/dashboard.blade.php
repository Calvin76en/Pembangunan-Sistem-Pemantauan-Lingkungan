<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard SIPALING</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-green-100">

    <h1 class="mb-4 text-3xl font-bold text-green-700">Selamat datang di Dashboard SIPALING!</h1>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600">
            Logout
        </button>
    </form>

</body>
</html>
