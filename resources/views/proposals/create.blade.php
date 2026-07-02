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
                    @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <p class="font-semibold">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div x-data="{ 
                        proposalType: '{{ old('type', $proposal->type ?? 'dana') }}', 
                        locationType: '{{ old('tipe_lokasi', $proposal->tipe_lokasi ?? '') }}' 
                    }">

                        <form method="POST" action="{{ route('proposals.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- ── Periode ─────────────────────────────────────────────────── --}}
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
                                    value="{{ old('nama_kegiatan') }}" required>
                                @error('nama_kegiatan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- ── Deskripsi ───────────────────────────────────────────────── --}}
                            <div class="mb-6">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>{{ old('deskripsi') }}</textarea>
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
                                        value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ old('tanggal_selesai') }}" required>
                                    @error('tanggal_selesai')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- ── Tipe Lokasi (Opsional) ─────────────────────────────────── --}}
                            <div class="mb-6">
                                <label for="tipe_lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipe Lokasi <span class="text-xs text-gray-400">(Opsional)</span>
                                </label>
                                <select name="tipe_lokasi" id="tipe_lokasi" x-model="locationType" @change="setTimeout(() => onLokasiChange(), 50)"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Pilih Tipe Lokasi (Boleh Kosong) --</option>
                                    <option value="internal">Internal Kampus</option>
                                    <option value="eksternal">Eksternal Kampus</option>
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
                                    placeholder="Masukkan nama tempat" value="{{ old('tempat') }}" required>
                                @error('tempat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
        
                            <div class="mb-6">
                                <x-input-label for="type" value="Jenis Proposal" class="mb-2" />
                                <select id="type" name="type" x-model="proposalType" @change="setTimeout(() => updateTotalAnggaran(), 50)" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="dana">Dana</option>
                                    <option value="non_dana">Non Dana</option>
                                </select>
                            </div>

                            <div x-show="proposalType === 'dana' && locationType !== ''" x-transition class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                {{-- ── Rincian Anggaran ── --}}
                                <div id="section-anggaran">
                                    <div class="mb-2 pb-2 border-b-2 border-blue-200">
                                        <h3 class="text-base font-bold text-blue-800" id="label-anggaran-judul">Rincian Anggaran</h3>
                                    </div>

                                    @php $kategoriBlank = [['nama' => '', 'jumlah' => '', 'harga' => '']]; @endphp
                                    
                                    <div class="mt-5">
                                        <x-budget-category-table title="1. Konsumsi" subtitle="Makanan, snack, air minum, dll" section="konsumsi" :items="old('konsumsi_items', $kategoriBlank)" placeholder="Contoh: Nasi kotak" />
                                    </div>

                                    <div class="mt-5">
                                        <x-budget-category-table title="2. Barang Habis Pakai & ATK" subtitle="Pulpen, banner, dll" section="atk" :items="old('atk_items', $kategoriBlank)" placeholder="Contoh: Banner" />
                                    </div>

                                    <div class="mt-5">
                                        <x-budget-category-table title="3. Honor dan Jasa" subtitle="MC, pemateri — satuan: orang" section="honor" :items="old('honor_items', $kategoriBlank)" placeholder="Contoh: MC" unit-label="orang" />
                                    </div>

                                    <div class="mt-5">
                                        <x-budget-category-table title="4. Penyewaan" subtitle="Tempat, alat, kamera, dll" section="sewa" :items="old('sewa_items', $kategoriBlank)" placeholder="Contoh: Sewa aula" />
                                    </div>

                                    <div id="cat-dokumentasi" class="mt-5 hidden">
                                        <x-budget-category-table title="5. Dokumentasi Kegiatan" subtitle="Print, cetak undangan, dll" section="dokumentasi" :items="old('dokumentasi_items', $kategoriBlank)" placeholder="Contoh: Print proposal" />
                                    </div>

                                    <div id="cat-transportasi" class="mt-5 hidden">
                                        <x-budget-category-table title="5. Transportasi" subtitle="Biaya transportasi panitia" section="transportasi" :items="old('transportasi_items', $kategoriBlank)" placeholder="Contoh: Bensin" />
                                    </div>

                                    <div id="cat-kebersihan" class="mt-5 hidden">
                                        <div class="rounded-lg border border-gray-200 overflow-hidden bg-white">
                                            <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                                                <span class="text-sm font-semibold text-gray-800">6. Kebersihan</span>
                                            </div>
                                            <div class="p-4">
                                                <textarea name="kebersihan_keterangan" rows="2" class="w-full rounded-md border-gray-300 text-sm" placeholder="Rincian kebersihan">{{ old('kebersihan_keterangan') }}</textarea>
                                                <div class="mt-2 flex items-center gap-3">
                                                    <label class="text-xs font-medium text-gray-600">Biaya Kebersihan (Rp)</label>
                                                    <input type="number" name="kebersihan_biaya" id="kebersihan_biaya" class="flex-1 rounded-md border-gray-300 text-sm" min="0" placeholder="0" value="{{ old('kebersihan_biaya') }}" oninput="updateTotalAnggaran()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ── Dana Sponsor (di bawah Kebersihan) ── --}}
                                    <div id="cat-dana-sponsor" class="mt-5">
                                        <div class="rounded-lg border border-gray-200 overflow-hidden bg-white">
                                            <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                                                <span class="text-sm font-semibold text-gray-800">7. Dana Sponsor</span>
                                            </div>
                                            <div class="p-4">
                                                <textarea name="dana_sponsor_keterangan" rows="2" class="w-full rounded-md border-gray-300 text-sm" placeholder="Rincian sumber dana sponsor (nama sponsor, bentuk dukungan, dll)">{{ old('dana_sponsor_keterangan') }}</textarea>
                                                <div class="mt-2 flex items-center gap-3">
                                                    <label class="text-xs font-medium text-gray-600">Nominal Dana Sponsor (Rp)</label>
                                                    <input type="number" name="dana_sponsor_biaya" id="dana_sponsor_biaya" class="flex-1 rounded-md border-gray-300 text-sm" min="0" placeholder="0" value="{{ old('dana_sponsor_biaya') }}">
                                                </div>
                                                <p class="mt-1 text-xs text-gray-400">Nominal ini bersifat informasi sumber dana dan tidak mengurangi/menambah Total Anggaran secara otomatis.</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ── Dll (kategori tambahan lain-lain) ── --}}
                                    <div class="mt-5">
                                        <x-budget-category-table title="8. Dll" subtitle="Pengeluaran lain-lain yang belum tercakup kategori di atas" section="dll" :items="old('dll_items', $kategoriBlank)" placeholder="Contoh: Biaya lain-lain" />
                                    </div>
                                </div>

                                {{-- ── Total Anggaran ── --}}
                                <div class="mt-6 mb-6">
                                    <label for="anggaran" class="block text-sm font-medium text-gray-700 mb-2">
                                        Total Anggaran (Rp) <span class="text-xs text-gray-400">(Opsional/Otomatis)</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="anggaran" id="anggaran" step="1" min="0"
                                            class="mt-1 block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-semibold"
                                            value="{{ old('anggaran') }}">
                                    </div>
                                    @error('anggaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                              
                            {{-- ── File Proposal ───────────────────────────────────────────── --}}
                            <div class="mb-6 mt-6">
                                <label for="file_proposal" class="block text-sm font-medium text-gray-700 mb-2">
                                    File Proposal (PDF, Max 5MB) <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="file_proposal" id="file_proposal" accept=".pdf"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:bg-blue-50 file:text-blue-700"
                                    required>
                                @error('file_proposal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                                <a href="{{ route('proposals.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-sm text-gray-700">Batal</a>
                                <button type="submit" class="px-6 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white">Ajukan Proposal</button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>

<script>
const ALL_SECTIONS = ['konsumsi','atk','honor','sewa','dokumentasi','transportasi','dll'];

function onLokasiChange() {
    const tipe = document.getElementById('tipe_lokasi').value;
    const catDokumentasi  = document.getElementById('cat-dokumentasi');
    const catTransportasi = document.getElementById('cat-transportasi');
    const catKebersihan   = document.getElementById('cat-kebersihan');

    if (!tipe) {
        if(catDokumentasi) catDokumentasi.classList.add('hidden');
        if(catTransportasi) catTransportasi.classList.add('hidden');
        if(catKebersihan) catKebersihan.classList.add('hidden');
        updateTotalAnggaran();
        return;
    }

    if (tipe === 'internal') {
        if(catDokumentasi) catDokumentasi.classList.remove('hidden');
        if(catTransportasi) catTransportasi.classList.add('hidden');
        if(catKebersihan) catKebersihan.classList.remove('hidden');
    } else {
        if(catDokumentasi) catDokumentasi.classList.add('hidden');
        if(catTransportasi) catTransportasi.classList.remove('hidden');
        if(catKebersihan) catKebersihan.classList.add('hidden');
    }
    updateTotalAnggaran();
}

function addRow(section) {
    const tbody = document.getElementById('tbody-' + section);
    const idx   = tbody.querySelectorAll('tr').length + 1;

    const tr = document.createElement('tr');
    tr.className = 'border-t item-row';
    tr.dataset.section = section;
    tr.innerHTML = `
        <td class="px-3 py-2"><input type="text" name="${section}_items[${idx}][nama]" class="w-full px-2 py-1.5 border rounded text-sm"></td>
        <td class="px-3 py-2"><input type="number" name="${section}_items[${idx}][jumlah]" class="w-full px-2 py-1.5 border rounded text-sm jumlah-input" min="0" value="" placeholder="0" oninput="recalcRow(this)"></td>
        <td class="px-3 py-2"><input type="number" name="${section}_items[${idx}][harga]" class="w-full px-2 py-1.5 border rounded text-sm harga-input" min="0" placeholder="0" oninput="recalcRow(this)"></td>
        <td class="px-3 py-2 text-right text-gray-700 font-medium subtotal-display text-sm">Rp 0</td>
        <td class="px-3 py-2 text-center"><button type="button" onclick="removeRow(this)" class="text-red-400 text-xl">&times;</button></td>`;
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
    if (disp) disp.textContent = 'Rp ' + sub.toLocaleString('id-ID');
    updateTotalAnggaran();
}

function updateTotalAnggaran() {
    const typeEl = document.getElementById('type');
    const locEl = document.getElementById('tipe_lokasi');
    const el = document.getElementById('anggaran');
    
    // Reset total jika non_dana atau tipe lokasi kosong
    if ((typeEl && typeEl.value === 'non_dana') || (locEl && locEl.value === '')) {
        if (el) el.value = '';
        return;
    }

    let total = 0;
    let hasInput = false;

    document.querySelectorAll('.item-row').forEach(row => {
        const section = row.dataset.section;
        const specificCat = document.getElementById('cat-' + section);
        if (specificCat && specificCat.classList.contains('hidden')) return;

        const jVal = row.querySelector('.jumlah-input')?.value;
        const hVal = row.querySelector('.harga-input')?.value;

        if (jVal || hVal) hasInput = true;

        const jumlah = parseFloat(jVal) || 0;
        const harga  = parseFloat(hVal) || 0;
        total += jumlah * harga;
    });

    const kVal = document.getElementById('kebersihan_biaya')?.value;
    if (kVal) {
        const catKebersihan = document.getElementById('cat-kebersihan');
        if (catKebersihan && !catKebersihan.classList.contains('hidden')) {
            hasInput = true;
            total += parseFloat(kVal) || 0;
        }
    }

    if (el) {
        el.value = hasInput ? Math.round(total) : '';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tipe_lokasi').addEventListener('change', onLokasiChange);
    onLokasiChange();
});
</script>
</x-app-layout>