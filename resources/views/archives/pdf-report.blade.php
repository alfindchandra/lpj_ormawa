<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan {{ $period->nama_periode }}</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 3px solid #1e3a8a;
    }

    .header h1 {
        font-size: 24px;
        color: #1e3a8a;
        margin-bottom: 10px;
    }

    .header p {
        font-size: 12px;
        color: #666;
    }

    .period-info {
        background-color: #f3f4f6;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #3b82f6;
    }

    .period-info p {
        margin: 5px 0;
        font-size: 13px;
    }

    .statistics {
        margin-bottom: 30px;
    }

    .statistics-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-card {
        background-color: #f9fafb;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 5px;
        text-align: center;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .stat-value {
        font-size: 20px;
        font-weight: bold;
        color: #1e3a8a;
    }

    .section-title {
        font-size: 16px;
        font-weight: bold;
        color: #1e3a8a;
        margin-top: 30px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #dbeafe;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 11px;
    }

    .table thead {
        background-color: #1e3a8a;
        color: white;
    }

    .table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
    }

    .table td {
        padding: 10px 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }

    .status-approved {
        background-color: #d1fae5;
        color: #065f46;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
    }

    .status-rejected {
        background-color: #fee2e2;
        color: #7f1d1d;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
    }

    .proposal-group {
        margin-bottom: 20px;
        page-break-inside: avoid;
    }

    .proposal-header {
        background-color: #e0e7ff;
        padding: 12px;
        margin-bottom: 10px;
        border-left: 4px solid #4f46e5;
        border-radius: 3px;
    }

    .proposal-code {
        font-weight: bold;
        color: #1e3a8a;
        font-size: 12px;
    }

    .proposal-name {
        font-size: 11px;
        color: #4b5563;
        margin-top: 3px;
    }

    .proposal-details {
        font-size: 10px;
        color: #6b7280;
        margin-top: 5px;
    }

    .empty-message {
        text-align: center;
        padding: 20px;
        background-color: #f3f4f6;
        color: #6b7280;
        border-radius: 5px;
        font-size: 12px;
    }

    .footer {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
        font-size: 10px;
        color: #6b7280;
        text-align: right;
    }

    .signature-section {
        margin-top: 50px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 100px;
    }

    .signature-box {
        text-align: center;
        font-size: 11px;
    }

    .signature-line {
        margin-top: 50px;
        border-top: 1px solid #000;
        padding-top: 5px;
    }

    .no-data {
        background-color: #fef3c7;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #f59e0b;
        font-size: 12px;
        color: #92400e;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN KEGIATAN</h1>
        <p>Periode: {{ $period->nama_periode }}</p>
        <p>Tahun Akademik: {{ $period->tahun_mulai }} - {{ $period->tahun_selesai }}</p>
    </div>

    <!-- Period Information -->
    <div class="period-info">
        <p><strong>Periode:</strong> {{ $period->nama_periode }}</p>
        <p><strong>Tahun Mulai:</strong> {{ $period->tahun_mulai }}</p>
        <p><strong>Tahun Selesai:</strong> {{ $period->tahun_selesai }}</p>
        @if($period->is_active)
        <p><strong>Status:</strong> <span style="color: #16a34a; font-weight: bold;">Periode Aktif</span></p>
        @else
        <p><strong>Status:</strong> <span style="color: #6b7280;">Periode Selesai</span></p>
        @endif
        <p><strong>Tanggal Laporan:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Statistics Section -->
    <div class="statistics">
        <h2 class="section-title">Ringkasan Statistik</h2>
        <div class="statistics-grid">
            <div class="stat-card">
                <div class="stat-label">Total Proposal</div>
                <div class="stat-value">{{ $statistics['total_proposals'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Disetujui</div>
                <div class="stat-value" style="color: #16a34a;">{{ $statistics['approved'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Ditolak</div>
                <div class="stat-value" style="color: #dc2626;">{{ $statistics['rejected'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Anggaran</div>
                <div class="stat-value" style="font-size: 16px;">Rp
                    {{ number_format($statistics['total_budget'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Proposals Section -->
    <div>
        <h2 class="section-title">Daftar Kegiatan</h2>

        @if($proposals->isEmpty())
        <div class="empty-message">
            Tidak ada data kegiatan untuk periode ini.
        </div>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 12%;">Kode</th>
                    <th style="width: 28%;">Nama Kegiatan</th>
                    <th style="width: 18%;">Organisasi</th>
                    <th style="width: 12%;">Anggaran</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 12%;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proposals as $proposal)
                <tr>
                    <td>{{ $proposal->kode_proposal }}</td>
                    <td>{{ $proposal->nama_kegiatan }}</td>
                    <td>{{ $proposal->user->ormawa_name ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</td>
                    <td>
                        @if($proposal->status === 'approved_admin')
                        <span class="status-approved">Disetujui</span>
                        @elseif($proposal->status === 'rejected')
                        <span class="status-rejected">Ditolak</span>
                        @else
                        <span class="status-pending">Pending</span>
                        @endif
                    </td>
                    <td>{{ $proposal->tanggal_mulai->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Detailed Activities -->
    @if($proposals->isNotEmpty())
    <div>
        <h2 class="section-title">Detail Kegiatan dan Aktivitas</h2>

        @foreach($proposals as $proposal)
        <div class="proposal-group">
            <div class="proposal-header">
                <div class="proposal-code">{{ $proposal->kode_proposal }} - {{ $proposal->nama_kegiatan }}</div>
                <div class="proposal-details">
                    Organisasi: {{ $proposal->user->ormawa_name ?? 'N/A' }} |
                    Anggaran: Rp {{ number_format($proposal->anggaran, 0, ',', '.') }} |
                    Status:
                    @if($proposal->status === 'approved_admin')
                    <span class="status-approved">Disetujui</span>
                    @elseif($proposal->status === 'rejected')
                    <span class="status-rejected">Ditolak</span>
                    @else
                    <span class="status-pending">Pending</span>
                    @endif
                </div>
            </div>

            @if($proposal->activity)
            <table class="table" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="width: 20%;">Tanggal Proposal</th>
                        <th style="width: 40%;">Deskripsi</th>
                        <th style="width: 15%;">Peserta</th>
                        <th style="width: 15%;">Status Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if($proposal->tanggal_mulai)
                            {{ $proposal->tanggal_mulai->format('d/m/Y') }}
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ Str::limit($proposal->deskripsi, 50) }}</td>
                        <td>{{ $proposal->activity->jumlah_peserta ?? '-' }}</td>
                        <td>
                            @if($proposal->activity->status === 'completed')
                            <span class="status-approved">Selesai</span>
                            @elseif($proposal->activity->status === 'cancelled')
                            <span class="status-rejected">Dibatalkan</span>
                            @else
                            <span class="status-pending">{{ ucfirst($proposal->activity->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @else
            <div class="no-data">
                Belum ada aktivitas untuk kegiatan ini.
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>

</html>