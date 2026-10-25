<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Titipan Barang — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-10 px-4 flex items-center justify-center antialiased selection:bg-pink-500 selection:text-white">

    <div class="w-full max-w-2xl bg-white border border-pink-100 rounded-3xl p-8 md:p-10 shadow-xl shadow-pink-900/5 space-y-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-pink-50 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl border border-pink-100 shadow-sm">
                    🛍️
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-rose-950">Detail Titip Barang</h1>
                    <p class="text-slate-500 text-xs mt-0.5">Isi detail barang yang ingin kamu titipkan.</p>
                </div>
            </div>
            <a href="/" class="text-xs font-bold text-pink-600 bg-pink-50 hover:bg-pink-100 px-4 py-2 rounded-xl transition">Kembali</a>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs space-y-1 font-medium">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @php
            $selectedTrip = request('trip_id') ? \App\Models\Trip::with('user')->find(request('trip_id')) : null;
        @endphp

        <!-- Kotak Info Detail Trip -->
        @if($selectedTrip)
            <div class="bg-pink-50/50 border border-pink-100 rounded-2xl p-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    @if($selectedTrip->foto)
                        <img src="{{ asset('storage/' . $selectedTrip->foto) }}" alt="Foto Trip" class="w-14 h-14 rounded-xl object-cover border border-pink-200 shadow-sm">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-pink-500 text-white flex items-center justify-center text-xl font-bold shadow-md shadow-pink-500/20">
                            🏙️
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-bold text-pink-600 uppercase tracking-wider">Destinasi Pilihan</p>
                        <h3 class="text-lg font-extrabold text-rose-950 capitalize">{{ $selectedTrip->destinasi }}</h3>
                        <p class="text-xs text-slate-500">Jastiper: {{ $selectedTrip->user->name ?? 'Tim JastipKita' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-white border border-pink-100 text-pink-600 text-xs font-extrabold px-3 py-1.5 rounded-xl shadow-sm">
                        Fee: Rp {{ number_format($selectedTrip->estimasi_fee, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @endif

        <!-- Form Request Titip -->
        <form action="/request/store" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if(request('trip_id'))
                <input type="hidden" name="trip_id" value="{{ request('trip_id') }}">
            @endif

            <!-- Kategori Barang -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Barang</label>
                <select name="kategori" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm font-medium">
                    <option value="" disabled selected>Pilih Kategori Barang</option>
                    <option value="Makanan / Oleh-oleh">Makanan / Oleh-oleh</option>
                    <option value="Fashion / Pakaian">Fashion / Pakaian</option>
                    <option value="Skincare / Kosmetik">Skincare / Kosmetik</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Barang / Model Spesifik</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required placeholder="Contoh: Makaroni Ngehe / Onitsuka Tiger..." class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm font-medium">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jumlah (Pcs)</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Estimasi Harga Asli (Rp)</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-sm font-bold text-slate-400">Rp</span>
                        <!-- Input teks yang menampilkan titik otomatis -->
                        <input type="text" id="input_harga_format" required placeholder="150.000" class="w-full pl-12 pr-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm font-medium" oninput="formatRupiah(this)">
                        
                        <!-- Input hidden angka asli tanpa titik yang dikirim ke database -->
                        <input type="hidden" name="estimasi_harga" id="estimasi_harga_asli" value="{{ old('estimasi_harga') }}">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan, Warna, atau Link Referensi</label>
                <textarea name="catatan" rows="3" placeholder="Contoh: Pedes asin, pastikan nota toko asli disertakan..." class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition text-sm font-medium">{{ old('catatan') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Referensi Barang (Opsional)</label>
                <input type="file" name="foto_barang" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 transition">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-4 rounded-2xl font-extrabold text-sm transition shadow-lg shadow-pink-500/25 text-center">
                    Kirim Request Titipan 🛒
                </button>
            </div>
        </form>

    </div>

    <!-- Script Format Titik Rupiah Otomatis -->
    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            input.value = rupiah;

            // Simpan angka asli tanpa titik ke input hidden
            document.getElementById('estimasi_harga_asli').value = value;
        }
    </script>

</body>
</html>