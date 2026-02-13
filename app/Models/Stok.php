<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $primaryKey = 'id_stok';

    protected $guarded = ['id_stok'];

    protected $casts = [
        'is_tersedia' => 'boolean',
        'waktu_input' => 'datetime',
    ];
}
