<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use HasFactory;

    protected $table = 'price_list';
    protected $primaryKey = 'id_pricelist';

    protected $fillable = [
        'nama_item',
        'kode_item',
        'harga',
        'form_a',
        'form_b',
        'form_c',
        'form_d',
        'form_d_barang',
        'form_d_jasa',
        'keterangan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'form_a' => 'boolean',
        'form_b' => 'boolean',
        'form_c' => 'boolean',
        'form_d' => 'boolean',
        'form_d_barang' => 'boolean',
        'form_d_jasa' => 'boolean',
        'is_active' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];
}
