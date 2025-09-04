<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'keterangan'
    ];

    public function arsip(): HasMany
    {
        return $this->hasMany(User::class, 'kategori_id');
    }
}
