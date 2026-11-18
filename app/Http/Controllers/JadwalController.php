<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Tampilkan halaman kelola jadwal
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $selectedKelas = null;
        $jadwalGrid = [];

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamList = range(1, 8);

        if ($request->has('kelas_id') && $request->kelas_id) {
            $selectedKelas = Kelas::findOrFail($request->kelas_id);

            // Ambil semua jadwal untuk kelas ini
            $jadwals = Jadwal::where('kelas_id', $selectedKelas->id)
                ->with(['mapel', 'guru'])
                ->get()
                ->keyBy(function ($item) {
                    return $item->hari . '_' . $item->jam_ke;
                });

            // Buat grid hari x jam
            foreach ($hariList as $hari) {
                foreach ($jamList as $jam) {
                    $key = $hari . '_' . $jam;
                    $jadwalGrid[$hari][$jam] = $jadwals->get($key);
                }
            }
        }

        return view('jadwal.index', compact(
            'kelasList',
            'gurus',
            'mapels',
            'selectedKelas',
            'jadwalGrid',
            'hariList',
            'jamList'
        ));
    }

    /**
     * Simpan/update jadwal (satu slot)
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_ke' => 'required|integer|min:1|max:8',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'nullable|exists:gurus,id',
        ]);

        // Cek bentrok jika guru dipilih
        if ($request->guru_id) {
            $bentrok = Jadwal::cekBentrok(
                $request->guru_id,
                $request->hari,
                $request->jam_ke,
                $request->kelas_id
            );

            if ($bentrok) {
                $namaGuru = Guru::find($request->guru_id)->nama;
                $namaKelas = $bentrok->kelas->nama;
                return back()->with('error', "Guru {$namaGuru} sudah mengajar di Kelas {$namaKelas} pada {$request->hari} jam ke-{$request->jam_ke}!");
            }
        }

        // Update or create jadwal
        Jadwal::updateOrCreate(
            [
                'kelas_id' => $request->kelas_id,
                'hari' => $request->hari,
                'jam_ke' => $request->jam_ke,
            ],
            [
                'mapel_id' => $request->mapel_id,
                'guru_id' => $request->guru_id,
            ]
        );

        return redirect()->route('jadwal.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Jadwal berhasil disimpan!');
    }

    /**
     * Hapus jadwal (satu slot)
     */
    public function hapus(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required',
            'jam_ke' => 'required|integer',
        ]);

        Jadwal::where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('jam_ke', $request->jam_ke)
            ->delete();

        return redirect()->route('jadwal.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    /**
     * API: Cek bentrok real-time (AJAX)
     */
    public function cekBentrok(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'hari' => 'required',
            'jam_ke' => 'required|integer',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $bentrok = Jadwal::cekBentrok(
            $request->guru_id,
            $request->hari,
            $request->jam_ke,
            $request->kelas_id
        );

        if ($bentrok) {
            $guru = Guru::find($request->guru_id);
            return response()->json([
                'bentrok' => true,
                'message' => "Guru {$guru->nama} sudah mengajar di Kelas {$bentrok->kelas->nama} pada {$request->hari} jam ke-{$request->jam_ke}",
            ]);
        }

        return response()->json(['bentrok' => false]);
    }

    /**
     * Halaman export jadwal
     */
    public function export()
    {
        $kelasList = Kelas::all();
        $gurus = Guru::all();
        return view('jadwal.export', compact('kelasList', 'gurus'));
    }

    /**
     * Export jadwal per kelas (printable view)
     */
    public function exportPerKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamList = range(1, 8);

        $jadwals = Jadwal::where('kelas_id', $id)
            ->with(['mapel', 'guru'])
            ->get()
            ->keyBy(function ($item) {
                return $item->hari . '_' . $item->jam_ke;
            });

        $jadwalGrid = [];
        foreach ($hariList as $hari) {
            foreach ($jamList as $jam) {
                $key = $hari . '_' . $jam;
                $jadwalGrid[$hari][$jam] = $jadwals->get($key);
            }
        }

        return view('jadwal.export-kelas', compact('kelas', 'jadwalGrid', 'hariList', 'jamList'));
    }

    /**
     * Export jadwal per guru (printable view)
     */
    public function exportPerGuru($id)
    {
        $guru = Guru::findOrFail($id);
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamList = range(1, 8);

        $jadwals = Jadwal::where('guru_id', $id)
            ->with(['kelas', 'mapel'])
            ->get()
            ->keyBy(function ($item) {
                return $item->hari . '_' . $item->jam_ke;
            });

        $jadwalGrid = [];
        foreach ($hariList as $hari) {
            foreach ($jamList as $jam) {
                $key = $hari . '_' . $jam;
                $jadwalGrid[$hari][$jam] = $jadwals->get($key);
            }
        }

        return view('jadwal.export-guru', compact('guru', 'jadwalGrid', 'hariList', 'jamList'));
    }
}
