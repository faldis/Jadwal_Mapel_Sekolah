<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Tampilkan daftar mata pelajaran
     */
    public function index()
    {
        $mapels = Mapel::latest()->get();
        return view('mapel.index', compact('mapels'));
    }

    /**
     * Simpan mapel baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Mapel::create($request->only('nama'));

        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Update data mapel
     */
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $mapel->update($request->only('nama'));

        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    /**
     * Hapus mapel
     */
    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
