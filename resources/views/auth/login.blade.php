<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning Politeknik APP Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('{{ asset("images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="glass-panel w-full max-w-md p-8 rounded-2xl shadow-2xl m-4">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Politeknik APP Jakarta" class="h-20 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-red-700">E-Learning Portal</h1>
            <p class="text-sm text-gray-600 mt-1">Politeknik APP Jakarta</p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email / NIM</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                       placeholder="Masukkan Email atau NIM Anda">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                       placeholder="Masukkan Password">
            </div>

            <button type="submit" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200">
                Masuk
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} Politeknik APP Jakarta
        </div>

    </div>

</body>
</html>
