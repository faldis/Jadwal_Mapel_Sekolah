<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan ringkasan data
     */
    public function index()
    {
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();
        $totalJadwal = Jadwal::count();

        // Hitung slot kosong (slot tanpa guru)
        $jadwalKosong = Jadwal::whereNull('guru_id')->count();

        // Hitung jadwal bentrok
        // Guru yang mengajar di 2+ kelas di hari & jam yang sama
        $bentrok = Jadwal::whereNotNull('guru_id')
            ->selectRaw('guru_id, hari, jam_ke, COUNT(*) as total')
            ->groupBy('guru_id', 'hari', 'jam_ke')
            ->having('total', '>', 1)
            ->get();

        $totalBentrok = $bentrok->count();

        // Data terbaru
        $guruTerbaru = Guru::latest()->take(5)->get();
        $jadwalTerbaru = Jadwal::with(['kelas', 'mapel', 'guru'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalJadwal',
            'jadwalKosong',
            'totalBentrok',
            'guruTerbaru',
            'jadwalTerbaru'
        ));
    }
}
