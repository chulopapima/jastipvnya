<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli - JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 antialiased min-h-screen pb-20">

    <nav class="bg-white/85 backdrop-blur-xl border-b border-pink-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                    <span class="text-xl font-extrabold text-rose-950 tracking-tight">Jastip<span class="text-pink-500">Kita</span></span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                <a href="/" class="bg-pink-50 hover:bg-pink-100 text-pink-600 px-4 py-2 rounded-xl text-sm font-bold transition">🏠 Home</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition shadow-md">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10 space-y-8">
        
        <div class="bg-white border border-pink-100 rounded-3xl p-8 shadow-sm">
            <div class="inline-flex items-center gap-2 bg-pink-100 text-pink-700 text-xs px-3 py-1 rounded-full font-bold uppercase mb-3">DASHBOARD PEMBELI</div>
            <h1 class="text-3xl font-extrabold text-rose-950">Halo, {{ session('user_name') }}! 🛒</h1>
            <p class="text-slate-500 mt-1">Pantau pesanan antar kota kamu di sini.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl font-semibold shadow-sm">✅ {{ session('success') }}</div>
        @endif

        <div class="bg-white border border-pink-100 rounded-3xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-pink-100">
                <h2 class="text-xl font-extrabold text-rose-950">📦 Riwayat Pesanan & Progress</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-pink-50/50 text-slate-500 text-sm">
                            <th class="py-4 px-6 font-semibold">Barang & Kategori</th>
                            <th class="py-4 px-6 font-semibold">Kota Destinasi</th>
                            <th class="py-4 px-6 font-semibold">Est. Harga</th>
                            <th class="py-4 px-6 font-semibold">Status Pesanan</th>
                            <th class="py-4 px-6 font-semibold">Aksi Pembeli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50">
                        @forelse($myRequests ?? [] as $req)
                            <tr class="hover:bg-pink-50/30 transition">
                                <td class="py-4 px-6">
                                    <p class="font-bold text-rose-950">{{ $req->nama_barang }}</p>
                                    <p class="text-xs text-slate-500 uppercase">{{ $req->kategori }} - {{ $req->jumlah }} pcs</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-slate-700 capitalize">{{ $req->trip->destinasi ?? 'Trip Dihapus' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-bold text-rose-950">Rp {{ number_format($req->estimasi_harga, 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    @if($req->status === 'menunggu')
                                        <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1 rounded-full">Menunggu Acc</span>
                                    @elseif($req->status === 'menunggu_pembayaran')
                                        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">Menunggu Bayar</span>
                                    @elseif($req->status === 'diproses')
                                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">Diproses Jastiper</span>
                                    @elseif($req->status === 'ditolak')
                                        <span class="bg-rose-100 text-rose-700 text-xs font-bold px-3 py-1 rounded-full">Ditolak</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Selesai</span>
                                    @endif

                                    @if($req->progress_status)
                                        <p class="text-[11px] font-semibold mt-1 text-slate-500">Progress: {{ $req->progress_status }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($req->status === 'menunggu')
                                        <form action="/request/delete/{{ $req->id }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">Batal</button>
                                        </form>
                                    @elseif($req->status === 'menunggu_pembayaran')
                                        <a href="/request/pay/{{ $req->id }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Bayar Sekarang</a>
                                    @elseif($req->status === 'diproses')
                                        <span class="text-xs text-slate-400 font-semibold">Menunggu Jastiper Belanja</span>
                                    @elseif($req->status === 'diterima')
                                        <a href="/request/resi/{{ $req->id }}" class="bg-pink-100 hover:bg-pink-200 text-pink-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">Cetak Resi</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">Belum ada riwayat pesanan titipan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>