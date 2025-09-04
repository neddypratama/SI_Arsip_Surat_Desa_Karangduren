<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'judul',
        'tanggal',
        'file',
        'kategori_id'
    ];

     public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
