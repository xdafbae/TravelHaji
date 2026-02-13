<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    protected $table = 'passport';
    protected $primaryKey = 'id_passport';

    protected $guarded = ['id_passport'];

    protected $casts = [
        'birth_date' => 'date',
        'date_issued' => 'date',
        'date_expire' => 'date',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'id_jamaah');
    }

    public function manifest()
    {
        return $this->hasOne(Manifest::class, 'id_passport');
    }
}
