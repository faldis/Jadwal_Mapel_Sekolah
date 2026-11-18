@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="page-header">
    <div class="flex-between">
        <div>
            <h2>Data Guru</h2>
            <p>Kelola data guru pengajar</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('addModal')" id="btn-tambah-guru">
            <i class="fas fa-plus"></i> Tambah Guru
        </button>
    </div>
</div>

<div class="glass-card">
    @if($gurus->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>Jumlah Jadwal</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $i => $guru)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><span class="badge badge-success">{{ $guru->nip }}</span></td>
                            <td style="font-weight: 600; color: #0f172a;">{{ $guru->nama }}</td>
                            <td>{{ $guru->jadwals()->count() }} jadwal</td>
                            <td style="text-align: right;">
                                <div class="flex gap-2" style="justify-content: flex-end;">
                                    <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $guru->id }}, '{{ $guru->nip }}', '{{ addslashes($guru->nama) }}')" id="btn-edit-guru-{{ $guru->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('guru.destroy', $guru) }}" method="POST" onsubmit="return confirm('Yakin hapus guru {{ addslashes($guru->nama) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" id="btn-hapus-guru-{{ $guru->id }}">
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
            <i class="fas fa-chalkboard-teacher"></i>
            <p>Belum ada data guru. Klik "Tambah Guru" untuk memulai.</p>
        </div>
    @endif
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user-plus" style="color: #2563eb; margin-right: 8px;"></i> Tambah Guru</h3>
            <button class="modal-close" onclick="closeModal('addModal')"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('guru.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="add-nip">NIP</label>
                <input type="text" name="nip" id="add-nip" class="form-control" placeholder="Masukkan NIP" required>
            </div>
            <div class="form-group">
                <label for="add-nama">Nama Guru</label>
                <input type="text" name="nama" id="add-nama" class="form-control" placeholder="Masukkan nama guru" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-glass" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-simpan-guru">
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
            <h3><i class="fas fa-edit" style="color: #d97706; margin-right: 8px;"></i> Edit Guru</h3>
            <button class="modal-close" onclick="closeModal('editModal')"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-nip">NIP</label>
                <input type="text" name="nip" id="edit-nip" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit-nama">Nama Guru</label>
                <input type="text" name="nama" id="edit-nama" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-glass" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-update-guru">
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
    function openEditModal(id, nip, nama) {
        document.getElementById('edit-nip').value = nip;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('editForm').action = '/guru/' + id;
        openModal('editModal');
    }
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
@endsection
