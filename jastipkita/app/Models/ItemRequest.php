<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'nama_barang',
        'kategori',
        'ukuran',
        'destinasi',
        'jumlah',
        'estimasi_harga',
        'metode_pembayaran',
        'keterangan',
        'foto',
        'bukti_bayar',
        'status',
        'progress_status',
        'progress_percent',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}