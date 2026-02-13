<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
        'deskripsi',
        'super_admin',
        'registrasi',
        'kasir',
        'keuangan',
        'tour_leader',
        'agen_marketing',
        'purchase',
    ];

    protected $casts = [
        'super_admin' => 'boolean',
        'registrasi' => 'boolean',
        'kasir' => 'boolean',
        'keuangan' => 'boolean',
        'tour_leader' => 'boolean',
        'agen_marketing' => 'boolean',
        'purchase' => 'boolean',
    ];

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_roles', 'id_role', 'id_pegawai');
    }
}
