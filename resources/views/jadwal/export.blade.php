@extends('layouts.app')

@section('title', 'Export Jadwal')

@section('content')
<div class="page-header">
    <h2>Export / Cetak Jadwal</h2>
    <p>Export jadwal per kelas atau per guru dalam format printable</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <!-- Per Kelas -->
    <div class="glass-card">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 20px;">
            <i class="fas fa-school" style="color: #0891b2; margin-right: 8px;"></i>
            Export Per Kelas
        </h3>

        @if($kelasList->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach($kelasList as $kelas)
                    <a href="{{ route('export.kelas', $kelas->id) }}" target="_blank" class="export-item" id="export-kelas-{{ $kelas->id }}">
                        <div class="flex gap-3" style="align-items: center;">
                            <div class="stat-icon blue" style="width: 42px; height: 42px; font-size: 0.95rem; border-radius: 10px;">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #0f172a; font-size: 0.95rem;">{{ $kelas->nama }}</div>
                                <div style="font-size: 0.8rem; color: #64748b;">{{ $kelas->jadwals()->count() }} jadwal terisi</div>
                            </div>
                        </div>
                        <i class="fas fa-print" style="color: #94a3b8;"></i>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-school"></i>
                <p>Belum ada data kelas</p>
            </div>
        @endif
    </div>

    <!-- Per Guru -->
    <div class="glass-card">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 20px;">
            <i class="fas fa-chalkboard-teacher" style="color: #2563eb; margin-right: 8px;"></i>
            Export Per Guru
        </h3>

        @if($gurus->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach($gurus as $guru)
                    <a href="{{ route('export.guru', $guru->id) }}" target="_blank" class="export-item" id="export-guru-{{ $guru->id }}">
                        <div class="flex gap-3" style="align-items: center;">
                            <div class="stat-icon cyan" style="width: 42px; height: 42px; font-size: 0.95rem; border-radius: 10px;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #0f172a; font-size: 0.95rem;">{{ $guru->nama }}</div>
                                <div style="font-size: 0.8rem; color: #64748b;">NIP: {{ $guru->nip }}</div>
                            </div>
                        </div>
                        <i class="fas fa-print" style="color: #94a3b8;"></i>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-chalkboard-teacher"></i>
                <p>Belum ada data guru</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .export-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .export-item:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        transform: translateX(4px);
    }
    .export-item:hover .fa-print {
        color: #2563eb !important;
    }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
