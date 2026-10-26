<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Jastiper - JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 antialiased min-h-screen pb-20">

    <!-- NAVBAR -->
    <nav class="bg-white/85 backdrop-blur-xl border-b border-pink-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                    <span class="text-2xl">📦</span>
                    <span class="text-xl font-extrabold text-rose-950 tracking-tight">Jastiper<span class="text-pink-500">Panel</span></span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                <a href="/" class="text-sm font-semibold text-slate-500 hover:text-pink-600 transition">Beranda</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 px-4 py-2 rounded-xl text-sm font-bold transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10 space-y-8">
        
        <!-- HEADER -->
        <div class="bg-white border border-pink-100 rounded-3xl p-8 shadow-sm flex justify-between items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-pink-100 text-pink-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wide mb-3">Mode Jastiper Aktif</div>
                <h1 class="text-3xl font-extrabold text-rose-950">Halo, {{ session('user_name') }}! 👋</h1>
            </div>
            <div>
                <a href="/trip/create" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl font-bold transition">➕ Buka Trip Baru</a>
            </div>
        </div>

        <!-- KOTAK STATISTIK / PENDAPATAN (YANG TADI HILANG) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-50 text-blue-500 flex items-center justify-center text-2xl rounded-2xl">✈️</div>
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Trip Dibuka</p>
                    <p class="text-2xl font-extrabold text-rose-950">{{ $totalTrip ?? 0 }}</p>
                </div>
            </div>
            
            <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-green-50 text-green-500 flex items-center justify-center text-2xl rounded-2xl">✅</div>
                <div>
                    <p class="text-slate-500 text-sm font-medium">Pesanan Selesai</p>
                    <p class="text-2xl font-extrabold text-rose-950">{{ $totalPesananSelesai ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-amber-50 text-amber-500 flex items-center justify-center text-2xl rounded-2xl">💰</div>
                <div>
                    <p class="text-slate-500 text-sm font-medium">Estimasi Pendapatan</p>
                    <p class="text-2xl font-extrabold text-rose-950">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- TABEL PESANAN -->
        <div class="bg-white border border-pink-100 rounded-3xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-pink-100 flex justify-between items-center">
                <h2 class="text-xl font-extrabold text-rose-950">📋 Daftar Pesanan Masuk</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-pink-50/50 text-slate-500 text-sm">
                            <th class="py-4 px-6 font-semibold">Barang & Pembeli</th>
                            <th class="py-4 px-6 font-semibold">Trip / Kategori</th>
                            <th class="py-4 px-6 font-semibold">Status</th>
                            <th class="py-4 px-6 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50">
                        @forelse($requests ?? [] as $req)
                            <tr class="hover:bg-pink-50/30 transition">
                                <td class="py-4 px-6">
                                    <p class="font-bold text-rose-950">{{ $req->nama_barang }}</p>
                                    <p class="text-xs text-slate-500">Oleh: {{ $req->user->name ?? 'Pembeli' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-slate-700 capitalize">{{ $req->trip->destinasi ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    @if($req->status === 'menunggu')
                                        <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1 rounded-full">Request Baru</span>
                                    @elseif($req->status === 'menunggu_pembayaran')
                                        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">Menunggu Bayar</span>
                                    @elseif($req->status === 'diproses')
                                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">Sedang Diproses</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Selesai</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($req->status === 'menunggu')
                                        <div class="flex gap-2">
                                            <form action="/request/accept/{{ $req->id }}" method="POST">
                                                @csrf <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold">Terima</button>
                                            </form>
                                            <form action="/request/reject/{{ $req->id }}" method="POST">
                                                @csrf <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold">Tolak</button>
                                            </form>
                                        </div>
                                    @elseif($req->status === 'menunggu_pembayaran')
                                        <span class="text-xs text-slate-400 font-semibold italic">Menunggu Pembeli Bayar</span>
                                    @elseif($req->status === 'diproses')
                                        <form action="/request/progress/{{ $req->id }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            <select name="progress_status" class="text-xs border border-slate-200 rounded px-2 py-1">
                                                <option value="Menuju Toko" {{ $req->progress_status == 'Menuju Toko' ? 'selected' : '' }}>Menuju Toko</option>
                                                <option value="Sedang Membeli" {{ $req->progress_status == 'Sedang Membeli' ? 'selected' : '' }}>Sedang Membeli</option>
                                                <option value="Dikirim" {{ $req->progress_status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                <option value="Selesai">Selesai (Akhiri Pesanan)</option>
                                            </select>
                                            <input type="hidden" name="progress_percent" value="50">
                                            <input type="text" name="no_resi" placeholder="Input No Resi (Jika ada)..." value="{{ $req->no_resi }}" class="text-xs border border-slate-200 rounded px-2 py-1">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-[10px] font-bold transition">Update Status</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 font-semibold italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-500">Belum ada pesanan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>