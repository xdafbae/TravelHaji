<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangJamaah extends Model
{
    use HasFactory;

    protected $table = 'barang_jamaah';

    protected $guarded = ['id'];

    protected $casts = [
        'tgl_penyerahan' => 'date',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah');
    }
}
