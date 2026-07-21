<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Learning Politeknik APP Jakarta</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="antialiased text-gray-900 bg-white">
    <div class="relative overflow-hidden hero-pattern min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="relative z-10 px-6 pt-6 pb-2 sm:px-12 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Politeknik APP" class="h-10 w-auto">
                <span class="text-xl font-bold text-slate-800 tracking-tight hidden sm:block">Politeknik APP E-Learning</span>
            </div>
            <div>
                @auth
                    <a href="{{ auth()->user()->hasRole('admin') ? '/admin' : (auth()->user()->hasRole('dosen') ? '/dosen' : '/mahasiswa') }}" class="font-semibold text-slate-700 hover:text-red-600 transition-colors px-4 py-2">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-red-600 rounded-full shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all transform hover:scale-105">
                        Log in
                    </a>
                @endauth
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center justify-center relative z-10 px-6 py-12 sm:px-12 lg:px-24">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 font-medium text-sm mb-6 animate-bounce">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Versi Terbaru 2.0
                </div>
                <h1 class="text-5xl sm:text-7xl font-extrabold text-slate-900 tracking-tight mb-8">
                    Platform Pembelajaran <br class="hidden sm:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-rose-400">Interaktif & Modern</span>
                </h1>
                <p class="text-lg sm:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Sistem Pembelajaran Jarak Jauh (E-Learning) Politeknik APP Jakarta dirancang untuk memberikan pengalaman belajar yang lebih baik, terstruktur, dan mudah diakses di mana saja.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-slate-900 rounded-full shadow-lg hover:bg-slate-800 transition-all transform hover:-translate-y-1">
                        Mulai Belajar Sekarang
                    </a>
                    <a href="#features" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-slate-700 bg-white border-2 border-slate-200 rounded-full hover:border-slate-300 hover:bg-slate-50 transition-all">
                        Pelajari Fitur
                    </a>
                </div>
            </div>
        </main>

        <!-- Decorative Blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-red-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-[20%] right-[-10%] w-[40%] h-[40%] bg-rose-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[-20%] left-[20%] w-[40%] h-[40%] bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 sm:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Fitur Utama Platform</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Kami menyediakan berbagai alat untuk mendukung ekosistem pembelajaran yang komprehensif bagi dosen dan mahasiswa.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:shadow-xl transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Course</h3>
                    <p class="text-slate-600 leading-relaxed">Akses ke materi perkuliahan, modul, silabus, dan sumber belajar dengan antarmuka yang terstruktur dan mudah dinavigasi.</p>
                </div>
                <!-- Feature 2 -->
                <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:shadow-xl transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Forum Diskusi</h3>
                    <p class="text-slate-600 leading-relaxed">Fasilitas diskusi interaktif untuk tanya jawab antara mahasiswa dan dosen di luar jam perkuliahan reguler.</p>
                </div>
                <!-- Feature 3 -->
                <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:shadow-xl transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Evaluasi Belajar</h3>
                    <p class="text-slate-600 leading-relaxed">Sistem ujian (Quiz) online dengan berbagai tipe soal (Pilihan Ganda, Essay, True/False) terintegrasi langsung di dalam sistem.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 py-12 border-t border-slate-800 text-slate-400">
        <div class="max-w-7xl mx-auto px-6 sm:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all">
                <span class="text-sm font-semibold">Politeknik APP Jakarta</span>
            </div>
            <div class="text-sm text-center md:text-right">
                &copy; {{ date('Y') }} Sistem Informasi E-Learning. All rights reserved.
            </div>
        </div>
    </footer>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
