<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Tampilkan daftar kelas
     */
    public function index()
    {
        $kelasList = Kelas::latest()->get();
        return view('kelas.index', compact('kelasList'));
    }

    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Kelas::create($request->only('nama'));

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Update data kelas
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kela->update($request->only('nama'));

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * Hapus kelas
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
