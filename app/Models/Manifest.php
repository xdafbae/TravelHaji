<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory;

    protected $table = 'manifest';
    protected $primaryKey = 'id_manifest';

    protected $guarded = ['id_manifest'];

    protected $casts = [
        'tgl_manifest' => 'date',
    ];

    public function passport()
    {
        return $this->belongsTo(Passport::class, 'id_passport');
    }

    public function embarkasi()
    {
        return $this->belongsTo(Embarkasi::class, 'id_embarkasi');
    }
}
