<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Tampilkan daftar guru
     */
    public function index()
    {
        $gurus = Guru::latest()->get();
        return view('guru.index', compact('gurus'));
    }

    /**
     * Simpan guru baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:gurus,nip',
            'nama' => 'required|string|max:255',
        ]);

        Guru::create($request->only('nip', 'nama'));

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    /**
     * Update data guru
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
        ]);

        $guru->update($request->only('nip', 'nama'));

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Hapus guru
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus!');
    }
}
