<!-- resources/views/lpj/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Laporan Pertanggungjawaban (LPJ)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Kegiatan -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Informasi Kegiatan</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-blue-700">Nama Kegiatan:</span>
                        <p class="font-semibold text-blue-900">{{ $activity->proposal->nama_kegiatan }}</p>
                    </div>
                    <div>
                        <span class="text-blue-700">Kode Proposal:</span>
                        <p class="font-semibold text-blue-900">{{ $activity->proposal->kode_proposal }}</p>
                    </div>
                    <div>
                        <span class="text-blue-700">Tanggal Pelaksanaan:</span>
                        <p class="font-semibold text-blue-900">
                            {{ $activity->proposal->tanggal_mulai->format('d/m/Y') }} - 
                            {{ $activity->proposal->tanggal_selesai->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <span class="text-blue-700">Anggaran Disetujui:</span>
                        <p class="font-semibold text-blue-900">Rp {{ number_format($activity->proposal->anggaran, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Form LPJ -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('lpj.store', $activity) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Laporan Kegiatan -->
                        <div class="mb-6">
                            <label for="laporan_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Laporan Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="laporan_kegiatan" id="laporan_kegiatan" rows="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Jelaskan secara detail pelaksanaan kegiatan, hasil yang dicapai, dan hal-hal penting lainnya..."
                                required>{{ old('laporan_kegiatan') }}</textarea>
                            @error('laporan_kegiatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimal 100 karakter, jelaskan secara lengkap pelaksanaan kegiatan</p>
                        </div>

                        <!-- Realisasi Anggaran -->
                        <div class="mb-6">
                            <label for="realisasi_anggaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Realisasi Anggaran (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                <input type="number" name="realisasi_anggaran" id="realisasi_anggaran" step="0.01" min="0"
                                    class="mt-1 block w-full pl-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ old('realisasi_anggaran') }}" required>
                            </div>
                            @error('realisasi_anggaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Anggaran yang disetujui: Rp {{ number_format($activity->proposal->anggaran, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Kendala -->
                        <div class="mb-6">
                            <label for="kendala" class="block text-sm font-medium text-gray-700 mb-2">
                                Kendala yang Dihadapi
                            </label>
                            <textarea name="kendala" id="kendala" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Jelaskan kendala atau hambatan yang dihadapi selama pelaksanaan kegiatan (jika ada)...">{{ old('kendala') }}</textarea>
                            @error('kendala')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Solusi -->
                        <div class="mb-6">
                            <label for="solusi" class="block text-sm font-medium text-gray-700 mb-2">
                                Solusi yang Diterapkan
                            </label>
                            <textarea name="solusi" id="solusi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Jelaskan solusi atau langkah yang diambil untuk mengatasi kendala (jika ada)...">{{ old('solusi') }}</textarea>
                            @error('solusi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File LPJ -->
                        <div class="mb-6">
                            <label for="file_lpj" class="block text-sm font-medium text-gray-700 mb-2">
                                File LPJ Lengkap (PDF) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="file_lpj" id="file_lpj" accept=".pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                required>
                            @error('file_lpj')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Upload LPJ lengkap dalam format PDF (Maksimal 5MB). Dokumen harus mencakup:
                            </p>
                            <ul class="mt-2 text-xs text-gray-500 list-disc list-inside space-y-1">
                                <li>Halaman judul dan pengesahan</li>
                                <li>Laporan lengkap pelaksanaan kegiatan</li>
                                <li>Rincian penggunaan anggaran</li>
                                <li>Dokumentasi foto kegiatan</li>
                                <li>Daftar hadir peserta (jika ada)</li>
                            </ul>
                        </div>

                        <!-- Info Box -->
                        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-yellow-900 mb-1">Perhatian</h4>
                                    <ul class="text-xs text-yellow-700 space-y-1">
                                        <li>• Pastikan semua data yang diisi sudah benar dan akurat</li>
                                        <li>• LPJ yang sudah diajukan tidak dapat diedit, hanya dapat direvisi jika ditolak</li>
                                        <li>• Proses verifikasi LPJ akan dilakukan oleh Admin Kemahasiswaan</li>
                                        <li>• Simpan salinan dokumen LPJ untuk arsip organisasi Anda</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('activities.show', $activity) }}" 
                                class="inline-flex items-center px-6 py-3 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Ajukan LPJ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>