<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\ItemRequest;
use Illuminate\Support\Facades\Storage;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with('user')->latest()->get();
        return view('welcome', compact('trips'));
    }

    public function dashboardJastiper()
    {
        // Ganti Auth::user()->role dengan session
        if (session('user_role') !== 'jastiper') {
            abort(403);
        }

        $totalTrip = Trip::count();
        $totalPesananSelesai = ItemRequest::where('status', 'diterima')->count();
        
        $totalPendapatan = ItemRequest::where('status', 'diterima')->get()->sum(function($item) {
            return $item->estimasi_harga * $item->jumlah;
        });

        $requests = ItemRequest::with('user', 'trip')->latest()->get();

        return view('dashboard_jastiper', compact('totalTrip', 'totalPesananSelesai', 'totalPendapatan', 'requests'));
    }

    public function create()
    {
        return view('trip_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'destinasi' => 'required|string|max:255',
            'estimasi_fee' => 'required|numeric|min:0',
            'tanggal_berangkat' => 'nullable|date',
            'tanggal_pulang' => 'nullable|date',
            'slot_maksimal' => 'required|integer|min:1',
            'tenants' => 'nullable|array',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;
if ($request->hasFile('foto')) {
    // Upload ke Cloudinary, bukan ke folder lokal
    $fotoPath = cloudinary()->upload($request->file('foto')->getRealPath(), [
        'folder' => 'trip_photos'
    ])->getSecurePath();
}

        Trip::create([
            'user_id' => session('user_id'), // Ganti Auth::id() dengan session
            'destinasi' => $request->destinasi,
            'estimasi_fee' => $request->estimasi_fee,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'tanggal_pulang' => $request->tanggal_pulang,
            'slot_maksimal' => $request->slot_maksimal ?? 50,
            'tenants' => $request->tenants ?? [],
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect('/dashboard-jastiper')->with('success', 'Trip berhasil dibuka!');
    }

    public function edit($id)
    {
        $trip = Trip::findOrFail($id);

        // Ganti Auth::user()->role dengan session
        if (session('user_role') !== 'jastiper') {
            abort(403);
        }

        return view('trip_edit', compact('trip'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'destinasi' => 'required|string|max:255',
            'estimasi_fee' => 'required|numeric|min:0',
            'tanggal_berangkat' => 'nullable|date',
            'tanggal_pulang' => 'nullable|date',
            'slot_maksimal' => 'required|integer|min:1',
            'tenants' => 'nullable|array',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $trip = Trip::findOrFail($id);

        // Ganti Auth::user()->role dengan session
        if (session('user_role') !== 'jastiper') {
            abort(403);
        }

        if ($request->hasFile('foto')) {
            if ($trip->foto) {
                Storage::disk('public')->delete($trip->foto);
            }
            $trip->foto = $request->file('foto')->store('trip_photos', 'public');
        }

        $trip->update([
            'destinasi' => $request->destinasi,
            'estimasi_fee' => $request->estimasi_fee,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'tanggal_pulang' => $request->tanggal_pulang,
            'slot_maksimal' => $request->slot_maksimal,
            'tenants' => $request->tenants ?? [],
            'deskripsi' => $request->deskripsi,
            'foto' => $trip->foto,
        ]);

        return redirect('/dashboard-jastiper')->with('success', 'Trip berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);

        // Ganti Auth::user()->role dengan session
        if (session('user_role') !== 'jastiper') {
            abort(403);
        }

        if ($trip->foto) {
            Storage::disk('public')->delete($trip->foto);
        }

        $trip->delete();

        return redirect('/dashboard-jastiper')->with('success', 'Trip berhasil dihapus!');
    }
}