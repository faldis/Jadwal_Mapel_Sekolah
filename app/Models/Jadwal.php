<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $fillable = ['kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_ke'];

    /**
     * Kelas untuk jadwal ini
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Mata pelajaran untuk jadwal ini
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Guru yang mengajar jadwal ini
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Cek apakah guru bentrok di hari & jam yang sama di kelas lain
     *
     * @param int $guruId
     * @param string $hari
     * @param int $jamKe
     * @param int|null $excludeKelasId Kelas yang dikecualikan (kelas saat ini)
     * @return Jadwal|null Jadwal yang bentrok, null jika tidak bentrok
     */
    public static function cekBentrok(int $guruId, string $hari, int $jamKe, ?int $excludeKelasId = null): ?self
    {
        $query = self::where('guru_id', $guruId)
            ->where('hari', $hari)
            ->where('jam_ke', $jamKe);

        if ($excludeKelasId) {
            $query->where('kelas_id', '!=', $excludeKelasId);
        }

        return $query->with('kelas')->first();
    }
}
