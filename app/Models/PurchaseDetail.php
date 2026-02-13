<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_detail';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'waktu_input' => 'datetime',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'id_purchase');
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class, 'id_stok');
    }
}
