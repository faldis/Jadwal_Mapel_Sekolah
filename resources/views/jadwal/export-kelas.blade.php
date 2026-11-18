<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas {{ $kelas->nama }} — Cetak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #1e293b;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
            border-bottom: 3px solid #0ea5e9;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
        }
        .header h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0ea5e9;
            margin-top: 4px;
        }
        .header p {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: center;
            font-size: 0.85rem;
        }
        th {
            background: #0ea5e9;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        td.jam-cell {
            background: #f0f9ff;
            font-weight: 700;
            color: #0284c7;
            width: 80px;
        }
        td .mapel {
            font-weight: 600;
            color: #0f172a;
        }
        td .guru {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 2px;
        }
        td.empty-cell {
            color: #cbd5e1;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 24px;
            background: #0ea5e9;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
        }
        .print-btn:hover { background: #0284c7; }
        .footer {
            margin-top: 32px;
            text-align: right;
            font-size: 0.85rem;
            color: #64748b;
        }

        @media print {
            .print-btn { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()" id="btn-print">
        🖨️ Cetak
    </button>

    <div class="header">
        <h1>JADWAL PELAJARAN</h1>
        <h2>Kelas {{ $kelas->nama }}</h2>
        <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Jam</th>
                @foreach($hariList as $hari)
                    <th>{{ $hari }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($jamList as $jam)
                <tr>
                    <td class="jam-cell">Jam {{ $jam }}</td>
                    @foreach($hariList as $hari)
                        @php $slot = $jadwalGrid[$hari][$jam] ?? null; @endphp
                        <td class="{{ $slot ? '' : 'empty-cell' }}">
                            @if($slot)
                                <div class="mapel">{{ $slot->mapel->nama ?? '-' }}</div>
                                <div class="guru">{{ $slot->guru->nama ?? '-' }}</div>
                            @else
                                —
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
    </div>
</body>
</html>
