<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trip Jastip — JastipKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50/30 text-slate-800 min-h-screen py-10 px-4 flex items-center justify-center antialiased">
    
    <div class="w-full max-w-2xl bg-white border border-pink-100 rounded-3xl p-8 md:p-10 shadow-xl space-y-6">
        
        <!-- HEADER -->
        <div class="flex items-center justify-between border-b border-pink-50 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-2xl border border-pink-100">✏️</div>
                <div>
                    <h1 class="text-2xl font-extrabold text-rose-950">Edit Trip Jastip</h1>
                    <p class="text-slate-500 text-xs mt-0.5">Perbarui informasi perjalanan trip jastip kamu.</p>
                </div>
            </div>
            <a href="/dashboard-jastiper" class="text-xs font-bold text-pink-600 bg-pink-50 hover:bg-pink-100 px-4 py-2 rounded-xl transition">Kembali</a>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- FORM EDIT TRIP -->
        <form action="/trip/update/{{ $trip->id }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Destinasi / Kota Tujuan</label>
                <input type="text" name="destinasi" value="{{ old('destinasi', $trip->destinasi) }}" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-pink-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" value="{{ old('tanggal_berangkat', $trip->tanggal_berangkat) }}" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Tanggal Pulang</label>
                    <input type="date" name="tanggal_pulang" value="{{ old('tanggal_pulang', $trip->tanggal_pulang) }}" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Estimasi Fee / Harga Jastip (Rp)</label>
                    <input type="number" name="estimasi_fee" value="{{ old('estimasi_fee', $trip->estimasi_fee) }}" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Slot Maksimal Kuota Barang</label>
                    <input type="number" name="slot_maksimal" value="{{ old('slot_maksimal', $trip->slot_maksimal ?? 50) }}" min="1" required class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-pink-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Catatan / Deskripsi Trip</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 bg-pink-50/50 border border-pink-100 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-pink-500">{{ old('deskripsi', $trip->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Ganti Foto (Opsional)</label>
                @if($trip->foto)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $trip->foto) }}" alt="Foto Trip" class="w-24 h-24 object-cover rounded-xl border border-pink-100">
                    </div>
                @endif
                <input type="file" name="foto" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-pink-100 file:text-pink-700">
            </div>

            <div class="pt-4 flex gap-3">
                <a href="/dashboard-jastiper" class="w-1/2 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3.5 rounded-2xl font-bold text-sm text-center transition">Batal</a>
                <button type="submit" class="w-1/2 bg-pink-500 hover:bg-pink-600 text-white py-3.5 rounded-2xl font-extrabold text-sm shadow-lg shadow-pink-500/25 transition">Update Trip</button>
            </div>
        </form>

    </div>

</body>
</html>