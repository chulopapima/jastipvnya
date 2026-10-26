<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-50 via-white to-rose-100 flex items-center justify-center min-h-screen antialiased selection:bg-pink-500 selection:text-white p-6 relative overflow-hidden">
    
    <!-- Dekorasi Background -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
        <div class="absolute top-40 -right-20 w-72 h-72 bg-rose-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/2 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Kotak Login -->
    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-2xl shadow-pink-900/10 w-full max-w-md border border-pink-100 relative">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-100 to-pink-200 rounded-2xl mb-4 shadow-sm border border-pink-200">
                <span class="text-3xl">🛍️</span>
            </div>
            <h2 class="text-3xl font-extrabold text-rose-950 tracking-tight">Jastip<span class="text-pink-500">Kita</span></h2>
            <p class="text-slate-500 text-sm mt-2 font-medium">Selamat datang kembali! Silakan masuk.</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-100 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 text-sm font-semibold flex items-center gap-2">
                <span>⚠️</span> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2 ml-1">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3.5 bg-white/50 border border-pink-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-all font-medium text-slate-700 shadow-sm" placeholder="contoh@gmail.com">
            </div>
            
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2 ml-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3.5 bg-white/50 border border-pink-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-all font-medium text-slate-700 shadow-sm" placeholder="••••••••">
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-4 px-4 rounded-2xl transition-all duration-300 shadow-lg shadow-pink-500/30 transform hover:-translate-y-1">
                    Masuk ke Akun
                </button>
            </div>
        </form>

        <!-- Informasi Akun Dummy -->
        <div class="mt-8 pt-6 border-t border-pink-100/60 text-center">
            <p class="text-xs text-slate-400 font-semibold mb-3">Gunakan akun demo berikut:</p>
            <div class="flex justify-center gap-3 text-[11px] font-bold">
                <span class="bg-pink-50 text-pink-600 px-3 py-1.5 rounded-xl border border-pink-100">Pembeli@gmail.com</span>
                <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-xl border border-blue-100">jastiper@gmail.com</span>
            </div>
            <p class="text-[11px] text-slate-400 font-semibold mt-3">Password untuk keduanya: <span class="text-slate-600 font-bold bg-slate-100 px-2 py-0.5 rounded">123</span></p>
        </div>

    </div>
</body>
</html>