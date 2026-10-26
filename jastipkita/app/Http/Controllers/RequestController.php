<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemRequest;

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
            // Upload foto barang ke Cloudinary
            $fotoPath = cloudinary()->upload($request->file('foto_barang')->getRealPath(), [
                'folder' => 'item_requests'
            ])->getSecurePath();
        }

        ItemRequest::create([
            'user_id' => session('user_id'),
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

    public function accept($id)
    {
        $item = ItemRequest::findOrFail($id);
        $item->update(['status' => 'menunggu_pembayaran']); 
        return back()->with('success', 'Pesanan diterima, menunggu pembeli membayar!');
    }

    public function reject($id)
    {
        $item = ItemRequest::findOrFail($id);
        $item->update(['status' => 'ditolak']);
        return back()->with('success', 'Pesanan ditolak.');
    }

    public function updateProgress(Request $request, $id)
    {
        $item = ItemRequest::findOrFail($id);
        
        $request->validate([
            'progress_status' => 'required|string',
            'progress_percent' => 'required|numeric',
            'no_resi' => 'nullable|string|max:255',
        ]);

        $data = [
            'progress_status' => $request->progress_status,
            'progress_percent' => $request->progress_percent,
            'no_resi' => $request->no_resi ?? $item->no_resi,
        ];

        if ($request->progress_status === 'Selesai') {
            $data['status'] = 'diterima';
        }

        $item->update($data);

        return back()->with('success', 'Progress pesanan berhasil diperbarui!');
    }

    public function pay($id)
    {
        $itemRequest = ItemRequest::with('trip')->findOrFail($id);
        return view('request_pay', compact('itemRequest'));
    }

    public function success($id)
    {
        $itemRequest = ItemRequest::findOrFail($id);
        $itemRequest->update(['status' => 'diproses']);
        return redirect('/dashboard-pembeli')->with('success', 'Pembayaran berhasil! Jastiper akan segera membelikan pesananmu.');
    }

    public function destroy($id)
    {
        $item = ItemRequest::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Request berhasil dibatalkan.');
    }

    public function cetakResi($id)
    {
        $itemRequest = ItemRequest::with('user', 'trip')->findOrFail($id);
        return view('request_resi', compact('itemRequest'));
    }

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