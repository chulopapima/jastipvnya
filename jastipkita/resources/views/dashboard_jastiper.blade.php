<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Jastiper — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-8 px-4 sm:px-6 antialiased selection:bg-pink-500 selection:text-white">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- HEADER & NAVIGASI -->
        <div class="relative w-full bg-white border border-pink-100 rounded-[2rem] overflow-hidden shadow-xl shadow-pink-900/5 p-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left space-y-2">
                <div class="inline-flex items-center gap-2 bg-pink-100 text-pink-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider mb-2">
                    Portal Tim Jastiper 🛍️
                </div>
                <h1 class="text-3xl font-extrabold text-rose-950 tracking-tight">Halo Jastiper, {{ Auth::user()->name }}!</h1>
                <p class="text-slate-500 text-sm">Kelola pesanan antar kota dan pantau keuangan tim di sini.</p>
            </div>
            
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="/" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition">🏠 Home</a>
                <a href="/trip/create" class="bg-pink-50 hover:bg-pink-100 text-pink-600 px-5 py-2.5 rounded-xl text-sm font-bold transition">+ Buka Trip</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-pink-500/30">Logout</button>
                </form>
            </div>
        </div>

        <!-- KOTAK STATISTIK KEUANGAN & PENDAPATAN -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Total Pendapatan -->
            <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-pink-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-pink-500/20">
                    💰
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan Tim</p>
                    <h3 class="text-2xl font-extrabold text-rose-950 mt-1">
                        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- Card 2: Total Trip Aktif -->
            <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center text-2xl font-bold">
                    ✈️
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Trip Dibuka</p>
                    <h3 class="text-2xl font-extrabold text-rose-950 mt-1">
                        {{ $totalTrip ?? App\Models\Trip::count() }} Trip
                    </h3>
                </div>
            </div>

            <!-- Card 3: Pesanan Masuk -->
            <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-2xl font-bold">
                    📦
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Request Masuk</p>
                    <h3 class="text-2xl font-extrabold text-rose-950 mt-1">
                        {{ App\Models\ItemRequest::count() }} Item
                    </h3>
                </div>
            </div>
        </div>

        <!-- TABEL KELOLA REQUEST PESANAN -->
        <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm space-y-5">
            <h2 class="text-lg font-extrabold text-rose-950 flex items-center gap-2">🔔 Kelola Request (Sistem Kolaborasi Tim)</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-pink-50 text-pink-800 uppercase text-[11px] tracking-wider border-b border-pink-100">
                        <tr>
                            <th class="p-4 rounded-tl-2xl">Pembeli & Barang</th>
                            <th class="p-4">Kota Tujuan</th>
                            <th class="p-4">Est. Harga & Fee</th>
                            <th class="p-4">Update Progress</th>
                            <th class="p-4 text-center rounded-tr-2xl">Klaim Pesanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $requests = App\Models\ItemRequest::with('user', 'trip')->latest()->get();
                        @endphp
                        @forelse($requests as $req)
                            <tr class="hover:bg-pink-50/30 transition">
                                <td class="p-4 font-extrabold text-rose-950">
                                    {{ $req->user->name ?? 'Pembeli' }} <br> 
                                    <span class="text-xs text-slate-500 font-medium">{{ $req->nama_barang }} ({{ $req->jumlah }} pcs)</span>
                                </td>
                                <td class="p-4 font-semibold text-slate-600">🏙️ {{ $req->destinasi }}</td>
                                <td class="p-4 font-bold text-pink-600">Rp {{ number_format($req->estimasi_harga * $req->jumlah, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @if($req->status == 'diterima')
                                        <form action="/request/progress/{{ $req->id }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <select name="progress_status" onchange="this.form.progress_percent.value = this.options[this.selectedIndex].dataset.pct" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 font-medium focus:outline-none focus:border-pink-500">
                                                <option value="Menuju Toko" data-pct="25" {{ $req->progress_status == 'Menuju Toko' ? 'selected' : '' }}>🚶‍♂️ Menuju Toko</option>
                                                <option value="Barang Dibeli" data-pct="50" {{ $req->progress_status == 'Barang Dibeli' ? 'selected' : '' }}>🛍️ Barang Dibeli</option>
                                                <option value="Dikemas & Ready" data-pct="75" {{ $req->progress_status == 'Dikemas & Ready' ? 'selected' : '' }}>📦 Dikemas</option>
                                                <option value="Selesai / Dikirim" data-pct="100" {{ $req->progress_status == 'Selesai / Dikirim' ? 'selected' : '' }}>🚗 Selesai / Kirim</option>
                                            </select>
                                            <input type="hidden" name="progress_percent" value="{{ $req->progress_percent }}">
                                            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-xl text-xs font-bold transition">Update</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Klaim dulu pesanan ini</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($req->status == 'menunggu')
                                        <form action="/request/accept/{{ $req->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-md shadow-pink-500/20">Ambil Pesanan</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-emerald-600 font-extrabold bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">Diproses Tim</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-12 text-center text-slate-500">Belum ada request pesanan masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>