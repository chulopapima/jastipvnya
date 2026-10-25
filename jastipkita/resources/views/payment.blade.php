<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Titipan — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Script Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body class="bg-[#090A0F] text-slate-100 min-h-screen flex items-center justify-center p-6 antialiased">
    <div class="w-full max-w-md bg-slate-900/60 backdrop-blur-xl border border-slate-800/80 rounded-3xl p-8 shadow-2xl text-center space-y-6">
        
        <div class="w-16 h-16 bg-blue-500/10 text-blue-400 rounded-2xl mx-auto flex items-center justify-center text-3xl border border-blue-500/20">
            💳
        </div>
        
        <div>
            <h1 class="text-2xl font-extrabold text-white">Selesaikan Pembayaran</h1>
            <p class="text-slate-400 text-sm mt-2">Rincian tagihan untuk <strong>{{ $itemRequest->nama_barang }}</strong>.</p>
        </div>

        <!-- RINCIAN TAGIHAN: BARANG + FEE -->
        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 text-left space-y-3.5">
            <div class="flex justify-between text-sm">
                <span class="text-slate-400">Harga Barang (x{{ $itemRequest->jumlah }})</span>
                <span class="text-white font-medium">Rp {{ number_format($itemRequest->estimasi_harga * $itemRequest->jumlah, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-400">Fee Jastip</span>
                <span class="text-white font-medium">Rp {{ number_format($jastipFee, 0, ',', '.') }}</span>
            </div>
            <div class="border-t border-slate-800 pt-3.5 flex justify-between items-center">
                <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Tagihan</span>
                <span class="text-xl font-bold text-orange-400">Rp {{ number_format($grossAmount, 0, ',', '.') }}</span>
            </div>
        </div>

        <button id="pay-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold text-sm transition shadow-lg shadow-blue-500/20">
            Bayar Sekarang
        </button>

        <a href="/dashboard-pembeli" class="block text-xs text-slate-500 hover:text-slate-300 transition">Batal dan kembali ke Dashboard</a>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = "/request/success/{{ $itemRequest->id }}";
                },
                onPending: function (result) {
                    alert("Menunggu pembayaran!"); console.log(result);
                },
                onError: function (result) {
                    alert("Pembayaran gagal!"); console.log(result);
                },
                onClose: function () {
                    alert('Kamu menutup popup tanpa menyelesaikan pembayaran.');
                }
            });
        };

        // Otomatis memunculkan popup saat halaman dibuka
        document.getElementById('pay-button').click();
    </script>
</body>
</html>