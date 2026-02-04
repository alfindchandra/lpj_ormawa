
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Proposal Kegiatan
            </h2>
            @if(Auth::user()->role === 'ormawa')
                <a href="{{ route('proposals.create') }}" 
                    class="inline-flex items-center mx-4 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Proposal Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter & Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                            <input type="text" id="searchInput" placeholder="Cari nama kegiatan atau kode..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                            <select id="statusFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved_bem">Disetujui BEM</option>
                                <option value="approved_admin">Disetujui Admin</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        @if(Auth::user()->role !== 'ormawa')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Organisasi</label>
                                <select id="ormawaFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Organisasi</option>
                                    @foreach($proposals->unique('user.ormawa_name') as $p)
                                        <option value="{{ $p->user->ormawa_name }}">{{ $p->user->ormawa_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Proposals Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($proposals->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada proposal</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan mengajukan proposal kegiatan baru.</p>
                            @if(Auth::user()->role === 'ormawa')
                                <div class="mt-6">
                                    <a href="{{ route('proposals.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Ajukan Proposal
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="proposalsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kode
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Kegiatan
                                        </th>
                                        @if(Auth::user()->role !== 'ormawa')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Organisasi
                                            </th>
                                        @endif
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Anggaran
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($proposals as $proposal)
                                        <tr class="hover:bg-gray-50" data-status="{{ $proposal->status }}" data-ormawa="{{ $proposal->user->ormawa_name }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $proposal->kode_proposal }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="font-medium">{{ Str::limit($proposal->nama_kegiatan, 50) }}</div>
                                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($proposal->deskripsi, 80) }}</div>
                                            </td>
                                            @if(Auth::user()->role !== 'ormawa')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                            <span class="text-xs font-medium text-blue-600">
                                                                {{ substr($proposal->user->ormawa_name, 0, 2) }}
                                                            </span>
                                                        </div>
                                                        <div class="ml-3">
                                                            {{ $proposal->user->ormawa_name }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $proposal->tanggal_mulai->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusConfig = [
                                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'],
                                                        'approved_bem' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Approved BEM'],
                                                        'approved_admin' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Approved'],
                                                        'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Rejected']
                                                    ];
                                                    $status = $statusConfig[$proposal->status];
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                                    {{ $status['label'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('proposals.show', $proposal) }}" 
                                                    class="text-blue-600 hover:text-blue-900">
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
        // Simple client-side filtering
        document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
        document.getElementById('statusFilter')?.addEventListener('change', filterTable);
        document.getElementById('ormawaFilter')?.addEventListener('change', filterTable);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter')?.value || '';
            const ormawaFilter = document.getElementById('ormawaFilter')?.value || '';
            const rows = document.querySelectorAll('#proposalsTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const status = row.getAttribute('data-status');
                const ormawa = row.getAttribute('data-ormawa');
                
                const matchesSearch = text.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesOrmawa = !ormawaFilter || ormawa === ormawaFilter;

                row.style.display = (matchesSearch && matchesStatus && matchesOrmawa) ? '' : 'none';
            });
        }
    </script>
    @endpush
</x-app-layout>