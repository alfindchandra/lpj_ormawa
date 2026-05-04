<!-- resources/views/activities/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitoring Kegiatan Organisasi Mahasiswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Filter & Pencarian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                            <input type="text" id="searchActivity" placeholder="Nama kegiatan..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Kegiatan</label>
                            <select id="statusFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="scheduled">Dijadwalkan</option>
                                <option value="ongoing">Sedang Berlangsung</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>

                        @if(Auth::user()->role !== 'ormawa')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Organisasi</label>
                            <select id="ormawaFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Organisasi</option>
                                @foreach($activities->unique('user.ormawa_name') as $act)
                                <option value="{{ $act->user->ormawa_name }}">{{ $act->user->ormawa_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status LPJ</label>
                            <select id="lpjFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua</option>
                                <option value="submitted">LPJ Sudah Dibuat</option>
                                <option value="not_submitted">Belum Ada LPJ</option>
                                <option value="approved">LPJ Disetujui</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Dijadwalkan</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $activities->where('status', 'scheduled')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Berlangsung</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $activities->where('status', 'ongoing')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Selesai</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $activities->where('status', 'completed')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Kegiatan</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $activities->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Kegiatan</h3>
                    </div>

                    @if($activities->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kegiatan</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada kegiatan yang terdaftar dalam sistem.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="activitiesTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Kegiatan
                                    </th>
                                    @if(Auth::user()->role !== 'ormawa')
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Organisasi
                                    </th>
                                    @endif
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Peserta
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        LPJ
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($activities as $activity)
                                <tr class="hover:bg-gray-50" data-status="{{ $activity->status }}"
                                    data-ormawa="{{ $activity->user->ormawa_name }}"
                                    data-lpj="{{ $activity->lpj ? 'submitted' : 'not_submitted' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $activity->proposal->nama_kegiatan }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $activity->proposal->kode_proposal }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @if(Auth::user()->role !== 'ormawa')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">
                                                    {{ substr($activity->user->ormawa_name, 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $activity->user->ormawa_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $activity->proposal->tanggal_mulai->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            s/d {{ $activity->proposal->tanggal_selesai->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            {{ $activity->jumlah_peserta ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                        $statusConfig = [
                                        'scheduled' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' =>
                                        'Dijadwalkan'],
                                        'ongoing' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' =>
                                        'Berlangsung'],
                                        'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' =>
                                        'Selesai'],
                                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' =>
                                        'Dibatalkan']
                                        ];
                                        $status = $statusConfig[$activity->status];
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($activity->lpj)
                                        @php
                                        $lpjStatusConfig = [
                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' =>
                                        'Pending'],
                                        'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' =>
                                        'Disetujui'],
                                        'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' =>
                                        'Ditolak']
                                        ];
                                        $lpjStatus = $lpjStatusConfig[$activity->lpj->status];
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $lpjStatus['bg'] }} {{ $lpjStatus['text'] }}">
                                            {{ $lpjStatus['label'] }}
                                        </span>
                                        @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Belum Dibuat
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('activities.show', $activity) }}"
                                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.getElementById('searchActivity')?.addEventListener('keyup', filterActivities);
    document.getElementById('statusFilter')?.addEventListener('change', filterActivities);
    document.getElementById('ormawaFilter')?.addEventListener('change', filterActivities);
    document.getElementById('lpjFilter')?.addEventListener('change', filterActivities);

    function filterActivities() {
        const searchTerm = document.getElementById('searchActivity').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter')?.value || '';
        const ormawaFilter = document.getElementById('ormawaFilter')?.value || '';
        const lpjFilter = document.getElementById('lpjFilter')?.value || '';
        const rows = document.querySelectorAll('#activitiesTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            const ormawa = row.getAttribute('data-ormawa');
            const lpj = row.getAttribute('data-lpj');

            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            const matchesOrmawa = !ormawaFilter || ormawa === ormawaFilter;

            let matchesLpj = true;
            if (lpjFilter === 'submitted') {
                matchesLpj = lpj === 'submitted';
            } else if (lpjFilter === 'not_submitted') {
                matchesLpj = lpj === 'not_submitted';
            } else if (lpjFilter === 'approved') {
                matchesLpj = text.includes('disetujui');
            }

            row.style.display = (matchesSearch && matchesStatus && matchesOrmawa && matchesLpj) ? '' : 'none';
        });
    }
    </script>
    @endpush
</x-app-layout>