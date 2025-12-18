<!-- resources/views/reports/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan & Statistik
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Generate Report Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Generate Laporan
                    </h3>

                    <form action="{{ route('reports.generate') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Report Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Laporan <span class="text-red-500">*</span>
                                </label>
                                <select name="report_type" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih Jenis Laporan</option>
                                    <option value="proposal">Laporan Proposal Kegiatan</option>
                                    <option value="activity">Laporan Pelaksanaan Kegiatan</option>
                                    <option value="lpj">Laporan LPJ</option>
                                    <option value="summary">Laporan Ringkasan</option>
                                </select>
                                @error('report_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ormawa Filter (Admin/BEM Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Organisasi (Opsional)
                                </label>
                                <select name="ormawa_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Organisasi</option>
                                    @foreach(\App\Models\User::where('role', 'ormawa')->get() as $ormawa)
                                        <option value="{{ $ormawa->id }}">{{ $ormawa->ormawa_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start_date" required
                                    value="{{ date('Y-m-01') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="end_date" required
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download PDF
                            </button>
                            <button type="button" onclick="resetForm()"
                                class="inline-flex items-center px-6 py-3 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Reports -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Laporan Bulan Ini</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Proposal::whereMonth('created_at', date('m'))->count() }}</p>
                        <a href="#" class="mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Generate →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Kegiatan Aktif</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Activity::where('status', 'ongoing')->count() }}</p>
                        <a href="#" class="mt-4 text-sm text-green-600 hover:text-green-800 font-medium">
                            Lihat Detail →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600 mb-2">LPJ Pending</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Lpj::where('status', 'pending')->count() }}</p>
                        <a href="#" class="mt-4 text-sm text-purple-600 hover:text-purple-800 font-medium">
                            Review →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Total Arsip</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Activity::where('status', 'completed')->count() }}</p>
                        <a href="{{ route('archives.index') }}" class="mt-4 text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                            Lihat Arsip →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Report Templates -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Template Laporan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Proposal Report -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-50 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900">Laporan Proposal</h4>
                                    <p class="text-sm text-gray-600 mt-1">Rekap semua proposal yang diajukan dengan status approval</p>
                                    <ul class="mt-2 text-xs text-gray-500 space-y-1">
                                        <li>• Daftar proposal per periode</li>
                                        <li>• Status approval</li>
                                        <li>• Total anggaran</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Report -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-green-50 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900">Laporan Kegiatan</h4>
                                    <p class="text-sm text-gray-600 mt-1">Detail pelaksanaan kegiatan dengan dokumentasi lengkap</p>
                                    <ul class="mt-2 text-xs text-gray-500 space-y-1">
                                        <li>• Status pelaksanaan</li>
                                        <li>• Jumlah peserta</li>
                                        <li>• Dokumentasi kegiatan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- LPJ Report -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-500 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-purple-50 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900">Laporan LPJ</h4>
                                    <p class="text-sm text-gray-600 mt-1">Rekap LPJ dengan realisasi anggaran</p>
                                    <ul class="mt-2 text-xs text-gray-500 space-y-1">
                                        <li>• Status verifikasi LPJ</li>
                                        <li>• Realisasi vs anggaran</li>
                                        <li>• Kendala & solusi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Report -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-yellow-500 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-yellow-50 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900">Laporan Ringkasan</h4>
                                    <p class="text-sm text-gray-600 mt-1">Summary lengkap semua kegiatan ORMAWA</p>
                                    <ul class="mt-2 text-xs text-gray-500 space-y-1">
                                        <li>• Grafik & statistik</li>
                                        <li>• Perbandingan per organisasi</li>
                                        <li>• Tren kegiatan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function resetForm() {
            document.querySelector('form').reset();
        }
    </script>
    @endpush
</x-app-layout>