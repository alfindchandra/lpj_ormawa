<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Proposal Kegiatan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('proposals.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Periode Kepengurusan -->
                        <div class="mb-6">
                            <label for="period_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Periode Kepengurusan <span class="text-red-500">*</span>
                            </label>
                            @if($periods->isEmpty())
                                <div class="p-4 bg-yellow-50 border border-yellow-300 rounded-md text-yellow-800 text-sm">
                                    Belum ada periode yang tersedia. Hubungi admin untuk menambahkan periode.
                                </div>
                            @else
                            <select name="period_id" id="period_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periods as $period)
                                <option value="{{ $period->id }}"
                                    {{ old('period_id', $activePeriod?->id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->nama_periode }}
                                    ({{ $period->tahun_mulai }}/{{ $period->tahun_selesai }})
                                    @if($period->is_active) — Aktif @endif
                                </option>
                                @endforeach
                            </select>
                            @endif
                            @error('period_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Periode aktif otomatis dipilih. Anda bisa menggantinya jika perlu.
                            </p>
                        </div>

                        <!-- Nama Kegiatan -->
                        <div class="mb-6">
                            <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('nama_kegiatan') }}" required>
                            @error('nama_kegiatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe Lokasi -->
                        <div class="mb-6">
                            <label for="tipe_lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Lokasi <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe_lokasi" id="tipe_lokasi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Tipe Lokasi --</option>
                                <option value="internal" {{ old('tipe_lokasi') == 'internal' ? 'selected' : '' }}>
                                    Internal Kampus</option>
                                <option value="eksternal" {{ old('tipe_lokasi') == 'eksternal' ? 'selected' : '' }}>
                                    Eksternal Kampus</option>
                            </select>
                            @error('tipe_lokasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat -->
                        <div class="mb-6">
                            <label for="tempat" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Pelaksanaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat" id="tempat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan nama tempat" value="{{ old('tempat') }}" required>
                            @error('tempat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ===================== SECTION INTERNAL ===================== --}}
                        <div id="section-internal" style="display:none;">

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    Internal: Anggaran Perlengkapan & Kegiatan
                                </label>
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-3 text-left">Nama Barang / Item</th>
                                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                                <th class="px-4 py-3 text-right">Harga/Satuan</th>
                                                <th class="px-4 py-3 text-right">Subtotal</th>
                                                <th class="px-4 py-3 text-center w-20">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="internal-items">
                                            @php 
                                                $internals = old('internal_items', [['nama' => '', 'jumlah' => 1, 'harga' => '']]); 
                                            @endphp
                                            @foreach($internals as $index => $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-3">
                                                    <input type="text" name="internal_items[{{ $index }}][nama]"
                                                        class="w-full px-2 py-2 border rounded"
                                                        placeholder="Contoh: Kebersihan, Konsumsi, Banner"
                                                        value="{{ $item['nama'] ?? '' }}">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="internal_items[{{ $index }}][jumlah]"
                                                        class="w-full px-2 py-2 border rounded jumlah-input"
                                                        min="1" value="{{ $item['jumlah'] ?? 1 }}"
                                                        onchange="calculateSubtotal(this)">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="internal_items[{{ $index }}][harga]"
                                                        class="w-full px-2 py-2 border rounded harga-input"
                                                        step="0.01" min="0" placeholder="Rp"
                                                        value="{{ $item['harga'] ?? '' }}"
                                                        onchange="calculateSubtotal(this)">
                                                </td>
                                                <td class="px-4 py-3 text-right pr-4">
                                                    <span class="subtotal-display">Rp 0</span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button" class="text-red-600 hover:text-red-800"
                                                        onclick="removeInternalRow(this)">Hapus</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                    onclick="addInternalRow()">+ Tambah Item Internal</button>
                            </div>

                        </div>{{-- end section-internal --}}

                        {{-- ===================== SECTION EKSTERNAL ===================== --}}
                        <div id="section-external" style="display:none;">

                            <!-- EXTERNAL: Jasa MC dll -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    External: Jasa MC dll
                                </label>
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-3 text-left">Jasa/Layanan</th>
                                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                                <th class="px-4 py-3 text-right">Harga/Satuan</th>
                                                <th class="px-4 py-3 text-right">Subtotal</th>
                                                <th class="px-4 py-3 text-center w-20">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="external-items">
                                            @php $externals = old('external_items', [['jasa' => '', 'jumlah' => 1, 'harga' => '']]); @endphp
                                            @foreach($externals as $index => $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-3">
                                                    <input type="text" name="external_items[{{ $index }}][jasa]"
                                                        class="w-full px-2 py-2 border rounded"
                                                        placeholder="Contoh: Jasa MC, Catering"
                                                        value="{{ $item['jasa'] ?? '' }}">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="external_items[{{ $index }}][jumlah]"
                                                        class="w-full px-2 py-2 border rounded jumlah-input"
                                                        min="1" value="{{ $item['jumlah'] ?? 1 }}"
                                                        onchange="calculateSubtotal(this)">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="external_items[{{ $index }}][harga]"
                                                        class="w-full px-2 py-2 border rounded harga-input"
                                                        step="0.01" min="0" placeholder="Rp"
                                                        value="{{ $item['harga'] ?? '' }}"
                                                        onchange="calculateSubtotal(this)">
                                                </td>
                                                <td class="px-4 py-3 text-right pr-4">
                                                    <span class="subtotal-display">Rp 0</span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button" class="text-red-600 hover:text-red-800"
                                                        onclick="removeExternalRow(this)">Hapus</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                    onclick="addExternalRow()">+ Tambah Jasa</button>
                            </div>

                            <!-- EXTERNAL: Barang ATK/Perlengkapan -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    Barang: ATK/Perlengkapan
                                </label>
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-3 text-left">Nama Barang</th>
                                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                                <th class="px-4 py-3 text-right">Harga/Satuan</th>
                                                <th class="px-4 py-3 text-right">Subtotal</th>
                                                <th class="px-4 py-3 text-center w-20">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="barang-items">
                                            @php $barangs = old('barang_items', [['nama' => '', 'jumlah' => 1, 'harga' => '']]); @endphp
                                            @foreach($barangs as $index => $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-3">
                                                    <input type="text" name="barang_items[{{ $index }}][nama]"
                                                        class="w-full px-2 py-2 border rounded"
                                                        placeholder="Contoh: Kertas Banner, Spidol"
                                                        value="{{ $item['nama'] ?? '' }}">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="barang_items[{{ $index }}][jumlah]"
                                                        class="w-full px-2 py-2 border rounded jumlah-input"
                                                        min="1" value="{{ $item['jumlah'] ?? 1 }}"
                                                        onchange="calculateSubtotal(this)">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="barang_items[{{ $index }}][harga]"
                                                        class="w-full px-2 py-2 border rounded harga-input"
                                                        step="0.01" min="0" placeholder="Rp"
                                                        value="{{ $item['harga'] ?? '' }}"
                                                        onchange="calculateSubtotal(this)">
                                                </td>
                                                <td class="px-4 py-3 text-right pr-4">
                                                    <span class="subtotal-display">Rp 0</span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button" class="text-red-600 hover:text-red-800"
                                                        onclick="removeBarangRow(this)">Hapus</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                    onclick="addBarangRow()">+ Tambah Barang</button>
                            </div>

                        </div>{{-- end section-external --}}

                        <!-- Total Anggaran -->
                        <div class="mb-6">
                            <label for="anggaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Anggaran (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="anggaran" id="anggaran" step="0.01" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50"
                                placeholder="Otomatis dihitung dari item di atas" value="{{ old('anggaran') }}" required readonly>
                            @error('anggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Total dihitung otomatis dari item yang diisi.</p>
                        </div>

                        <!-- File Proposal -->
                        <div class="mb-6">
                            <label for="file_proposal" class="block text-sm font-medium text-gray-700 mb-2">
                                File Proposal (PDF, Max 5MB) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="file_proposal" id="file_proposal" accept=".pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                required>
                            @error('file_proposal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: PDF, Maksimal 5MB</p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('proposals.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Ajukan Proposal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
// ===================== TOGGLE SECTION =====================
function toggleLokasiSections() {
    const tipe = document.getElementById('tipe_lokasi').value;
    const sectionInternal = document.getElementById('section-internal');
    const sectionExternal = document.getElementById('section-external');

    if (tipe === 'internal') {
        sectionInternal.style.display = 'block';
        sectionExternal.style.display = 'none';
        clearSectionInputs(sectionExternal);
    } else if (tipe === 'eksternal') {
        sectionInternal.style.display = 'none';
        sectionExternal.style.display = 'block';
        clearSectionInputs(sectionInternal);
    } else {
        sectionInternal.style.display = 'none';
        sectionExternal.style.display = 'none';
    }

    updateTotalAnggaran();
}

function clearSectionInputs(section) {
    section.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
        if (input.type === 'number' && input.classList.contains('jumlah-input')) {
            input.value = 1;
        } else {
            input.value = '';
        }
    });
    section.querySelectorAll('.subtotal-display').forEach(el => el.textContent = 'Rp 0');
}

// ===================== TOTAL ANGGARAN =====================
function updateTotalAnggaran() {
    let total = 0;
    const tipe = document.getElementById('tipe_lokasi').value;

    if (tipe === 'internal') {
        document.querySelectorAll('#internal-items tr').forEach(row => {
            const j = row.querySelector('.jumlah-input');
            const h = row.querySelector('.harga-input');
            if (j && h) total += (parseInt(j.value) || 0) * (parseFloat(h.value) || 0);
        });
    } else if (tipe === 'eksternal') {
        // Hitung semua item yang ada di section eksternal (jasa & barang)
        document.querySelectorAll('#external-items tr, #barang-items tr').forEach(row => {
            const j = row.querySelector('.jumlah-input');
            const h = row.querySelector('.harga-input');
            if (j && h) total += (parseInt(j.value) || 0) * (parseFloat(h.value) || 0);
        });
    }

    const anggaranInput = document.getElementById('anggaran');
    if (anggaranInput) anggaranInput.value = total.toFixed(0);
}

// ===================== DYNAMIC ROWS =====================
function addInternalRow() {
    const tbody = document.getElementById('internal-items');
    const index = tbody.children.length;
    const row = document.createElement('tr');
    row.className = 'border-t';
    row.innerHTML = `
        <td class="px-4 py-3"><input type="text" name="internal_items[${index}][nama]" class="w-full px-2 py-2 border rounded" placeholder="Contoh: Kebersihan, Konsumsi"></td>
        <td class="px-4 py-3"><input type="number" name="internal_items[${index}][jumlah]" class="w-full px-2 py-2 border rounded jumlah-input" min="1" value="1" onchange="calculateSubtotal(this)"></td>
        <td class="px-4 py-3"><input type="number" name="internal_items[${index}][harga]" class="w-full px-2 py-2 border rounded harga-input" step="0.01" min="0" placeholder="Rp" onchange="calculateSubtotal(this)"></td>
        <td class="px-4 py-3 text-right pr-4"><span class="subtotal-display">Rp 0</span></td>
        <td class="px-4 py-3 text-center"><button type="button" class="text-red-600 hover:text-red-800" onclick="removeInternalRow(this)">Hapus</button></td>`;
    tbody.appendChild(row);
}
function removeInternalRow(btn) { btn.closest('tr').remove(); updateTotalAnggaran(); }

function addExternalRow() {
    const tbody = document.getElementById('external-items');
    const index = tbody.children.length;
    const row = document.createElement('tr');
    row.className = 'border-t';
    row.innerHTML = `
        <td class="px-4 py-3"><input type="text" name="external_items[${index}][jasa]" class="w-full px-2 py-2 border rounded" placeholder="Contoh: Jasa MC, Catering"></td>
        <td class="px-4 py-3"><input type="number" name="external_items[${index}][jumlah]" class="w-full px-2 py-2 border rounded jumlah-input" min="1" value="1" onchange="calculateSubtotal(this)"></td>
        <td class="px-4 py-3"><input type="number" name="external_items[${index}][harga]" class="w-full px-2 py-2 border rounded harga-input" step="0.01" min="0" placeholder="Rp" onchange="calculateSubtotal(this)"></td>
        <td class="px-4 py-3 text-right pr-4"><span class="subtotal-display">Rp 0</span></td>
        <td class="px-4 py-3 text-center"><button type="button" class="text-red-600 hover:text-red-800" onclick="removeExternalRow(this)">Hapus</button></td>`;
    tbody.appendChild(row);
}
function removeExternalRow(btn) { btn.closest('tr').remove(); updateTotalAnggaran(); }

function addBarangRow() {
    const tbody = document.getElementById('barang-items');
    const index = tbody.children.length;
    const row = document.createElement('tr');
    row.className = 'border-t';
    row.innerHTML = `
        <td class="px-4 py-3"><input type="text" name="barang_items[${index}][nama]" class="w-full px-2 py-2 border rounded" placeholder="Contoh: Kertas Banner, Spidol"></td>
        <td class="px-4 py-3"><input type="number" name="barang_items[${index}][jumlah]" class="w-full px-2 py-2 border rounded jumlah-input" min="1" value="1" onchange="calculateSubtotal(this)"></td>
        <td class="px-4 py-3"><input type="number" name="barang_items[${index}][harga]" class="w-full px-2 py-2 border rounded harga-input" step="0.01" min="0" placeholder="Rp" onchange="calculateSubtotal(this)"></td>
        <td class="px-4 py-3 text-right pr-4"><span class="subtotal-display">Rp 0</span></td>
        <td class="px-4 py-3 text-center"><button type="button" class="text-red-600 hover:text-red-800" onclick="removeBarangRow(this)">Hapus</button></td>`;
    tbody.appendChild(row);
}
function removeBarangRow(btn) { btn.closest('tr').remove(); updateTotalAnggaran(); }

// ===================== CALCULATE SUBTOTAL =====================
function calculateSubtotal(input) {
    const row = input.closest('tr');
    const j = row.querySelector('.jumlah-input');
    const h = row.querySelector('.harga-input');
    const s = row.querySelector('.subtotal-display');
    if (j && h && s) {
        const subtotal = (parseInt(j.value) || 0) * (parseFloat(h.value) || 0);
        s.textContent = 'Rp ' + subtotal.toLocaleString('id-ID', { maximumFractionDigits: 0 });
    }
    updateTotalAnggaran();
}

// ===================== ON LOAD =====================
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tipe_lokasi').addEventListener('change', toggleLokasiSections);
    toggleLokasiSections();

    // Hitung subtotal awal untuk old value jika ada error validasi
    document.querySelectorAll('#internal-items tr, #external-items tr, #barang-items tr').forEach(row => {
        const h = row.querySelector('.harga-input');
        if (h) calculateSubtotal(h);
    });

    updateTotalAnggaran();
});
</script>
</x-app-layout>