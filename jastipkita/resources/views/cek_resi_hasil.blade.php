<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Resi Pesanan — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-12 px-4 flex flex-col items-center antialiased">

    <div class="w-full max-w-xl space-y-6">
        <!-- Header -->
        <div class="text-center space-y-2">
            <a href="/" class="inline-block text-xs font-bold text-pink-600 bg-pink-50 hover:bg-pink-100 px-4 py-2 rounded-xl transition mb-2">← Kembali ke Beranda</a>
            <h1 class="text-3xl font-extrabold text-rose-950">📦 Lacak Resi & Titipan</h1>
            <p class="text-xs text-slate-500">Masukkan nomor referensi atau ID pesanan JastipKita kamu.</p>
        </div>

        <!-- Form Pencarian -->
        <form action="/cek-resi" method="GET" class="bg-white border border-pink-100 rounded-3xl p-4 shadow-xl flex gap-2">
            <input type="text" name="resi" value="{{ $keyword ?? '' }}" required placeholder="Contoh: 1 (ID Pesanan)" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-2xl text-slate-800 focus:outline-none focus:border-pink-500 text-sm font-medium">
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-2xl font-bold text-sm transition shadow-lg whitespace-nowrap">
                Cari Resi
            </button>
        </form>

        <!-- Hasil Pencarian -->
        @if(isset($result))
            @if($result)
                <div class="bg-white border border-pink-100 rounded-3xl p-8 shadow-xl space-y-6">
                    <div class="flex justify-between items-center border-b border-pink-50 pb-4">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Status Pesanan</p>
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-extrabold 
                                @if($result->status == 'diterima' || $result->status == 'selesai') bg-emerald-50 text-emerald-600 border border-emerald-100 
                                @elseif($result->status == 'diproses') bg-amber-50 text-amber-600 border border-amber-100 
                                @else bg-rose-50 text-rose-600 border border-rose-100 @endif uppercase">
                                {{ $result->status }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-400 font-bold">No. Referensi</p>
                            <p class="text-sm font-extrabold text-rose-950">#JPK-{{ str_pad($result->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-bold">Nama Barang</span>
                            <span class="font-extrabold text-rose-950">{{ $result->nama_barang }} ({{ $result->jumlah }} Pcs)</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-bold">Kategori</span>
                            <span class="font-semibold text-slate-700">{{ $result->kategori ?? 'Umum' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-bold">Kota Tujuan Trip</span>
                            <span class="font-extrabold text-pink-600 uppercase">{{ $result->trip->destinasi ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-bold">Pemesan</span>
                            <span class="font-semibold text-slate-700">{{ $result->user->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-slate-400 font-bold">Nomor Resi Kurir</span>
                            <span class="font-bold text-rose-950">{{ $result->no_resi ?? 'Belum diinput jastiper' }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-pink-50 flex gap-3">
                        <a href="/request/resi/{{ $result->id }}" target="_blank" class="w-full bg-pink-50 hover:bg-pink-100 text-pink-600 text-center py-3 rounded-2xl font-bold text-xs transition">
                            🖨️ Cetak Invoice / Resi
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white border border-pink-100 rounded-3xl p-10 text-center shadow-sm space-y-2">
                    <div class="text-3xl">🔍</div>
                    <h3 class="text-base font-bold text-rose-950">Resi tidak ditemukan</h3>
                    <p class="text-xs text-slate-400">Pastikan nomor referensi atau ID pesanan yang kamu masukkan sudah benar.</p>
                </div>
            @endif
        @endif
    </div>

</body>
</html>