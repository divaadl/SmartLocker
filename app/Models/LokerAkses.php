<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LokerAkses extends Model
{
    use HasFactory;

    protected $table = 'loker_akses';

    protected $fillable = [
        'loker_id',
        'card_id',
        'kode_akses',
        'awal_sewa',
        'akhir_sewa',
        'status',
    ];

    public function loker(): BelongsTo
    {
        return $this->belongsTo(Loker::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_loker_akses');
    }
}
