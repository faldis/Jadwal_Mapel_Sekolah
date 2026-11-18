@extends('layouts.app')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="page-header">
    <h2>Kelola Jadwal Pelajaran</h2>
    <p>Pilih kelas untuk melihat dan mengatur jadwal pelajaran</p>
</div>

<!-- Pilih Kelas -->
<div class="glass-card mb-4">
    <form method="GET" action="{{ route('jadwal.index') }}" class="flex gap-3" style="align-items: flex-end;" id="form-pilih-kelas">
        <div class="form-group" style="margin-bottom: 0; flex: 1; max-width: 400px;">
            <label for="kelas_id">Pilih Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control" onchange="this.form.submit()">
                <option value="">— Pilih Kelas —</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ ($selectedKelas && $selectedKelas->id == $kelas->id) ? 'selected' : '' }}>
                        {{ $kelas->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

@if($selectedKelas)
    <!-- Jadwal Grid -->
    <div class="glass-card">
        <div class="flex-between mb-4">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a;">
                <i class="fas fa-table" style="color: #2563eb; margin-right: 8px;"></i>
                Jadwal Kelas {{ $selectedKelas->nama }}
            </h3>
            <span class="badge badge-success">
                <i class="fas fa-info-circle" style="margin-right: 4px;"></i>
                Klik slot untuk mengisi/edit jadwal
            </span>
        </div>

        <!-- Alert Bentrok (JS) -->
        <div class="alert alert-error" id="bentrok-alert" style="display: none;">
            <i class="fas fa-exclamation-triangle"></i>
            <span id="bentrok-message"></span>
        </div>

        <div class="table-wrapper">
            <table id="jadwal-table">
                <thead>
                    <tr>
                        <th style="width: 90px; text-align: center;">Jam</th>
                        @foreach($hariList as $hari)
                            <th style="text-align: center;">{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($jamList as $jam)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #2563eb; font-size: 1rem;">
                                Jam {{ $jam }}
                            </td>
                            @foreach($hariList as $hari)
                                @php $slot = $jadwalGrid[$hari][$jam] ?? null; @endphp
                                <td class="jadwal-slot {{ $slot ? 'filled' : 'empty' }}"
                                    onclick="openSlotModal('{{ $hari }}', {{ $jam }}, {{ $slot ? json_encode(['mapel_id' => $slot->mapel_id, 'guru_id' => $slot->guru_id, 'mapel_nama' => $slot->mapel->nama ?? '', 'guru_nama' => $slot->guru->nama ?? '']) : 'null' }})"
                                    id="slot-{{ $hari }}-{{ $jam }}"
                                    style="cursor: pointer; text-align: center; min-width: 150px; position: relative;">
                                    @if($slot)
                                        <div style="font-weight: 700; color: #0f172a; font-size: 0.95rem;">
                                            {{ $slot->mapel->nama ?? '-' }}
                                        </div>
                                        <div style="font-size: 0.85rem; color: #64748b; margin-top: 3px;">
                                            <i class="fas fa-user" style="font-size: 0.7rem;"></i>
                                            {{ $slot->guru->nama ?? 'Belum diisi' }}
                                        </div>
                                    @else
                                        <div style="color: #cbd5e1; font-size: 1rem;">
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Isi/Edit Slot -->
    <div class="modal-overlay" id="slotModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-calendar-plus" style="color: #2563eb; margin-right: 8px;"></i>
                    <span id="modal-title">Isi Jadwal</span>
                </h3>
                <button class="modal-close" onclick="closeModal('slotModal')"><i class="fas fa-times"></i></button>
            </div>

            <div style="margin-bottom: 16px;">
                <span class="badge badge-success" id="modal-slot-info" style="font-size: 0.9rem; padding: 6px 14px;"></span>
            </div>

            <form action="{{ route('jadwal.store') }}" method="POST" id="slotForm">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
                <input type="hidden" name="hari" id="slot-hari">
                <input type="hidden" name="jam_ke" id="slot-jam">

                <div class="form-group">
                    <label for="slot-mapel">Mata Pelajaran</label>
                    <select name="mapel_id" id="slot-mapel" class="form-control" required>
                        <option value="">— Pilih Mapel —</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="slot-guru">Guru Pengajar</label>
                    <select name="guru_id" id="slot-guru" class="form-control" onchange="checkBentrok()">
                        <option value="">— Pilih Guru —</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bentrok Warning in modal -->
                <div class="alert alert-warning" id="modal-bentrok-warning" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="modal-bentrok-text"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn-hapus-slot" onclick="hapusSlot()" style="margin-right: auto; display: none;">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-glass" onclick="closeModal('slotModal')">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan-slot">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>

            <!-- Hidden form for delete -->
            <form id="hapusForm" action="{{ route('jadwal.hapus') }}" method="POST" style="display:none;">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
                <input type="hidden" name="hari" id="hapus-hari">
                <input type="hidden" name="jam_ke" id="hapus-jam">
            </form>
        </div>
    </div>
@else
    @if($kelasList->count() == 0)
        <div class="glass-card">
            <div class="empty-state">
                <i class="fas fa-school"></i>
                <p>Belum ada data kelas. <a href="{{ route('kelas.index') }}" style="color: #2563eb; font-weight: 600;">Tambah kelas</a> terlebih dahulu.</p>
            </div>
        </div>
    @endif
@endif
@endsection

@section('styles')
<style>
    .jadwal-slot {
        transition: all 0.2s ease;
        border-radius: 4px;
    }
    .jadwal-slot:hover {
        background: #eff6ff !important;
    }
    .jadwal-slot.filled {
        background: #f8fafc;
    }
    .jadwal-slot.empty:hover .fa-plus-circle {
        color: #3b82f6 !important;
    }
</style>
@endsection

@section('scripts')
@if($selectedKelas)
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.getElementById('modal-bentrok-warning').style.display = 'none';
    }

    function openSlotModal(hari, jam, existing) {
        document.getElementById('slot-hari').value = hari;
        document.getElementById('slot-jam').value = jam;
        document.getElementById('hapus-hari').value = hari;
        document.getElementById('hapus-jam').value = jam;
        document.getElementById('modal-slot-info').textContent = hari + ', Jam ke-' + jam;
        document.getElementById('modal-bentrok-warning').style.display = 'none';

        if (existing) {
            document.getElementById('modal-title').textContent = 'Edit Jadwal';
            document.getElementById('slot-mapel').value = existing.mapel_id;
            document.getElementById('slot-guru').value = existing.guru_id || '';
            document.getElementById('btn-hapus-slot').style.display = 'inline-flex';
        } else {
            document.getElementById('modal-title').textContent = 'Isi Jadwal';
            document.getElementById('slot-mapel').value = '';
            document.getElementById('slot-guru').value = '';
            document.getElementById('btn-hapus-slot').style.display = 'none';
        }

        openModal('slotModal');
    }

    function hapusSlot() {
        if (confirm('Yakin hapus jadwal di slot ini?')) {
            document.getElementById('hapusForm').submit();
        }
    }

    function checkBentrok() {
        const guruId = document.getElementById('slot-guru').value;
        const hari = document.getElementById('slot-hari').value;
        const jamKe = document.getElementById('slot-jam').value;
        const warning = document.getElementById('modal-bentrok-warning');
        const warningText = document.getElementById('modal-bentrok-text');

        if (!guruId) {
            warning.style.display = 'none';
            return;
        }

        fetch('{{ route("jadwal.cekBentrok") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                guru_id: guruId,
                hari: hari,
                jam_ke: jamKe,
                kelas_id: {{ $selectedKelas->id }},
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.bentrok) {
                warning.style.display = 'flex';
                warningText.textContent = data.message;
            } else {
                warning.style.display = 'none';
            }
        })
        .catch(err => console.error(err));
    }

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
@endif
@endsection
