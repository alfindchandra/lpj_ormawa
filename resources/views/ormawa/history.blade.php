<!-- resources/views/ormawa/history.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Kegiatan {{ Auth::user()->ormawa_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <select id="yearFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Tahun</option>
                                @for($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="statusFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <select id="monthFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                            <input type="text" id="searchInput" placeholder="Nama kegiatan..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="space-y-6">
                @forelse($activities->groupBy(function($activity) {
                    return $activity->proposal->tanggal_mulai->format('Y');
                }) as $year => $yearActivities)
                    
                    <!-- Year Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg p-4">
                        <h3 class="text-xl font-bold">Tahun {{ $year }}</h3>
                        <p class="text-sm text-blue-100">{{ $yearActivities->count() }} kegiatan</p>
                    </div>

                    <!-- Activities in Year -->
                    <div class="space-y-4" data-year="{{ $year }}">
                        @foreach($yearActivities as $activity)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden"
                                 data-month="{{ $activity->proposal->tanggal_mulai->format('m') }}"
                                 data-status="{{ $activity->status }}">
                                <div class="p-6">
                                    <div class="flex items-start">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            @if($activity->status === 'completed')
                                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4 class="text-lg font-semibold text-gray-900">
                                                        {{ $activity->proposal->nama_kegiatan }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        {{ $activity->proposal->kode_proposal }}
                                                    </p>
                                                </div>
                                                @if($activity->status === 'completed')
                                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                                        Dibatalkan
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Tanggal:</span>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $activity->proposal->tanggal_mulai->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Tempat:</span>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $activity->proposal->tempat }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Peserta:</span>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $activity->jumlah_peserta ?? '-' }} orang
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Anggaran:</span>
                                                    <p class="font-medium text-gray-900">
                                                        Rp {{ number_format($activity->proposal->anggaran, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>

                                            @if($activity->lpj)
                                                <div class="mt-3 flex items-center text-sm">
                                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-gray-600">LPJ: </span>
                                                    @if($activity->lpj->status === 'approved')
                                                        <span class="ml-1 text-green-600 font-medium">Disetujui</span>
                                                    @elseif($activity->lpj->status === 'rejected')
                                                        <span class="ml-1 text-red-600 font-medium">Ditolak</span>
                                                    @else
                                                        <span class="ml-1 text-yellow-600 font-medium">Pending</span>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="mt-4 flex items-center gap-3">
                                                <a href="{{ route('activities.show', $activity) }}" 
                                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat Detail
                                                </a>
                                                
                                                @if($activity->documentations->count() > 0)
                                                    <span class="text-gray-400">•</span>
                                                    <span class="text-sm text-gray-600">
                                                        {{ $activity->documentations->count() }} dokumentasi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @empty
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada riwayat kegiatan</h3>
                        <p class="mt-2 text-sm text-gray-500">Riwayat kegiatan akan muncul setelah kegiatan selesai atau dibatalkan.</p>
                        <a href="{{ route('proposals.create') }}" 
                           class="mt-6 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Buat Kegiatan Baru
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('yearFilter')?.addEventListener('change', filterHistory);
        document.getElementById('statusFilter')?.addEventListener('change', filterHistory);
        document.getElementById('monthFilter')?.addEventListener('change', filterHistory);
        document.getElementById('searchInput')?.addEventListener('keyup', filterHistory);

        function filterHistory() {
            const yearFilter = document.getElementById('yearFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const monthFilter = document.getElementById('monthFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

            document.querySelectorAll('[data-year]').forEach(yearSection => {
                let hasVisibleItems = false;
                const sectionYear = yearSection.getAttribute('data-year');
                
                // Hide entire year section if year doesn't match
                if (yearFilter && sectionYear !== yearFilter) {
                    yearSection.previousElementSibling.style.display = 'none';
                    yearSection.style.display = 'none';
                    return;
                }

                yearSection.querySelectorAll('[data-status]').forEach(item => {
                    const status = item.getAttribute('data-status');
                    const month = item.getAttribute('data-month');
                    const text = item.textContent.toLowerCase();

                    const matchesStatus = !statusFilter || status === statusFilter;
                    const matchesMonth = !monthFilter || month === monthFilter;
                    const matchesSearch = !searchTerm || text.includes(searchTerm);

                    if (matchesStatus && matchesMonth && matchesSearch) {
                        item.style.display = '';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide year header based on visible items
                if (hasVisibleItems) {
                    yearSection.previousElementSibling.style.display = '';
                    yearSection.style.display = '';
                } else {
                    yearSection.previousElementSibling.style.display = 'none';
                    yearSection.style.display = 'none';
                }
            });
        }
    </script>
    @endpush
</x-app-layout>