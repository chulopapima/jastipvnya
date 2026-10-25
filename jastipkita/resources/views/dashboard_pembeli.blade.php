<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-8 px-4 sm:px-6 antialiased selection:bg-pink-500 selection:text-white flex flex-col">
    
    <div class="max-w-7xl mx-auto space-y-8 w-full flex-grow">
        
        <!-- HEADER -->
        <div class="relative w-full bg-white border border-pink-100 rounded-[2rem] overflow-hidden shadow-xl shadow-pink-900/5 p-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left space-y-2">
                <div class="inline-flex items-center gap-2 bg-pink-100 text-pink-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider mb-2">
                    Dashboard Pembeli
                </div>
                <h1 class="text-3xl font-extrabold text-rose-950 tracking-tight">Halo, {{ Auth::user()->name }}! 🛒</h1>
                <p class="text-slate-500 text-sm">Pantau pesanan antar kota kamu di sini.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="/" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition">🏠 Home</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-pink-500/30">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-2xl text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABEL PESANAN -->
        <div class="bg-white border border-pink-100 rounded-3xl p-6 shadow-sm space-y-5">
            <h2 class="text-lg font-extrabold text-rose-950 flex items-center gap-2">📦 Riwayat Pesanan & Progress</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-pink-50 text-pink-800 uppercase text-[11px] tracking-wider border-b border-pink-100">
                        <tr>
                            <th class="p-4 rounded-tl-2xl">Barang & Kategori</th>
                            <th class="p-4">Kota Destinasi</th>
                            <th class="p-4">Est. Harga</th>
                            <th class="p-4">Status Pesanan</th>
                            <th class="p-4 text-center rounded-tr-2xl">Aksi Pembeli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $myRequests = App\Models\ItemRequest::where('user_id', Auth::id())->with('trip')->latest()->get();
                        @endphp
                        @forelse($myRequests as $req)
                            <tr class="hover:bg-pink-50/30 transition">
                                <td class="p-4">
                                    <p class="font-bold text-rose-950">{{ $req->nama_barang }}</p>
                                    <span class="text-xs text-pink-500 font-semibold">[{{ $req->kategori }}] • {{ $req->jumlah }} pcs</span>
                                    @if($req->catatan)
                                        <p class="text-[11px] text-slate-400 italic mt-0.5">Catatan: "{{ $req->catatan }}"</p>
                                    @endif
                                </td>
                                <td class="p-4 font-semibold text-slate-600 uppercase">🏙️ {{ $req->trip->destinasi ?? '-' }}</td>
                                <td class="p-4 font-bold text-pink-600">Rp {{ number_format($req->estimasi_harga * $req->jumlah, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @if($req->status == 'menunggu')
                                        <span class="inline-block bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold">Menunggu Konfirmasi Jastiper</span>
                                    @elseif($req->status == 'diproses')
                                        <span class="inline-block bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold">Disetujui / Belum Dibayar</span>
                                    @elseif($req->status == 'diterima' || $req->status == 'selesai')
                                        <div class="flex flex-col gap-1.5 w-max">
                                            <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold">
                                                ✔ Lunas
                                            </span>
                                            <!-- Menampilkan Detail Progress yang diupdate Jastiper -->
                                            @if($req->progress_status)
                                                <span class="text-[11px] font-extrabold text-pink-600 bg-pink-50 px-2 py-0.5 rounded-lg border border-pink-100">
                                                    📍 {{ $req->progress_status }} ({{ $req->progress_percent }}%)
                                                </span>
                                            @else
                                                <span class="text-[11px] font-bold text-slate-400">
                                                    📍 Menunggu Proses
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-block bg-rose-50 text-rose-700 border border-rose-200 px-3 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($req->status == 'menunggu')
                                        <form action="/request/delete/{{ $req->id }}" method="POST" class="inline" onsubmit="return confirm('Batalkan request ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-rose-50 hover:bg-rose-500 hover:text-white text-rose-600 px-3 py-1.5 rounded-xl text-xs font-bold transition">Batalkan</button>
                                        </form>
                                    @elseif($req->status == 'diproses')
                                        <a href="/request/pay/{{ $req->id }}" class="inline-block bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-md shadow-pink-500/20">
                                            💳 Bayar via Midtrans
                                        </a>
                                    @elseif($req->status == 'diterima' || $req->status == 'selesai')
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="/request/resi/{{ $req->id }}" target="_blank" class="bg-pink-50 hover:bg-pink-100 text-pink-600 px-3 py-1.5 rounded-xl text-xs font-bold transition">
                                                🖨️ Cetak Resi
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Dibatalkan / Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-12 text-center text-slate-500">Belum ada riwayat pesanan titipan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>