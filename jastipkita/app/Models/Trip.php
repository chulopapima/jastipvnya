<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destinasi',
        'estimasi_fee',
        'tanggal_berangkat',
        'tanggal_pulang',
        'deskripsi',
        'foto',
        'slot_maksimal',
        'tenants',
    ];

    protected $casts = [
        'tenants' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk menghitung sisa slot kuota secara otomatis
    public function sisaSlot()
    {
        $terpakai = ItemRequest::where('trip_id', $this->id)
                        ->whereIn('status', ['menunggu', 'diterima'])
                        ->sum('jumlah');
        
        return max(0, $this->slot_maksimal - $terpakai);
    }
}