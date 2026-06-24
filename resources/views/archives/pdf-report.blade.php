<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan {{ $period->nama_periode }}</title>
    <style>
    @page {
        size: A4 portrait;
        margin: 20mm 20mm 20mm 25mm;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        line-height: 1.6;
        color: #000;
        font-size: 11px;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .page-wrapper {
        width: 165mm;
        margin: 0 auto;
    }

    /* === HEADER === */
    .header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 14px;
    }

    .header h1 {
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .header .subtitle {
        font-size: 10px;
        margin-top: 3px;
    }

    /* === PERIOD INFO === */
    .period-info {
        margin-bottom: 14px;
        font-size: 10px;
    }

    .period-info table {
        border-collapse: collapse;
    }

    .period-info td {
        padding: 1px 4px 1px 0;
        vertical-align: top;
    }

    .period-info td:first-child {
        width: 120px;
    }

    /* === SECTION LABEL === */
    .section-label {
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 8px;
        margin-top: 14px;
    }

    /* === TABLE === */
    .table-wrapper {
        margin-bottom: 16px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9.5px;
    }

    .table thead th {
        background: #d0d0d0;
        color: #000;
        padding: 6px 7px;
        text-align: left;
        font-weight: bold;
        border: 1px solid #555;
        font-size: 9.5px;
    }

    .table tbody td {
        padding: 5px 7px;
        border: 1px solid #aaa;
        vertical-align: top;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }

    /* === STATUS TEXT === */
    .status-disetujui { color: #166534; font-weight: bold; }
    .status-ditolak   { color: #991b1b; font-weight: bold; }
    .status-pending   { color: #854d0e; font-weight: bold; }
    .status-selesai   { color: #166534; }
    .status-batal     { color: #991b1b; }

    /* === EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 20px;
        border: 1px solid #aaa;
        font-size: 10px;
        color: #555;
    }

    /* === SIGNATURE SECTION === */
    .signature-section {
        margin-top: 50px;
        width: 100%;
    }

    .signature-table {
        width: 100%;
        table-layout: fixed;
    }

    .signature-table td {
        text-align: center;
        vertical-align: top;
        padding: 0 10px;
        font-size: 10px;
        width: 33.33%;
    }

    .sig-role {
        font-weight: bold;
        margin-bottom: 4px;
        height: 32px;
        line-height: 1.4;
    }

    .sig-space {
        height: 70px;
        display: block;
    }

    .sig-name {
        padding-top: 4px;
        font-weight: bold;
        font-size: 10px;
    }

    .sig-nip {
        font-size: 9px;
        margin-top: 2px;
        color: #333;
    }

    /* === FOOTER === */
    .footer {
        margin-top: 24px;
        padding-top: 8px;
        border-top: 1px solid #aaa;
        display: flex;
        justify-content: space-between;
        font-size: 8.5px;
        color: #555;
    }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <!-- Header -->
        <div class="header">
            <h1>Laporan Kegiatan</h1>
            <div class="subtitle">Rekapitulasi Kegiatan Organisasi Kemahasiswaan</div>
        </div>

        <!-- Period Info -->
        <div class="period-info">
            <table>
                <tr>
                    <td>Periode</td>
                    <td>: {{ $period->nama_periode }}</td>
                </tr>
                <tr>
                    <td>Tahun Akademik</td>
                    <td>: {{ $period->tahun_mulai }}/{{ $period->tahun_selesai }}</td>
                </tr>
                <tr>
                    <td>Status Periode</td>
                    <td>: {{ $period->is_active ? 'Aktif' : 'Non-Aktif' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Cetak</td>
                    <td>: {{ now()->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <!-- Proposal Table -->
        <div class="section-label">Daftar Kegiatan</div>

        @if($proposals->isEmpty())
        <div class="empty-state">
            Tidak ada data kegiatan untuk periode ini.
        </div>
        @else
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Kode</th>
                        <th style="width: 26%;">Nama Kegiatan</th>
                        <th style="width: 18%;">Organisasi</th>
                        <th style="width: 16%; text-align: right;">Anggaran (Rp)</th>
                        <th style="width: 10%; text-align: center;">Status</th>
                        <th style="width: 10%; text-align: center;">Tanggal</th>
                        <th style="width: 10%; text-align: center;">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposals as $proposal)
                    <tr>
                        <td style="font-size:8.5px;">{{ $proposal->kode_proposal }}</td>
                        <td>{{ $proposal->nama_kegiatan }}</td>
                        <td>{{ $proposal->user->ormawa_name ?? 'N/A' }}</td>
                        <td style="text-align:right;">{{ number_format($proposal->anggaran, 0, ',', '.') }}</td>
                        <td style="text-align:center;">
                            @if($proposal->status === 'approved_admin')
                            <span class="status-disetujui">Disetujui</span>
                            @elseif($proposal->status === 'rejected')
                            <span class="status-ditolak">Ditolak</span>
                            @else
                            <span class="status-pending">Pending</span>
                            @endif
                        </td>
                        <td style="text-align:center; font-size:8.5px;">
                            @if($proposal->tanggal_mulai)
                            {{ $proposal->tanggal_mulai->format('d/m/y') }}
                            @else
                            -
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($proposal->activity)
                            @if($proposal->activity->status === 'completed')
                            <span class="status-selesai">Selesai</span>
                            @elseif($proposal->activity->status === 'cancelled')
                            <span class="status-batal">Batal</span>
                            @else
                            <span class="status-pending">{{ ucfirst($proposal->activity->status) }}</span>
                            @endif
                            @else
                            <span style="color:#999;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Signature -->
        <!-- Bagian Tanda Tangan PDF -->
<table style="width: 100%; margin-top: 50px; border-collapse: collapse;">
    <tr>
        <td style="width: 50%;"></td> <!-- Sisi kiri dikosongkan jika ingin di kanan, atau sesuaikan layout -->
        <td style="width: 50%; text-align: center;">
            <p>Mengetahui,</p>
            <p style="margin-bottom: 80px;">Wakil Rektor Bidang Akademik dan Kemahasiswaan</p>
            
            <!-- Nama Pejabat -->
            <p style="font-weight: bold; text-decoration: underline;">______________________</p>
           
        </td>
    </tr>
</table>

     

    </div>
</body>

</html>
