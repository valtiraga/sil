<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning Politeknik APP Jakarta</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        
        <!-- Left Side: Graphic / Branding -->
        <div class="md:w-1/2 bg-slate-900 p-12 text-white flex flex-col justify-center relative overflow-hidden">
            <div class="relative z-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Politeknik APP" class="h-16 w-auto mb-8 filter brightness-0 invert">
                <h1 class="text-4xl font-bold mb-4">Selamat Datang Kembali</h1>
                <p class="text-slate-400 text-lg">Masuk untuk mengakses materi perkuliahan, forum diskusi, dan ujian online di E-Learning Politeknik APP Jakarta.</p>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-red-600 opacity-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-600 opacity-20 blur-3xl"></div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="md:w-1/2 p-12 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Login ke Akun Anda</h2>
            <p class="text-slate-500 mb-8">Silakan masukkan Email / NIM dan Password Anda.</p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="text-sm font-medium">{{ $errors->first() }}</span>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" class="space-y-6" x-data="{ isLoading: false }" @submit="isLoading = true">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email / NIM</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all @error('email') border-red-500 ring-1 ring-red-500 @enderror" placeholder="Masukkan Email atau NIM" required autofocus>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                    </div>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" :disabled="isLoading" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 focus:outline-none flex justify-center items-center gap-2 disabled:opacity-75 disabled:cursor-not-allowed">
                    <span x-show="!isLoading">Masuk Sekarang</span>
                    <span x-show="isLoading" style="display: none;">Memproses...</span>
                    <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            
            <div class="mt-8 text-center text-sm text-slate-500">
                <a href="/" class="hover:text-red-600 transition-colors">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
