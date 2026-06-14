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
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('proposals.update', $proposal) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                value="{{ old('nama_kegiatan', $proposal->nama_kegiatan) }}" required>
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
                                required>{{ old('deskripsi', $proposal->deskripsi) }}</textarea>
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
                                    value="{{ old('tanggal_mulai', $proposal->tanggal_mulai->format('Y-m-d')) }}" required>
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
                                    value="{{ old('tanggal_selesai', $proposal->tanggal_selesai->format('Y-m-d')) }}" required>
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
                                <option value="internal" {{ old('tipe_lokasi', $proposal->tipe_lokasi) == 'internal' ? 'selected' : '' }}>
                                    Internal Kampus</option>
                                <option value="eksternal" {{ old('tipe_lokasi', $proposal->tipe_lokasi) == 'eksternal' ? 'selected' : '' }}>
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
                                placeholder="Masukkan nama tempat" value="{{ old('tempat', $proposal->tempat) }}" required>
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
                                            $internals = old('internal_items', $proposal->internal_items ?? [['item' => '', 'harga' => '']]);
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
                                            $externals = old('external_items', $proposal->external_items ?? [['jasa' => '', 'jumlah' => 1, 'harga' => '']]);
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
                                            $barangs = old('barang_items', $proposal->barang_items ?? [['nama' => '', 'jumlah' => 1, 'harga' => '']]);
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
                                placeholder="Masukkan total anggaran dalam rupiah" value="{{ old('anggaran', $proposal->anggaran) }}"
                                required>
                            @error('anggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Proposal -->
                        <div class="mb-6">
                            <label for="file_proposal" class="block text-sm font-medium text-gray-700 mb-2">
                                File Proposal (PDF, Max 5MB)
                            </label>
                            @if($proposal->file_proposal)
                            <p class="text-sm text-gray-600 mb-2">File saat ini: <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="text-blue-600">Lihat File</a></p>
                            @endif
                            <input type="file" name="file_proposal" id="file_proposal" accept=".pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('file_proposal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: PDF, Maksimal 5MB (Opsional jika tidak diubah)</p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('proposals.show', $proposal) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                        class="w-full px-2 py-2 border rounded" step="0.01" min="0"
                        placeholder="Rp">
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
        }

        // Calculate subtotal for external and barang rows
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
        }

        // Calculate all subtotals on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#external-items tr, #barang-items tr').forEach(row => {
                const hargaInput = row.querySelector('.harga-input');
                if (hargaInput) {
                    calculateSubtotal(hargaInput);
                }
            });
        });
    </script>
</x-app-layout>
