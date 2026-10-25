<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JastipKita — Jasa Titip Antar Kota</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 antialiased selection:bg-pink-500 selection:text-white flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white/85 backdrop-blur-xl border-b border-pink-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo JastipKita" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-pink-100">
                <span class="text-xl font-extrabold text-rose-950 tracking-tight">Jastip<span class="text-pink-500">Kita</span></span>
            </div>
            
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ Auth::user()->role === 'jastiper' ? '/dashboard-jastiper' : '/dashboard-pembeli' }}" class="bg-pink-50 text-pink-600 hover:bg-pink-100 px-5 py-2.5 rounded-xl text-sm font-semibold transition">Ke Dashboard</a>
                @else
                    <a href="/login" class="text-slate-500 hover:text-pink-600 px-4 py-2 text-sm font-semibold transition">Masuk</a>
                    <a href="/register" class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-pink-500/20">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="bg-white overflow-hidden border-b border-pink-50">
        <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24 flex flex-col lg:flex-row items-center gap-12">
            <div class="w-full lg:w-1/2 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-pink-50 text-pink-600 text-xs px-3 py-1.5 rounded-full font-bold uppercase tracking-wide border border-pink-100">
                    <span>Terpercaya se-Indonesia 🇮🇩</span>
                </div>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-rose-950 tracking-tight leading-[1.15]">
                    Titip Barang Antar Kota <span class="text-pink-500">Lebih Mudah & Aman.</span>
                </h1>
                <p class="text-slate-500 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Pilih jastiper yang sedang bepergian antar kota, request tenant mall pilihanmu, pantau progressnya, dan bayar aman dengan Midtrans.
                </p>
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <a href="#trips" class="w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white px-8 py-3.5 rounded-xl font-bold text-sm transition shadow-lg shadow-pink-500/20 text-center">
                        Lihat Trip Tersedia
                    </a>
                </div>
            </div>

            <div class="w-full lg:w-1/2 relative">
                <div class="absolute inset-0 bg-pink-100 rounded-3xl transform rotate-3 scale-105 -z-10"></div>
                <img src="{{ asset('images/pesawat.jpg') }}" alt="Pesawat Jastip" class="w-full h-[350px] lg:h-[450px] object-cover rounded-3xl shadow-2xl shadow-pink-900/15 border-4 border-white relative z-10 hover:scale-[1.02] transition duration-500">
            </div>
        </div>
    </header>

    <!-- DAFTAR TRIP -->
    <main id="trips" class="flex-grow max-w-7xl mx-auto px-6 py-20 w-full space-y-10">
        <div class="text-center space-y-3">
            <h2 class="text-3xl font-extrabold text-rose-950">🏙️ Trip Jastip Terbaru</h2>
            <p class="text-slate-500">Pilih kota destinasi, cek tenant toko favoritmu, dan mulai titip barang.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($trips ?? [] as $trip)
                <div class="bg-white border border-pink-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col">
                    
                    <!-- FOTO TRIP -->
                    <div class="relative">
                        @if($trip->foto)
                            <img src="{{ asset('storage/' . $trip->foto) }}" alt="Foto Trip" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-pink-50 flex items-center justify-center text-4xl">👜</div>
                        @endif
                        
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-pink-600 text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm">
                            Fee: Rp {{ number_format($trip->estimasi_fee, 0, ',', '.') }}
                        </div>

                        <!-- BADGE SISA SLOT -->
                        <div class="absolute bottom-4 left-4 bg-rose-950/80 backdrop-blur text-white text-[11px] font-bold px-3 py-1 rounded-lg">
                            📦 Sisa Slot: {{ $trip->sisaSlot() }} / {{ $trip->slot_maksimal ?? 50 }}
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-4 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-rose-950 capitalize">{{ $trip->destinasi }}</h3>
                            @if($trip->tanggal_berangkat && $trip->tanggal_pulang)
                                <p class="text-xs text-pink-600 font-semibold mt-1">📅 {{ $trip->tanggal_berangkat }} s/d {{ $trip->tanggal_pulang }}</p>
                            @endif
                            <p class="text-sm text-slate-500 font-medium mt-2">Jastiper: {{ $trip->user->name ?? 'Vanya Harina Putri' }}</p>
                            
                            <!-- DAFTAR TENANT / TOKO -->
                            @if(!empty($trip->tenants))
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach($trip->tenants as $tenant)
                                        <span class="bg-pink-50 text-pink-700 text-[10px] font-bold px-2.5 py-1 rounded-md border border-pink-100">{{ $tenant }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($trip->deskripsi)
                                <p class="text-xs text-slate-400 mt-3 line-clamp-2">{{ $trip->deskripsi }}</p>
                            @endif
                        </div>
                        
                        <!-- TOMBOL AKSI -->
                        @auth
                            @if(auth()->user()->role === 'jastiper')
                                <div class="pt-4 border-t border-slate-100 flex gap-2">
                                    <a href="/trip/edit/{{ $trip->id }}" class="w-1/2 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-600 text-center py-3 rounded-xl font-bold text-sm transition">Edit</a>
                                    <form action="/trip/delete/{{ $trip->id }}" method="POST" class="w-1/2" onsubmit="return confirm('Yakin hapus trip ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-rose-50 hover:bg-rose-500 hover:text-white text-rose-600 text-center py-3 rounded-xl font-bold text-sm transition">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <div class="pt-4 border-t border-slate-100">
                                    <a href="/request/create?trip_id={{ $trip->id }}" class="block w-full bg-pink-500 hover:bg-pink-600 text-white text-center py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-pink-500/20">
                                        Titip di Sini 🛒
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="pt-4 border-t border-slate-100">
                                <a href="/login" class="block w-full bg-pink-500 hover:bg-pink-600 text-white text-center py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-pink-500/20">
                                    Titip di Sini 🛒
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white border border-pink-100 rounded-3xl p-12 text-center shadow-sm">
                    <div class="text-4xl mb-4">🧳</div>
                    <h3 class="text-lg font-bold text-rose-950 mb-1">Belum ada trip aktif</h3>
                </div>
            @endforelse
        </div>
    </main>

    <!-- FOOTER (ALAMAT KANTOR & PEMILIK JASTIP) -->
    <footer class="bg-white border-t border-pink-100 mt-20 py-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-center text-center md:text-left">
            
            <div class="space-y-2">
                <div class="flex items-center justify-center md:justify-start gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-xl object-cover border border-pink-100">
                    <span class="text-lg font-extrabold text-rose-950">Jastip<span class="text-pink-500">Kita</span></span>
                </div>
                <p class="text-xs text-slate-500">Layanan jasa titip barang antar kota terpercaya dengan jaminan keamanan pembayaran.</p>
            </div>

            <div class="space-y-1">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Founder & Pemilik Jastip</h4>
                <p class="text-sm font-extrabold text-rose-950">Vanya Harina Putri</p>
                <p class="text-xs text-slate-500">Official JastipKita Management</p>
            </div>

            <div class="space-y-1 text-center md:text-right">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Basecamp / Alamat Kantor</h4>
                <p class="text-xs font-semibold text-slate-700">Jl. Pemuda No. 128, Sekayu, Kec. Semarang Tengah</p>
                <p class="text-xs text-pink-600 font-bold">Kota Semarang, Jawa Tengah 50132</p>
            </div>

        </div>
        <div class="max-w-7xl mx-auto px-6 border-t border-slate-100 mt-8 pt-6 text-center text-xs text-slate-400">
            &copy; 2026 JastipKita. All rights reserved. Managed by Vanya Harina Putri.
        </div>
    </footer>

</body>
</html>