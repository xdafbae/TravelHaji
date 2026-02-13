<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jamaah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jamaah';
    protected $primaryKey = 'id_jamaah';

    protected $guarded = ['id_jamaah'];

    protected $casts = [
        'tgl_lahir' => 'date',
        'is_active' => 'boolean',
    ];

    public function passport()
    {
        return $this->hasOne(Passport::class, 'id_jamaah');
    }

    public function embarkasi()
    {
        return $this->belongsToMany(Embarkasi::class, 'embarkasi_detail', 'id_jamaah', 'id_embarkasi')
                    ->withPivot('seat_number', 'payment_status', 'document_status', 'assigned_at');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_jamaah');
    }

    public function barang()
    {
        return $this->hasMany(BarangJamaah::class, 'id_jamaah');
    }
}
