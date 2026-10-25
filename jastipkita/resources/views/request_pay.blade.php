<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Midtrans — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Midtrans Snap JS (Ganti client key sandbox kamu jika perlu) -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-XXXXX"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-10 px-4 flex items-center justify-center antialiased">

    <div class="w-full max-w-lg bg-white border border-pink-100 rounded-3xl p-8 md:p-10 shadow-xl space-y-6 text-center">
        
        <div class="w-16 h-16 bg-pink-50 text-pink-600 rounded-2xl mx-auto flex items-center justify-center text-3xl border border-pink-100 shadow-sm">
            💳
        </div>

        <div>
            <h1 class="text-2xl font-extrabold text-rose-950">Selesaikan Pembayaran</h1>
            <p class="text-slate-500 text-xs mt-1">Pembayaran aman terintegrasi dengan Midtrans.</p>
        </div>

        <div class="bg-pink-50/50 border border-pink-100 rounded-2xl p-4 text-left space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-500 font-bold">No. Referensi</span>
                <span class="font-extrabold text-rose-950">#JPK-{{ str_pad($itemRequest->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500 font-bold">Barang Titipan</span>
                <span class="font-extrabold text-rose-950">{{ $itemRequest->nama_barang }} ({{ $itemRequest->jumlah }}x)</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500 font-bold">Estimasi Harga</span>
                <span class="font-semibold">Rp {{ number_format($itemRequest->estimasi_harga * $itemRequest->jumlah, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500 font-bold">Fee Jastip</span>
                <span class="font-semibold">Rp {{ number_format($itemRequest->trip->estimasi_fee ?? 50000, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between border-t border-pink-100 pt-2 text-sm font-extrabold text-rose-950">
                <span>Total Tagihan</span>
                <span class="text-pink-600">Rp {{ number_format(($itemRequest->estimasi_harga * $itemRequest->jumlah) + ($itemRequest->trip->estimasi_fee ?? 50000), 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="space-y-3 pt-2">
            <!-- Tombol Trigger Midtrans / Simulasi Sukses -->
            <button id="pay-button" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-4 rounded-2xl font-extrabold text-sm transition shadow-lg shadow-pink-500/25">
                Bayar Sekarang via Midtrans 🔒
            </button>
            
            <a href="/dashboard-pembeli" class="block w-full bg-pink-50 hover:bg-pink-100 text-pink-600 py-3 rounded-2xl font-bold text-xs transition">
                Kembali ke Dashboard
            </a>
        </div>

    </div>

    <script>
        // Simulasi atau Redirect sukses pembayaran setelah bayar
        document.getElementById('pay-button').onclick = function () {
            // Untuk keperluan tugas/demo, langsung diarahkan ke rute sukses agar status berubah jadi diterima & resi bisa dicetak
            alert('Simulasi Pembayaran Midtrans Berhasil!');
            window.location.href = '/request/success/{{ $itemRequest->id }}';
        };
    </script>

</body>
</html>