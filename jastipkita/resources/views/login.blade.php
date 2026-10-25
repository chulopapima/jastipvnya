<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-pink-500 selection:text-white flex min-h-screen">

    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 lg:px-32 py-12">
        <div class="w-full max-w-sm mx-auto space-y-8">
            <div>
                <a href="/" class="inline-flex items-center gap-3 mb-8 hover:opacity-80 transition">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo JastipKita" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-pink-100">
                    <span class="text-xl font-extrabold text-rose-950 tracking-tight">Jastip<span class="text-pink-500">Kita</span></span>
                </a>
                <h1 class="text-3xl font-extrabold text-rose-950 tracking-tight">Selamat Datang!</h1>
                <p class="text-slate-500 mt-2 text-sm">Silakan masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl text-sm font-medium">
                    ✖ {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-sm font-medium">
                    ✔ {{ session('success') }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm">
                </div>

                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-3.5 rounded-xl font-bold text-sm transition shadow-lg shadow-pink-500/20 mt-4">
                    Masuk Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-slate-500">
                Belum punya akun? <a href="/register" class="text-pink-600 font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>

    <!-- GAMBAR PESAWAT TETAP ADA -->
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden">
        <img src="{{ asset('images/pesawat.jpg') }}" alt="Pesawat" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-rose-950/95 via-rose-900/60 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 p-16 w-full text-white space-y-3">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full border border-white/30 font-semibold uppercase tracking-wider mb-2">
                Terpercaya 🌍
            </div>
            <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight leading-snug">Jembatan Belanja Anda.</h2>
            <p class="text-pink-100 max-w-md leading-relaxed text-sm lg:text-base">Titip barang antar kota dengan aman, transparan, dan pantau secara real-time bersama JastipKita.</p>
        </div>
    </div>

</body>
</html>