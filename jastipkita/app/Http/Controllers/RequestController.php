<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    public function create(Request $request)
    {
        return view('request_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'kategori' => 'required|string',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'estimasi_harga' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_barang')) {
            $fotoPath = $request->file('foto_barang')->store('item_requests', 'public');
        }

        ItemRequest::create([
            'user_id' => Auth::id(),
            'trip_id' => $request->trip_id,
            'kategori' => $request->kategori,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'estimasi_harga' => $request->estimasi_harga,
            'catatan' => $request->catatan,
            'foto_barang' => $fotoPath,
            'status' => 'menunggu',
        ]);

        return redirect('/dashboard-pembeli')->with('success', 'Request titipan berhasil dikirim!');
    }

    // TERIMA PESANAN OLEH JASTIPER
    public function accept($id)
    {
        $item = ItemRequest::findOrFail($id);
        $item->update(['status' => 'diproses']);
        return back()->with('success', 'Pesanan diterima dan mulai diproses!');
    }

    // TOLAK PESANAN OLEH JASTIPER
    public function reject($id)
    {
        $item = ItemRequest::findOrFail($id);
        $item->update(['status' => 'ditolak']);
        return back()->with('success', 'Pesanan ditolak.');
    }

    // UPDATE PROGRESS / NO RESI OLEH JASTIPER (SUDAH DIPERBAIKI)
    public function updateProgress(Request $request, $id)
    {
        $item = ItemRequest::findOrFail($id);
        
        $request->validate([
            'progress_status' => 'required|string',
            'progress_percent' => 'required|numeric',
            'no_resi' => 'nullable|string|max:255',
        ]);

        $item->update([
            'progress_status' => $request->progress_status,
            'progress_percent' => $request->progress_percent,
            'no_resi' => $request->no_resi ?? $item->no_resi,
        ]);

        return back()->with('success', 'Progress pesanan berhasil diperbarui!');
    }

    // HALAMAN PEMBAYARAN MIDTRANS
    public function pay($id)
    {
        $itemRequest = ItemRequest::with('trip')->findOrFail($id);
        return view('request_pay', compact('itemRequest'));
    }

    // SUKSES PEMBAYARAN MIDTRANS
    public function success($id)
    {
        $itemRequest = ItemRequest::findOrFail($id);
        $itemRequest->update(['status' => 'diterima']);
        return redirect('/dashboard-pembeli')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // HAPUS REQUEST OLEH PEMBELI
    public function destroy($id)
    {
        $item = ItemRequest::findOrFail($id);
        if ($item->foto_barang) {
            Storage::disk('public')->delete($item->foto_barang);
        }
        $item->delete();
        return back()->with('success', 'Request berhasil dibatalkan.');
    }

    // CETAK RESI / INVOICE
    public function cetakResi($id)
    {
        $itemRequest = ItemRequest::with('user', 'trip')->findOrFail($id);
        return view('request_resi', compact('itemRequest'));
    }

    // CEK RESI PUBLIK
    public function cekResi(Request $request)
    {
        $keyword = $request->input('resi');
        $result = null;

        if ($keyword) {
            $cleanId = str_replace(['#JPK-', 'JPK-', '#'], '', $keyword);
            
            $result = ItemRequest::with('user', 'trip')->where('id', $cleanId)
                        ->orWhere('no_resi', 'LIKE', '%' . $keyword . '%')
                        ->first();
        }

        return view('cek_resi_hasil', compact('result', 'keyword'));
    }
}