<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Trip Jastip Baru — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-10 px-4 flex items-center justify-center antialiased selection:bg-pink-500 selection:text-white">

    <div class="w-full max-w-2xl bg-white border border-pink-100 rounded-3xl p-8 md:p-10 shadow-xl shadow-pink-900/5 space-y-6">
        
        <div class="flex items-center justify-between border-b border-pink-50 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl border border-pink-100 shadow-sm">
                    ✈️
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-rose-950">Buka Trip Jastip Baru</h1>
                    <p class="text-slate-500 text-xs mt-0.5">Tentukan kota tujuan, tenant mall, dan kuota slot kamu.</p>
                </div>
            </div>
            <a href="/dashboard-jastiper" class="text-xs font-bold text-pink-600 bg-pink-50 hover:bg-pink-100 px-4 py-2 rounded-xl transition">Kembali</a>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs space-y-1 font-medium">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/trip/store" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kota Destinasi / Tujuan</label>
                <input type="text" name="destinasi" value="{{ old('destinasi') }}" required placeholder="Contoh: Semarang, Jakarta, Yogyakarta..." class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm font-medium">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" value="{{ old('tanggal_berangkat') }}" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 focus:outline-none focus:border-pink-500 text-sm font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Pulang</label>
                    <input type="date" name="tanggal_pulang" value="{{ old('tanggal_pulang') }}" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 focus:outline-none focus:border-pink-500 text-sm font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Estimasi Fee Jastip (Rp)</label>
                    <input type="number" name="estimasi_fee" value="{{ old('estimasi_fee') }}" required placeholder="Contoh: 50000" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 focus:outline-none focus:border-pink-500 text-sm font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Maksimal Kuota Slot Barang</label>
                    <input type="number" name="slot_maksimal" value="{{ old('slot_maksimal', 50) }}" min="1" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 focus:outline-none focus:border-pink-500 text-sm font-medium">
                </div>
            </div>

            <!-- PILIHAN TENANT / TOKO -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Tenant / Mall / Toko yang Dikunjungi</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-pink-50/40 border border-pink-100 rounded-2xl">
                    @foreach(['Footlocker', 'H&M', 'Uniqlo', 'Zara', 'Sephora', 'Miniso', 'Smiggle', 'The Executive', 'Lainnya'] as $tenant)
                        <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="tenants[]" value="{{ $tenant }}" class="w-4 h-4 text-pink-600 rounded border-pink-300 focus:ring-pink-500">
                            {{ $tenant }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi & Catatan Trip</label>
                <textarea name="deskripsi" rows="3" placeholder="Contoh: Fokus belanja di mall Paragon & DP Mall Semarang..." class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 text-sm font-medium">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Banner Trip (Opsional)</label>
                <input type="file" name="foto" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 transition">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-4 rounded-2xl font-extrabold text-sm transition shadow-lg shadow-pink-500/25 text-center">
                    Buka Trip Sekarang 🚀
                </button>
            </div>
        </form>

    </div>
</body>
</html>