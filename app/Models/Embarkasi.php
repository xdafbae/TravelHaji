<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embarkasi extends Model
{
    use HasFactory;

    protected $table = 'embarkasi';
    protected $primaryKey = 'id_embarkasi';

    protected $guarded = ['id_embarkasi'];

    protected $casts = [
        'waktu_keberangkatan' => 'datetime',
        'waktu_kepulangan' => 'datetime',
    ];

    public function tourLeader()
    {
        return $this->belongsTo(Pegawai::class, 'id_tour_leader');
    }

    public function jamaah()
    {
        return $this->belongsToMany(Jamaah::class, 'embarkasi_detail', 'id_embarkasi', 'id_jamaah')
                    ->withPivot('seat_number', 'payment_status', 'document_status', 'assigned_at');
    }

    public function manifests()
    {
        return $this->hasMany(Manifest::class, 'id_embarkasi');
    }
}
