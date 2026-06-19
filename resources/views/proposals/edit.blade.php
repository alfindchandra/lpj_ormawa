<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Proposal: {{ $proposal->kode_proposal }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <p class="font-semibold">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('proposals.update', $proposal) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ── Periode ─────────────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="period_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Periode Kepengurusan <span class="text-red-500">*</span>
                            </label>
                            @if($periods->isEmpty())
                                <div class="p-4 bg-yellow-50 border border-yellow-300 rounded-md text-yellow-800 text-sm">
                                    Belum ada periode. Hubungi admin.
                                </div>
                            @else
                            <select name="period_id" id="period_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periods as $period)
                                <option value="{{ $period->id }}"
                                    {{ old('period_id', $proposal->period_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->nama_periode }} ({{ $period->tahun_mulai }}/{{ $period->tahun_selesai }})
                                    @if($period->is_active) — Aktif @endif
                                </option>
                                @endforeach
                            </select>
                            @endif
                            @error('period_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ── Nama Kegiatan ──────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('nama_kegiatan', $proposal->nama_kegiatan) }}" required>
                            @error('nama_kegiatan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ── Deskripsi ───────────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>{{ old('deskripsi', $proposal->deskripsi) }}</textarea>
                            @error('deskripsi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ── Tanggal ─────────────────────────────────────────────────── --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('tanggal_mulai', $proposal->tanggal_mulai->format('Y-m-d')) }}" required>
                                @error('tanggal_mulai')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('tanggal_selesai', $proposal->tanggal_selesai->format('Y-m-d')) }}" required>
                                @error('tanggal_selesai')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- ── Tipe Lokasi ─────────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="tipe_lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Lokasi <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe_lokasi" id="tipe_lokasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Tipe Lokasi --</option>
                                <option value="internal"  {{ old('tipe_lokasi', $proposal->tipe_lokasi) == 'internal'  ? 'selected' : '' }}>Internal Kampus</option>
                                <option value="eksternal" {{ old('tipe_lokasi', $proposal->tipe_lokasi) == 'eksternal' ? 'selected' : '' }}>Eksternal Kampus</option>
                            </select>
                            @error('tipe_lokasi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ── Tempat ──────────────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="tempat" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Pelaksanaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat" id="tempat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('tempat', $proposal->tempat) }}" required>
                            @error('tempat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ══════════════════════════════════════════════════════════════
                             SECTION INTERNAL
                        ══════════════════════════════════════════════════════════════ --}}
                        <div id="section-internal" class="hidden">
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-700">
                                        Internal: Anggaran Perlengkapan &amp; Kegiatan
                                    </label>
                                    <button type="button" onclick="addRow('internal')"
                                        class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">+ Tambah Item</button>
                                </div>
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                            <tr>
                                                <th class="px-4 py-3 text-left">Nama Barang / Item</th>
                                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                                <th class="px-4 py-3 text-right w-36">Harga/Satuan</th>
                                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                                                <th class="px-4 py-3 w-16"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-internal">
                                            @php
                                                // Pakai old() jika ada (setelah error validasi), kalau tidak pakai dari DB
                                                $internals = old('internal_items');
                                                if ($internals === null) {
                                                    $internals = $proposal->internalItems->map(fn($item) => [
                                                        'nama'   => $item->nama,
                                                        'jumlah' => $item->jumlah,
                                                        'harga'  => $item->harga,
                                                    ])->toArray();
                                                }
                                                if (empty($internals)) {
                                                    $internals = [['nama' => '', 'jumlah' => 1, 'harga' => '']];
                                                }
                                            @endphp
                                            @foreach($internals as $i => $item)
                                            <tr class="border-t item-row" data-section="internal">
                                                <td class="px-4 py-2">
                                                    <input type="text" name="internal_items[{{ $i }}][nama]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm"
                                                        placeholder="Contoh: Kebersihan, Konsumsi, Banner"
                                                        value="{{ $item['nama'] ?? '' }}">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="internal_items[{{ $i }}][jumlah]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm jumlah-input"
                                                        min="1" value="{{ $item['jumlah'] ?? 1 }}"
                                                        oninput="recalcRow(this)">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="internal_items[{{ $i }}][harga]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm harga-input"
                                                        step="1" min="0" placeholder="0"
                                                        value="{{ $item['harga'] ?? '' }}"
                                                        oninput="recalcRow(this)">
                                                </td>
                                                <td class="px-4 py-2 text-right text-gray-700 font-medium subtotal-display">Rp 0</td>
                                                <td class="px-4 py-2 text-center">
                                                    <button type="button" onclick="removeRow(this)"
                                                        class="text-red-500 hover:text-red-700 text-lg leading-none">&times;</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════════════════
                             SECTION EXTERNAL JASA
                        ══════════════════════════════════════════════════════════════ --}}
                        <div id="section-external" class="hidden">
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-700">
                                        Eksternal: Jasa / Layanan (MC, Catering, dll)
                                    </label>
                                    <button type="button" onclick="addRow('external')"
                                        class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">+ Tambah Jasa</button>
                                </div>
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                            <tr>
                                                <th class="px-4 py-3 text-left">Jasa / Layanan</th>
                                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                                <th class="px-4 py-3 text-right w-36">Harga/Satuan</th>
                                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                                                <th class="px-4 py-3 w-16"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-external">
                                            @php
                                                $externals = old('external_items');
                                                if ($externals === null) {
                                                    $externals = $proposal->externalItems->map(fn($item) => [
                                                        'jasa'   => $item->jasa,
                                                        'jumlah' => $item->jumlah,
                                                        'harga'  => $item->harga,
                                                    ])->toArray();
                                                }
                                                if (empty($externals)) {
                                                    $externals = [['jasa' => '', 'jumlah' => 1, 'harga' => '']];
                                                }
                                            @endphp
                                            @foreach($externals as $i => $item)
                                            <tr class="border-t item-row" data-section="external">
                                                <td class="px-4 py-2">
                                                    <input type="text" name="external_items[{{ $i }}][jasa]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm"
                                                        placeholder="Contoh: Jasa MC, Catering, Photography"
                                                        value="{{ $item['jasa'] ?? '' }}">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="external_items[{{ $i }}][jumlah]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm jumlah-input"
                                                        min="1" value="{{ $item['jumlah'] ?? 1 }}"
                                                        oninput="recalcRow(this)">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="external_items[{{ $i }}][harga]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm harga-input"
                                                        step="1" min="0" placeholder="0"
                                                        value="{{ $item['harga'] ?? '' }}"
                                                        oninput="recalcRow(this)">
                                                </td>
                                                <td class="px-4 py-2 text-right text-gray-700 font-medium subtotal-display">Rp 0</td>
                                                <td class="px-4 py-2 text-center">
                                                    <button type="button" onclick="removeRow(this)"
                                                        class="text-red-500 hover:text-red-700 text-lg leading-none">&times;</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- ══════════════════════════════════════════════════════════════
                             SECTION BARANG — selalu ikut
                        ══════════════════════════════════════════════════════════════ --}}
                        <div id="section-barang" class="hidden">
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-700">
                                        Barang: ATK / Perlengkapan
                                        <span class="ml-1 text-xs font-normal text-gray-500">(berlaku untuk semua tipe lokasi)</span>
                                    </label>
                                    <button type="button" onclick="addRow('barang')"
                                        class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">+ Tambah Barang</button>
                                </div>
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                            <tr>
                                                <th class="px-4 py-3 text-left">Nama Barang</th>
                                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                                <th class="px-4 py-3 text-right w-36">Harga/Satuan</th>
                                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                                                <th class="px-4 py-3 w-16"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-barang">
                                            @php
                                                $barangs = old('barang_items');
                                                if ($barangs === null) {
                                                    $barangs = $proposal->barangItems->map(fn($item) => [
                                                        'nama'   => $item->nama,
                                                        'jumlah' => $item->jumlah,
                                                        'harga'  => $item->harga,
                                                    ])->toArray();
                                                }
                                                if (empty($barangs)) {
                                                    $barangs = [['nama' => '', 'jumlah' => 1, 'harga' => '']];
                                                }
                                            @endphp
                                            @foreach($barangs as $i => $item)
                                            <tr class="border-t item-row" data-section="barang">
                                                <td class="px-4 py-2">
                                                    <input type="text" name="barang_items[{{ $i }}][nama]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm"
                                                        placeholder="Contoh: Kertas Banner, Spidol, Tinta"
                                                        value="{{ $item['nama'] ?? '' }}">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="barang_items[{{ $i }}][jumlah]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm jumlah-input"
                                                        min="1" value="{{ $item['jumlah'] ?? 1 }}"
                                                        oninput="recalcRow(this)">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="barang_items[{{ $i }}][harga]"
                                                        class="w-full px-2 py-1.5 border rounded text-sm harga-input"
                                                        step="1" min="0" placeholder="0"
                                                        value="{{ $item['harga'] ?? '' }}"
                                                        oninput="recalcRow(this)">
                                                </td>
                                                <td class="px-4 py-2 text-right text-gray-700 font-medium subtotal-display">Rp 0</td>
                                                <td class="px-4 py-2 text-center">
                                                    <button type="button" onclick="removeRow(this)"
                                                        class="text-red-500 hover:text-red-700 text-lg leading-none">&times;</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- ── Total Anggaran ──────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="anggaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Total Anggaran (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                                <input type="number" name="anggaran" id="anggaran" step="1" min="0" readonly
                                    class="mt-1 block w-full pl-10 rounded-md border-gray-300 shadow-sm bg-gray-50 font-semibold"
                                    value="{{ old('anggaran', $proposal->anggaran) }}" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Dihitung otomatis dari semua item di atas.</p>
                            @error('anggaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ── File Proposal ───────────────────────────────────────────── --}}
                        <div class="mb-6">
                            <label for="file_proposal" class="block text-sm font-medium text-gray-700 mb-2">
                                File Proposal (PDF, Max 5MB)
                            </label>
                            @if($proposal->file_proposal)
                            <p class="text-sm text-gray-500 mb-2">
                                File saat ini:
                                <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank"
                                    class="text-blue-600 underline">Lihat File</a>
                            </p>
                            @endif
                            <input type="file" name="file_proposal" id="file_proposal" accept=".pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti file.</p>
                            @error('file_proposal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- ── Buttons ─────────────────────────────────────────────────── --}}
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('proposals.show', $proposal) }}"
                                class="px-4 py-2 bg-gray-200 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
const counters = { internal: 0, external: 0, barang: 0 };

function onLokasiChange() {
    const tipe = document.getElementById('tipe_lokasi').value;

    document.getElementById('section-internal').classList.add('hidden');
    document.getElementById('section-external').classList.add('hidden');
    document.getElementById('section-barang').classList.add('hidden');

    if (tipe === 'internal') {
        document.getElementById('section-internal').classList.remove('hidden');
        document.getElementById('section-barang').classList.remove('hidden');
    } else if (tipe === 'eksternal') {
        document.getElementById('section-external').classList.remove('hidden');
        document.getElementById('section-barang').classList.remove('hidden');
    }

    updateTotalAnggaran();
}

function addRow(section) {
    const tbody = document.getElementById('tbody-' + section);
    const idx   = ++counters[section] + tbody.querySelectorAll('tr').length;

    let nameCell = '';
    if (section === 'external') {
        nameCell = `<input type="text" name="external_items[${idx}][jasa]"
            class="w-full px-2 py-1.5 border rounded text-sm"
            placeholder="Contoh: Jasa MC, Catering">`;
    } else {
        const prefix = section === 'internal' ? 'internal_items' : 'barang_items';
        const ph     = section === 'internal' ? 'Contoh: Kebersihan, Konsumsi' : 'Contoh: Spidol, Kertas';
        nameCell = `<input type="text" name="${prefix}[${idx}][nama]"
            class="w-full px-2 py-1.5 border rounded text-sm" placeholder="${ph}">`;
    }

    const jumlahName = section === 'internal' ? `internal_items[${idx}][jumlah]`
                     : section === 'external'  ? `external_items[${idx}][jumlah]`
                     :                           `barang_items[${idx}][jumlah]`;
    const hargaName  = section === 'internal' ? `internal_items[${idx}][harga]`
                     : section === 'external'  ? `external_items[${idx}][harga]`
                     :                           `barang_items[${idx}][harga]`;

    const tr = document.createElement('tr');
    tr.className = 'border-t item-row';
    tr.dataset.section = section;
    tr.innerHTML = `
        <td class="px-4 py-2">${nameCell}</td>
        <td class="px-4 py-2">
            <input type="number" name="${jumlahName}" class="w-full px-2 py-1.5 border rounded text-sm jumlah-input"
                min="1" value="1" oninput="recalcRow(this)">
        </td>
        <td class="px-4 py-2">
            <input type="number" name="${hargaName}" class="w-full px-2 py-1.5 border rounded text-sm harga-input"
                step="1" min="0" placeholder="0" oninput="recalcRow(this)">
        </td>
        <td class="px-4 py-2 text-right text-gray-700 font-medium subtotal-display">Rp 0</td>
        <td class="px-4 py-2 text-center">
            <button type="button" onclick="removeRow(this)"
                class="text-red-500 hover:text-red-700 text-lg leading-none">&times;</button>
        </td>`;
    tbody.appendChild(tr);
}

function removeRow(btn) {
    btn.closest('tr').remove();
    updateTotalAnggaran();
}

function recalcRow(input) {
    const row    = input.closest('tr');
    const jumlah = parseFloat(row.querySelector('.jumlah-input')?.value) || 0;
    const harga  = parseFloat(row.querySelector('.harga-input')?.value)  || 0;
    const sub    = jumlah * harga;
    const disp   = row.querySelector('.subtotal-display');
    if (disp) disp.textContent = 'Rp ' + sub.toLocaleString('id-ID', { maximumFractionDigits: 0 });
    updateTotalAnggaran();
}

function updateTotalAnggaran() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const sEl = document.getElementById('section-' + row.dataset.section);
        if (!sEl || sEl.classList.contains('hidden')) return;
        const jumlah = parseFloat(row.querySelector('.jumlah-input')?.value) || 0;
        const harga  = parseFloat(row.querySelector('.harga-input')?.value)  || 0;
        total += jumlah * harga;
    });
    const el = document.getElementById('anggaran');
    if (el) el.value = Math.round(total);
}

function initAllSubtotals() {
    document.querySelectorAll('.item-row').forEach(row => {
        const h = row.querySelector('.harga-input');
        if (h) recalcRow(h);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tipe_lokasi').addEventListener('change', onLokasiChange);
    onLokasiChange();
    initAllSubtotals();
});
</script>
</x-app-layout>