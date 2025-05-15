<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login SIPALING</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Tambahan warna khusus kalau mau */
        :root {
            --primary-green: #9FC54E;
            --primary-green-hover: #698635;
            --primary-dark-gray: #666666;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-2xl shadow-lg">
        <div class="text-center">
        <h1 class="text-5xl font-bold">
        <span style="color: var(--primary-green);" class="font-bold">Si</span><span class="text-black font-bold">Paling</span>
        </h1>
        </div>

        <!-- Cek jika ada error 'login_gagal' yang diteruskan -->
        @if($errors->has('login_gagal'))
            <div class="p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                {{ $errors->first('login_gagal') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Nomor Induk Karyawan</label>
                <input 
                    type="text" 
                    name="nik_user" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent" 
                    required
                >
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent" 
                    required
                >
            </div>

            <button 
                type="submit" 
                class="w-full px-4 py-2 font-semibold text-white rounded-lg transition duration-200"
                style="background-color: var(--primary-green);"
                onmouseover="this.style.backgroundColor='var(--primary-green-hover)'"
                onmouseout="this.style.backgroundColor='var(--primary-green)'"
            >
                Login
            </button>
        </form>

        <p class="text-xs text-center text-gray-400">© 2025 SIPALING. All rights reserved.</p>
    </div>

</body>
</html>
