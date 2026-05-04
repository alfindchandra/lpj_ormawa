<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan {{ $period->nama_periode }}</title>
    <style>
    @page {
        size: A4 portrait;
        margin: 18mm 15mm 20mm 15mm;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.5;
        color: #1f2937;
        font-size: 10px;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .page-wrapper {
        width: 180mm;
        margin: 0 auto;
    }

    /* === HEADER === */
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 2.5px solid #1e3a8a;
        margin-bottom: 16px;
    }

    .header-left h1 {
        font-size: 18px;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: 1.5px;
    }

    .header-left .subtitle {
        font-size: 9px;
        color: #6b7280;
        margin-top: 2px;
        letter-spacing: 0.5px;
    }

    .header-right {
        text-align: right;
        font-size: 9px;
        color: #6b7280;
        line-height: 1.7;
    }

    .header-right strong {
        color: #374151;
    }

    /* === PERIOD INFO BAR === */
    .period-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        padding: 10px 14px;
        border-radius: 6px;
        margin-bottom: 16px;
        border: 1px solid #bfdbfe;
    }

    .period-bar .badge {
        background: #1e3a8a;
        color: #fff;
        font-size: 8px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .period-bar .badge.active {
        background: #16a34a;
    }

    .period-bar .info-text {
        font-size: 9.5px;
        color: #1e3a8a;
        font-weight: 500;
    }

    /* === STATISTICS === */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        color: #1e3a8a;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        padding-left: 10px;
        border-left: 3px solid #3b82f6;
    }

    .stats-row {
        display: flex;
        gap: 0;
        margin-bottom: 18px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .stat-item {
        flex: 1;
        text-align: center;
        padding: 14px 8px;
        background: #fff;
        position: relative;
    }

    .stat-item:not(:last-child) {
        border-right: 1px solid #e5e7eb;
    }

    .stat-item .stat-icon {
        font-size: 14px;
        margin-bottom: 4px;
    }

    .stat-item .stat-number {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 3px;
    }

    .stat-item .stat-caption {
        font-size: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9ca3af;
    }

    .stat-item.total .stat-number {
        color: #1e3a8a;
    }

    .stat-item.approved .stat-number {
        color: #16a34a;
    }

    .stat-item.rejected .stat-number {
        color: #dc2626;
    }

    .stat-item.budget .stat-number {
        color: #7c3aed;
        font-size: 15px;
    }

    .stat-item.budget .stat-caption-sub {
        font-size: 7px;
        color: #9ca3af;
        margin-top: 1px;
    }

    /* === TABLE === */
    .table-wrapper {
        margin-bottom: 18px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
    }

    .table thead th {
        background: #1e3a8a;
        color: #fff;
        padding: 9px 10px;
        text-align: left;
        font-weight: 600;
        font-size: 8.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 8px 10px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: top;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }

    .table tbody tr:hover {
        background-color: #eff6ff;
    }

    /* === STATUS BADGES === */
    .badge-status {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .badge-approved {
        background: #dcfce7;
        color: #166534;
    }

    .badge-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-pending {
        background: #fef9c3;
        color: #854d0e;
    }

    .badge-completed {
        background: #dcfce7;
        color: #166534;
    }

    .badge-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    /* === PROPOSAL DETAIL CARDS === */
    .proposal-card {
        margin-bottom: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        page-break-inside: avoid;
    }

    .proposal-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #f0f4ff 0%, #e8ecf9 100%);
        padding: 10px 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .proposal-card-header .code {
        font-size: 10px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .proposal-card-header .org {
        font-size: 8.5px;
        color: #6b7280;
        margin-top: 1px;
    }

    .proposal-card-header .budget-tag {
        font-size: 9px;
        font-weight: 700;
        color: #7c3aed;
        background: #f5f3ff;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #ede9fe;
        white-space: nowrap;
    }

    .proposal-card-body {
        padding: 0;
    }

    .proposal-card-body .detail-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
    }

    .proposal-card-body .detail-table td {
        padding: 7px 14px;
        border-bottom: 1px solid #f3f4f6;
    }

    .proposal-card-body .detail-table tr:last-child td {
        border-bottom: none;
    }

    .proposal-card-body .detail-table .label-cell {
        width: 30%;
        color: #6b7280;
        font-weight: 500;
        font-size: 8.5px;
    }

    .proposal-card-body .detail-table .value-cell {
        color: #1f2937;
        font-weight: 600;
    }

    .no-data-inline {
        padding: 10px 14px;
        background: #fffbeb;
        color: #92400e;
        font-size: 9px;
        border-left: 3px solid #f59e0b;
    }

    .empty-state {
        text-align: center;
        padding: 30px 20px;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px dashed #d1d5db;
    }

    .empty-state .empty-icon {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .empty-state .empty-text {
        font-size: 10px;
        color: #9ca3af;
    }

    /* === FOOTER === */
    .footer {
        margin-top: 30px;
        padding-top: 12px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 8px;
        color: #9ca3af;
    }

    .footer .sys-info {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .footer .sys-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #16a34a;
        display: inline-block;
    }

    /* === SIGNATURE === */
    .signature-section {
        margin-top: 40px;
        display: flex;
        justify-content: flex-end;
    }

    .signature-box {
        text-align: center;
        width: 140px;
    }

    .signature-box .sig-title {
        font-size: 9px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }

    .signature-box .sig-place {
        font-size: 8px;
        color: #6b7280;
    }

    .signature-box .sig-space {
        height: 55px;
    }

    .signature-box .sig-line {
        border-top: 1px solid #374151;
        padding-top: 4px;
        font-size: 9px;
        font-weight: 600;
        color: #374151;
    }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>LAPORAN KEGIATAN</h1>
                <div class="subtitle">Laporan Rekapitulasi Kegiatan Organisasi Kemahasiswaan</div>
            </div>
            <div class="header-right">
                <p><strong>Periode:</strong> {{ $period->nama_periode }}</p>
                <p><strong>Tahun Akademik:</strong> {{ $period->tahun_mulai }}/{{ $period->tahun_selesai }}</p>
                <p><strong>Cetak:</strong> {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Period Info Bar -->
        <div class="period-bar">
            @if($period->is_active)
            <span class="badge active">● Aktif</span>
            @else
            <span class="badge">Non-Aktif</span>
            @endif
            <span class="info-text">
                Periode <strong>{{ $period->nama_periode }}</strong> &mdash;
                Tahun {{ $period->tahun_mulai }} s/d {{ $period->tahun_selesai }}
            </span>
        </div>

        <!-- Statistics -->


        <!-- Proposal Table -->
        <div class="section-label">Daftar Kegiatan</div>

        @if($proposals->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <div class="empty-text">Tidak ada data kegiatan untuk periode ini.</div>
        </div>
        @else
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 11%;">Kode</th>
                        <th style="width: 26%;">Nama Kegiatan</th>
                        <th style="width: 17%;">Organisasi</th>
                        <th style="width: 15%; text-align: right;">Anggaran</th>
                        <th style="width: 11%; text-align: center;">Status</th>
                        <th style="width: 10%; text-align: center;">Tanggal</th>
                        <th style="width: 10%; text-align: center;">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposals as $proposal)
                    <tr>
                        <td style="font-weight:600; color:#1e3a8a; font-size:8.5px;">{{ $proposal->kode_proposal }}</td>
                        <td>{{ $proposal->nama_kegiatan }}</td>
                        <td style="color:#6b7280;">{{ $proposal->user->ormawa_name ?? 'N/A' }}</td>
                        <td style="text-align:right; font-weight:600; color:#374151; white-space:nowrap;">Rp
                            {{ number_format($proposal->anggaran, 0, ',', '.') }}</td>
                        <td style="text-align:center;">
                            @if($proposal->status === 'approved_admin')
                            <span class="badge-status badge-approved">Disetujui</span>
                            @elseif($proposal->status === 'rejected')
                            <span class="badge-status badge-rejected">Ditolak</span>
                            @else
                            <span class="badge-status badge-pending">Pending</span>
                            @endif
                        </td>
                        <td style="text-align:center; color:#6b7280; font-size:8.5px;">
                            @if($proposal->tanggal_mulai)
                            {{ $proposal->tanggal_mulai->format('d/m/y') }}
                            @else
                            -
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($proposal->activity)
                            @if($proposal->activity->status === 'completed')
                            <span class="badge-status badge-completed">Selesai</span>
                            @elseif($proposal->activity->status === 'cancelled')
                            <span class="badge-status badge-cancelled">Batal</span>
                            @else
                            <span class="badge-status badge-pending">{{ ucfirst($proposal->activity->status) }}</span>
                            @endif
                            @else
                            <span style="color:#d1d5db; font-size:8px;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Detail Section -->
        @if($proposals->isNotEmpty())
        <div class="section-label" style="margin-top:20px;">Detail Kegiatan</div>

        @foreach($proposals as $proposal)
        <div class="proposal-card">
            <div class="proposal-card-header">
                <div>
                    <div class="code">{{ $proposal->kode_proposal }} — {{ $proposal->nama_kegiatan }}</div>
                    <div class="org">{{ $proposal->user->ormawa_name ?? 'N/A' }}
                        @if($proposal->status === 'approved_admin')
                        &nbsp;<span class="badge-status badge-approved">Disetujui</span>
                        @elseif($proposal->status === 'rejected')
                        &nbsp;<span class="badge-status badge-rejected">Ditolak</span>
                        @else
                        &nbsp;<span class="badge-status badge-pending">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="budget-tag">Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</div>
            </div>
            <div class="proposal-card-body">
                @if($proposal->activity)
                <table class="detail-table">
                    <tr>
                        <td class="label-cell">Tanggal Pelaksanaan</td>
                        <td class="value-cell">
                            @if($proposal->tanggal_mulai)
                            {{ $proposal->tanggal_mulai->format('d/m/Y') }}
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label-cell">Deskripsi</td>
                        <td class="value-cell">{{ $proposal->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Jumlah Peserta</td>
                        <td class="value-cell">{{ $proposal->activity->jumlah_peserta ?? '-' }} orang</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Status Aktivitas</td>
                        <td class="value-cell">
                            @if($proposal->activity->status === 'completed')
                            <span class="badge-status badge-completed">Selesai</span>
                            @elseif($proposal->activity->status === 'cancelled')
                            <span class="badge-status badge-cancelled">Dibatalkan</span>
                            @else
                            <span class="badge-status badge-pending">{{ ucfirst($proposal->activity->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
                @else
                <div class="no-data-inline">
                    Belum ada data aktivitas untuk kegiatan ini.
                </div>
                @endif
            </div>
        </div>
        @endforeach
        @endif

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="sig-place">Mengetahui,</div>
                <div class="sig-title">Ketua Bidang Kemahasiswaan</div>
                <div class="sig-space"></div>
                <div class="sig-line">________________________</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="sys-info">
                <span class="sys-dot"></span>
                <span>Dokumen dihasilkan otomatis oleh sistem</span>
            </div>
            <span>{{ now()->format('d/m/Y H:i') }} &mdash; Halaman 1</span>
        </div>

    </div>
</body>

</html>