@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="page-header">
    <div class="flex-between">
        <div>
            <h2>Data Kelas</h2>
            <p>Kelola data kelas sekolah</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('addModal')" id="btn-tambah-kelas">
            <i class="fas fa-plus"></i> Tambah Kelas
        </button>
    </div>
</div>

<div class="glass-card">
    @if($kelasList->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Jumlah Jadwal</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelasList as $i => $kelas)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight: 600; color: #0f172a;">
                                <i class="fas fa-door-open" style="color: #0891b2; margin-right: 8px;"></i>
                                {{ $kelas->nama }}
                            </td>
                            <td>{{ $kelas->jadwals()->count() }} jadwal</td>
                            <td style="text-align: right;">
                                <div class="flex gap-2" style="justify-content: flex-end;">
                                    <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $kelas->id }}, '{{ addslashes($kelas->nama) }}')" id="btn-edit-kelas-{{ $kelas->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('kelas.destroy', $kelas) }}" method="POST" onsubmit="return confirm('Yakin hapus kelas {{ addslashes($kelas->nama) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" id="btn-hapus-kelas-{{ $kelas->id }}">
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
            <i class="fas fa-school"></i>
            <p>Belum ada data kelas. Klik "Tambah Kelas" untuk memulai.</p>
        </div>
    @endif
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus-circle" style="color: #0891b2; margin-right: 8px;"></i> Tambah Kelas</h3>
            <button class="modal-close" onclick="closeModal('addModal')"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="add-nama">Nama Kelas</label>
                <input type="text" name="nama" id="add-nama" class="form-control" placeholder="Contoh: VII-A" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-glass" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-simpan-kelas">
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
            <h3><i class="fas fa-edit" style="color: #d97706; margin-right: 8px;"></i> Edit Kelas</h3>
            <button class="modal-close" onclick="closeModal('editModal')"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-nama">Nama Kelas</label>
                <input type="text" name="nama" id="edit-nama" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-glass" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-update-kelas">
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
        document.getElementById('editForm').action = '/kelas/' + id;
        openModal('editModal');
    }
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
@endsection
