<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel extends Model
{
    protected $fillable = ['nama'];

    /**
     * Jadwal yang menggunakan mapel ini
     */
    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
