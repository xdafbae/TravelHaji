<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'purchase';
    protected $primaryKey = 'id_purchase';

    protected $guarded = ['id_purchase'];

    protected $casts = [
        'waktu_preorder' => 'datetime',
        'tgl_barang_datang' => 'date',
        'tgl_lunas' => 'date',
        'galeri' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'id_purchase');
    }
}
