@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2>Dashboard</h2>
    <p>Selamat datang, {{ Auth::user()->name }}! Berikut ringkasan data jadwal sekolah.</p>
</div>

<!-- Stat Cards -->
<div class="stats-grid">
    <div class="stat-card" id="stat-guru">
        <div class="stat-icon blue">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalGuru }}</h3>
            <p>Total Guru</p>
        </div>
    </div>

    <div class="stat-card" id="stat-kelas">
        <div class="stat-icon cyan">
            <i class="fas fa-school"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalKelas }}</h3>
            <p>Total Kelas</p>
        </div>
    </div>

    <div class="stat-card" id="stat-mapel">
        <div class="stat-icon purple">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalMapel }}</h3>
            <p>Mata Pelajaran</p>
        </div>
    </div>

    <div class="stat-card" id="stat-jadwal">
        <div class="stat-icon green">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalJadwal }}</h3>
            <p>Jadwal Terisi</p>
        </div>
    </div>

    <div class="stat-card" id="stat-kosong">
        <div class="stat-icon amber">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $jadwalKosong }}</h3>
            <p>Jadwal Kosong (Tanpa Guru)</p>
        </div>
    </div>

    <div class="stat-card" id="stat-bentrok">
        <div class="stat-icon red">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalBentrok }}</h3>
            <p>Jadwal Bentrok</p>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <!-- Guru Terbaru -->
    <div class="glass-card">
        <div class="flex-between mb-4">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a;">
                <i class="fas fa-user-tie" style="color: #2563eb; margin-right: 8px;"></i>
                Guru Terbaru
            </h3>
            <a href="{{ route('guru.index') }}" class="btn btn-glass btn-sm" id="link-guru-semua">Lihat Semua</a>
        </div>

        @if($guruTerbaru->count() > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guruTerbaru as $guru)
                            <tr>
                                <td><span class="badge badge-success">{{ $guru->nip }}</span></td>
                                <td style="font-weight: 600; color: #0f172a;">{{ $guru->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-plus"></i>
                <p>Belum ada data guru</p>
            </div>
        @endif
    </div>

    <!-- Jadwal Terbaru -->
    <div class="glass-card">
        <div class="flex-between mb-4">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a;">
                <i class="fas fa-clock" style="color: #0891b2; margin-right: 8px;"></i>
                Jadwal Terbaru
            </h3>
            <a href="{{ route('jadwal.index') }}" class="btn btn-glass btn-sm" id="link-jadwal-semua">Lihat Semua</a>
        </div>

        @if($jadwalTerbaru->count() > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalTerbaru as $j)
                            <tr>
                                <td><span class="badge badge-success">{{ $j->kelas->nama ?? '-' }}</span></td>
                                <td>{{ $j->mapel->nama ?? '-' }}</td>
                                <td>{{ $j->guru->nama ?? '-' }}</td>
                                <td>{{ $j->hari }}, Jam {{ $j->jam_ke }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-plus"></i>
                <p>Belum ada jadwal</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
