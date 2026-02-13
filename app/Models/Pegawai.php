<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'nama_pegawai',
        'nik',
        'no_kk',
        'no_hp',
        'tgl_lahir',
        'alamat',
        'inisial',
        'jabatan',
        'wilayah',
        'tim_syiar',
        'username',
        'password',
        'foto_pegawai',
        'tanda_tangan',
        'status',
        'last_login',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'tgl_lahir' => 'date',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'pegawai_roles', 'id_pegawai', 'id_role')
                    ->withPivot('assigned_at', 'assigned_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_pegawai');
    }

    // Helper to check role
    public function hasRole($roleName)
    {
        return $this->roles()->where('nama_role', $roleName)->exists();
    }
}
