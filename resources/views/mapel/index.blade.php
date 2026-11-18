@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="page-header">
    <div class="flex-between">
        <div>
            <h2>Mata Pelajaran</h2>
            <p>Kelola data mata pelajaran</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('addModal')" id="btn-tambah-mapel">
            <i class="fas fa-plus"></i> Tambah Mapel
        </button>
    </div>
</div>

<div class="glass-card">
    @if($mapels->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Jumlah Jadwal</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mapels as $i => $mapel)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight: 600; color: #0f172a;">
                                <i class="fas fa-book-open" style="color: #7c3aed; margin-right: 8px;"></i>
                                {{ $mapel->nama }}
                            </td>
                            <td>{{ $mapel->jadwals()->count() }} jadwal</td>
                            <td style="text-align: right;">
                                <div class="flex gap-2" style="justify-content: flex-end;">
                                    <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $mapel->id }}, '{{ addslashes($mapel->nama) }}')" id="btn-edit-mapel-{{ $mapel->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('mapel.destroy', $mapel) }}" method="POST" onsubmit="return confirm('Yakin hapus mapel {{ addslashes($mapel->nama) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" id="btn-hapus-mapel-{{ $mapel->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-book"></i>
            <p>Belum ada data mata pelajaran. Klik "Tambah Mapel" untuk memulai.</p>
        </div>
    @endif
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-book-medical" style="color: #7c3aed; margin-right: 8px;"></i> Tambah Mata Pelajaran</h3>
            <button class="modal-close" onclick="closeModal('addModal')"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('mapel.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="add-nama">Nama Mata Pelajaran</label>
                <input type="text" name="nama" id="add-nama" class="form-control" placeholder="Contoh: Matematika" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-glass" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-simpan-mapel">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit" style="color: #d97706; margin-right: 8px;"></i> Edit Mata Pelajaran</h3>
            <button class="modal-close" onclick="closeModal('editModal')"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-nama">Nama Mata Pelajaran</label>
                <input type="text" name="nama" id="edit-nama" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-glass" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-update-mapel">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
    function openEditModal(id, nama) {
        document.getElementById('edit-nama').value = nama;
        document.getElementById('editForm').action = '/mapel/' + id;
        openModal('editModal');
    }
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
@endsection
