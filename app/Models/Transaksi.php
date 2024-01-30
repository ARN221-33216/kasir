<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tbl_transaksi';

    protected $fillable = [
        'no_transaksi',
        'tgl_transaksi',
        'diskon',
        'total_bayar',
        'kembalian',
        'uang_pembeli'
    ];

    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'no_transaksi', 'no_transaksi');
    }
}
