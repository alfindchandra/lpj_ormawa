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

                        <!-- Tipe Lokasi Pelaksanaan -->
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

                        <!-- Tempat Pelaksanaan -->
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

                        <!-- INTERNAL: Kebersihan dll -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Internal: Kebersihan dll <span class="text-red-500">*</span>
                            </label>
                            <div class="overflow-x-auto border rounded-lg">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-3 text-left">Item</th>
                                            <th class="px-4 py-3 text-right">Harga</th>
                                            <th class="px-4 py-3 text-center w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="internal-items">
                                        @php
                                            $internals = old('internal_items', [['item' => '', 'harga' => '']]);
                                        @endphp
                                        @foreach($internals as $index => $item)
                                        <tr class="border-t">
                                            <td class="px-4 py-3">
                                                <input type="text" name="internal_items[{{ $index }}][item]"
                                                    class="w-full px-2 py-2 border rounded"
                                                    placeholder="Contoh: Kebersihan, Dekorasi"
                                                    value="{{ $item['item'] ?? '' }}">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="internal_items[{{ $index }}][harga]"
                                                    class="w-full px-2 py-2 border rounded" step="0.01" min="0"
                                                    placeholder="Rp"
                                                    value="{{ $item['harga'] ?? '' }}">
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
                                onclick="addInternalRow()">+ Tambah Item</button>
                        </div>

                        <!-- EXTERNAL: Jasa MC dll -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                External: Jasa MC dll <span class="text-red-500">*</span>
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
                                        @php
                                            $externals = old('external_items', [['jasa' => '', 'jumlah' => 1, 'harga' => '']]);
                                        @endphp
                                        @foreach($externals as $index => $item)
                                        <tr class="border-t">
                                            <td class="px-4 py-3">
                                                <input type="text" name="external_items[{{ $index }}][jasa]"
                                                    class="w-full px-2 py-2 border rounded"
                                                    placeholder="Contoh: Jasa MC, Catering, Photography"
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
                                                    step="0.01" min="0"
                                                    placeholder="Rp"
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

                        <!-- BARANG: ATK/Perlengkapan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Barang: ATK/Perlengkapan <span class="text-red-500">*</span>
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
                                        @php
                                            $barangs = old('barang_items', [['nama' => '', 'jumlah' => 1, 'harga' => '']]);
                                        @endphp
                                        @foreach($barangs as $index => $item)
                                        <tr class="border-t">
                                            <td class="px-4 py-3">
                                                <input type="text" name="barang_items[{{ $index }}][nama]"
                                                    class="w-full px-2 py-2 border rounded"
                                                    placeholder="Contoh: Kertas Banner, Spidol, Tinta"
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
                                                    step="0.01" min="0"
                                                    placeholder="Rp"
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

                        <!-- Total Anggaran (Rp) -->
                        <div class="mb-6">
                            <label for="anggaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Anggaran (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="anggaran" id="anggaran" step="0.01" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan total anggaran dalam rupiah" value="{{ old('anggaran') }}"
                                required>
                            @error('anggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
    // Fungsi pembantu untuk menghitung total keseluruhan anggaran
    function updateTotalAnggaran() {
        let total = 0;

        // 1. Hitung dari Internal Items (Langsung ambil nilai harga karena jumlahnya dianggap 1)
        document.querySelectorAll('#internal-items tr').forEach(row => {
            const hargaInput = row.querySelector('input[name*="[harga]"]');
            if (hargaInput) {
                total += parseFloat(hargaInput.value) || 0;
            }
        });

        // 2. Hitung dari External Items (Jumlah * Harga)
        document.querySelectorAll('#external-items tr').forEach(row => {
            const jumlahInput = row.querySelector('.jumlah-input');
            const hargaInput = row.querySelector('.harga-input');
            if (jumlahInput && hargaInput) {
                const jumlah = parseInt(jumlahInput.value) || 0;
                const harga = parseFloat(hargaInput.value) || 0;
                total += jumlah * harga;
            }
        });

        // 3. Hitung dari Barang Items (Jumlah * Harga)
        document.querySelectorAll('#barang-items tr').forEach(row => {
            const jumlahInput = row.querySelector('.jumlah-input');
            const hargaInput = row.querySelector('.harga-input');
            if (jumlahInput && hargaInput) {
                const jumlah = parseInt(jumlahInput.value) || 0;
                const harga = parseFloat(hargaInput.value) || 0;
                total += jumlah * harga;
            }
        });

        // Masukkan hasil total ke input anggaran (pembulatan 2 angka di belakang koma untuk step="0.01")
        const anggaranInput = document.getElementById('anggaran');
        if (anggaranInput) {
            anggaranInput.value = total.toFixed(0);
        }
    }

    // INTERNAL functions
    function addInternalRow() {
        const tbody = document.getElementById('internal-items');
        const index = tbody.children.length;
        const row = document.createElement('tr');
        row.className = 'border-t';
        row.innerHTML = `
            <td class="px-4 py-3">
                <input type="text" name="internal_items[${index}][item]"
                    class="w-full px-2 py-2 border rounded"
                    placeholder="Contoh: Kebersihan, Dekorasi">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="internal_items[${index}][harga]"
                    class="w-full px-2 py-2 border rounded harga-internal-input" step="0.01" min="0"
                    placeholder="Rp" onchange="updateTotalAnggaran()">
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="text-red-600 hover:text-red-800"
                    onclick="removeInternalRow(this)">Hapus</button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function removeInternalRow(btn) {
        btn.closest('tr').remove();
        updateTotalAnggaran(); // Update total setelah baris dihapus
    }
 
    // EXTERNAL functions
    function addExternalRow() {
        const tbody = document.getElementById('external-items');
        const index = tbody.children.length;
        const row = document.createElement('tr');
        row.className = 'border-t';
        row.innerHTML = `
            <td class="px-4 py-3">
                <input type="text" name="external_items[${index}][jasa]"
                    class="w-full px-2 py-2 border rounded"
                    placeholder="Contoh: Jasa MC, Catering, Photography">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="external_items[${index}][jumlah]"
                    class="w-full px-2 py-2 border rounded jumlah-input" 
                    min="1" value="1" onchange="calculateSubtotal(this)">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="external_items[${index}][harga]"
                    class="w-full px-2 py-2 border rounded harga-input" 
                    step="0.01" min="0" placeholder="Rp" onchange="calculateSubtotal(this)">
            </td>
            <td class="px-4 py-3 text-right pr-4">
                <span class="subtotal-display">Rp 0</span>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="text-red-600 hover:text-red-800"
                    onclick="removeExternalRow(this)">Hapus</button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function removeExternalRow(btn) {
        btn.closest('tr').remove();
        updateTotalAnggaran(); // Update total setelah baris dihapus
    }

    // BARANG functions
    function addBarangRow() {
        const tbody = document.getElementById('barang-items');
        const index = tbody.children.length;
        const row = document.createElement('tr');
        row.className = 'border-t';
        row.innerHTML = `
            <td class="px-4 py-3">
                <input type="text" name="barang_items[${index}][nama]"
                    class="w-full px-2 py-2 border rounded"
                    placeholder="Contoh: Kertas Banner, Spidol, Tinta">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="barang_items[${index}][jumlah]"
                    class="w-full px-2 py-2 border rounded jumlah-input" 
                    min="1" value="1" onchange="calculateSubtotal(this)">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="barang_items[${index}][harga]"
                    class="w-full px-2 py-2 border rounded harga-input" 
                    step="0.01" min="0" placeholder="Rp" onchange="calculateSubtotal(this)">
            </td>
            <td class="px-4 py-3 text-right pr-4">
                <span class="subtotal-display">Rp 0</span>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="text-red-600 hover:text-red-800"
                    onclick="removeBarangRow(this)">Hapus</button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function removeBarangRow(btn) {
        btn.closest('tr').remove();
        updateTotalAnggaran(); // Update total setelah baris dihapus
    }

    // Calculate subtotal untuk external dan barang rows
    function calculateSubtotal(input) {
        const row = input.closest('tr');
        const jumlahInput = row.querySelector('.jumlah-input');
        const hargaInput = row.querySelector('.harga-input');
        const subtotalDisplay = row.querySelector('.subtotal-display');

        if (jumlahInput && hargaInput && subtotalDisplay) {
            const jumlah = parseInt(jumlahInput.value) || 0;
            const harga = parseFloat(hargaInput.value) || 0;
            const subtotal = jumlah * harga;
            
            subtotalDisplay.textContent = 'Rp ' + subtotal.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        }
        
        // Panggil perhitungan total anggaran setelah subtotal baris berubah
        updateTotalAnggaran();
    }

    // Hitung ulang semua subtotal dan total anggaran saat halaman pertama kali dimuat (Old Data handling)
    document.addEventListener('DOMContentLoaded', function() {
        // Tambah event listener manual untuk input internal bawaan dari `old()` Laravel
        document.querySelectorAll('#internal-items tr').forEach(row => {
            const hargaInput = row.querySelector('input[name*="[harga]"]');
            if (hargaInput) {
                hargaInput.addEventListener('change', updateTotalAnggaran);
            }
        });

        // Hitung subtotal & total untuk tabel external dan barang bawaan dari `old()` Laravel
        document.querySelectorAll('#external-items tr, #barang-items tr').forEach(row => {
            const hargaInput = row.querySelector('.harga-input');
            if (hargaInput) {
                calculateSubtotal(hargaInput);
            }
        });
        
        // Terakhir, pastikan total terhitung di awal
        updateTotalAnggaran();
    });
</script>

</x-app-layout>