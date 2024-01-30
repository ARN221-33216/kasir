<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'tbl_detail_transaksi';

    protected $fillable = [
        'no_transaksi',
        'id_barang',
        'qty',
    ];

    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function detail(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }
}
