<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kas';
    protected $primaryKey = 'id_kas';

    protected $guarded = ['id_kas'];

    protected $casts = [
        'tanggal' => 'date',
        'is_deleted' => 'boolean',
    ];

    public function kodeAkuntansi()
    {
        return $this->belongsTo(KodeAkuntansi::class, 'kode_akuntansi_id');
    }

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'id_purchase');
    }
}
