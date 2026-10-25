<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Invoice #JPK-{{ $itemRequest->id }} — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; padding: 0; }
            .no-print { display: none; }
            .shadow-xl { box-shadow: none !important; border: 1px solid #f1f5f9; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen py-10 px-4 flex flex-col items-center justify-center antialiased">

    <!-- TOMBOL AKSI CETAK -->
    <div class="w-full max-w-xl mb-4 flex justify-between items-center no-print">
        <a href="/dashboard-pembeli" class="text-xs font-bold text-pink-600 bg-white hover:bg-pink-50 px-4 py-2 rounded-xl shadow-sm border border-pink-100 transition">
            ← Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-pink-500/20 transition">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <!-- KERTAS INVOICE / RESI -->
    <div class="w-full max-w-xl bg-white border border-pink-100 rounded-3xl p-8 md:p-10 shadow-xl space-y-6">
        
        <!-- HEADER RESI -->
        <div class="flex justify-between items-start border-b border-slate-100 pb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-rose-950 tracking-tight">Jastip<span class="text-pink-500">Kita</span></h1>
                <p class="text-xs text-slate-500 mt-0.5">Layanan Jasa Titip Antar Kota & Provinsi</p>
            </div>
            <div class="text-right">
                <span class="inline-block bg-emerald-50 text-emerald-600 text-xs font-extrabold px-3 py-1 rounded-full border border-emerald-100 uppercase tracking-wider">
                    Lunas / Valid
                </span>
                <p class="text-[11px] text-slate-400 mt-1">No. Ref: #JPK-2026-{{ str_pad($itemRequest->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[11px] text-slate-400">Tanggal: {{ $itemRequest->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- INFO PENGIRIM & PENERIMA -->
        <div class="grid grid-cols-2 gap-4 bg-pink-50/40 p-4 rounded-2xl border border-pink-100/60 text-xs">
            <div>
                <p class="font-bold text-slate-400 uppercase tracking-wider">Pemesan / Pembeli</p>
                <p class="font-extrabold text-rose-950 mt-0.5 text-sm">{{ $itemRequest->user->name ?? 'Pelanggan' }}</p>
                <p class="text-slate-500">{{ $itemRequest->user->email ?? '-' }}</p>
            </div>
            <div>
                <p class="font-bold text-slate-400 uppercase tracking-wider">Tujuan Trip</p>
                <p class="font-extrabold text-rose-950 mt-0.5 text-sm uppercase">{{ $itemRequest->trip->destinasi ?? 'Antar Kota' }}</p>
                <p class="text-slate-500">Jastiper: {{ $itemRequest->trip->user->name ?? 'Vanya Harina Putri' }}</p>
            </div>
        </div>

        <!-- DETAIL BARANG -->
        <div class="space-y-3">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rincian Barang Titipan</h3>
            <div class="border border-slate-100 rounded-2xl p-4 space-y-2">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-bold text-rose-950">{{ $itemRequest->nama_barang }}</span>
                    <span class="font-semibold text-slate-600">{{ $itemRequest->jumlah }} Pcs</span>
                </div>
                <div class="flex justify-between items-center text-xs text-slate-500 border-t border-slate-50 pt-2">
                    <span>Kategori: <b>{{ $itemRequest->kategori ?? 'Umum' }}</b></span>
                    <span>Estimasi Harga: Rp {{ number_format($itemRequest->estimasi_harga, 0, ',', '.') }}</span>
                </div>
                @if($itemRequest->catatan)
                    <p class="text-xs text-slate-400 pt-1 italic">Catatan: "{{ $itemRequest->catatan }}"</p>
                @endif
            </div>
        </div>

        <!-- RINCIAN BIAYA -->
        <div class="border-t border-slate-100 pt-4 space-y-2 text-xs">
            <div class="flex justify-between text-slate-500">
                <span>Subtotal Barang ({{ $itemRequest->jumlah }}x)</span>
                <span>Rp {{ number_format($itemRequest->estimasi_harga * $itemRequest->jumlah, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-500">
                <span>Fee Jasa Titip</span>
                <span>Rp {{ number_format($itemRequest->trip->estimasi_fee ?? 50000, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm font-extrabold text-rose-950 border-t border-slate-100 pt-2">
                <span>Total Pembayaran</span>
                <span class="text-pink-600">Rp {{ number_format(($itemRequest->estimasi_harga * $itemRequest->jumlah) + ($itemRequest->trip->estimasi_fee ?? 50000), 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- FOOTER / TTD & ALAMAT KANTOR -->
        <div class="border-t border-slate-100 pt-6 flex justify-between items-end text-[11px] text-slate-500">
            <div>
                <p class="font-bold text-rose-950">Management JastipKita</p>
                <p class="text-slate-400">Jl. Pemuda No. 128, Semarang Tengah</p>
                <p class="text-pink-600 font-semibold mt-1">Founder: Vanya Harina Putri</p>
            </div>
            <div class="text-center space-y-4">
                <p class="text-[10px] text-slate-400">Dokumen sah dicetak otomatis</p>
                <p class="font-extrabold text-rose-950 underline">Vanya Harina Putri</p>
            </div>
        </div>

    </div>

</body>
</html>