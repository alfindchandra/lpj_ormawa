<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Proposal Kegiatan
            </h2>
            @if(in_array(Auth::user()->role, ['ukm', 'hmp', 'bem', 'ormawa']))
            <a href="{{ route('proposals.create') }}"
                class="inline-flex items-center px-4 py-2 mr-4 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150 ease-in-out">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajukan Proposal Baru
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Filter & Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 {{ in_array(Auth::user()->role, ['ukm', 'hmp', 'ormawa']) ? 'md:grid-cols-2' : 'md:grid-cols-3' }} gap-4">
                        
                        {{-- Input Cari Kegiatan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                            <input type="text" id="searchInput" placeholder="Cari nama kegiatan atau kode..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Filter Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                            <select id="statusFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved_admin">Disetujui Admin</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>

                        {{-- Filter Organisasi (Hanya untuk non-UKM dan non-HMP) --}}
                        @if(Auth::user()->role !== 'ukm' && Auth::user()->role !== 'ormawa')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Organisasi</label>
                            <select id="ormawaFilter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Organisasi</option>
                                @foreach($proposals->unique('user.ormawa_name') as $p)
                                {{-- Pastikan relasi user tidak null sebelum memanggil ormawa_name --}}
                                @if($p->user)
                                <option value="{{ $p->user->ormawa_name }}">{{ $p->user->ormawa_name }}</option>
                                @endif
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada proposal</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan mengajukan proposal kegiatan baru.</p>
            @if(Auth::user()->role === 'ormawa')
            <div class="mt-6">
                <a href="{{ route('proposals.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajukan Proposal
                </a>
            </div>
            @endif
        </div>
        @else
        <div class="overflow-x-auto w-full border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200" id="proposalsTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                        @if(Auth::user()->role !== 'hmp' && Auth::user()->role !== 'ormawa')
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisasi</th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($proposals as $proposal)
                    <tr class="hover:bg-gray-50 transition duration-150 search-row" data-status="{{ $proposal->status }}" data-ormawa="{{ $proposal->user->ormawa_name }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 search-code">
                            {{ $proposal->kode_proposal }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 search-title">
                            <div class="font-medium class="line-clamp-1" title="{{ $proposal->nama_kegiatan }}">{{ Str::limit($proposal->nama_kegiatan, 50) }}</div>
                            <div class="text-xs text-gray-500 mt-1 class="line-clamp-2" title="{{ $proposal->deskripsi }}">{{ Str::limit($proposal->deskripsi, 80) }}</div>
                        </td>
                        @if(Auth::user()->role !== 'hmp' && Auth::user()->role !== 'ukm')
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-semibold text-blue-600 uppercase">
                                        {{ substr($proposal->user->ormawa_name, 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-3 font-medium text-gray-900">
                                    {{ $proposal->user->ormawa_name }}
                                </div>
                            </div>
                        </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $proposal->tanggal_mulai ? $proposal->tanggal_mulai->format('d/m/Y') : '-' }}</span>
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
                            $status = $statusConfig[$proposal->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Unknown'];
                            @endphp
                            <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('proposals.show', $proposal) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-150 inline-flex items-center justify-center p-1 rounded hover:bg-gray-100" 
                                   title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                @if(Auth::user()->role === 'bem' && $proposal->status === 'pending')
                                <form action="{{ route('proposals.destroy', $proposal) }}" method="POST"
                                      class="inline-flex items-center" 
                                      onsubmit="return confirm('Yakin ingin menghapus proposal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors duration-150 inline-flex items-center justify-center p-1 rounded hover:bg-gray-100" 
                                            title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const ormawaFilter = document.getElementById('ormawaFilter');

        searchInput?.addEventListener('input', filterTable);
        statusFilter?.addEventListener('change', filterTable);
        ormawaFilter?.addEventListener('change', filterTable);

        function filterTable() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const selectedStatus = statusFilter ? statusFilter.value : '';
            const selectedOrmawa = ormawaFilter ? ormawaFilter.value : '';
            
            const rows = document.querySelectorAll('#proposalsTable tbody tr.search-row');

            rows.forEach(row => {
                // Hanya mengambil text dari kolom Kode dan kolom Nama/Deskripsi Kegiatan
                const codeText = row.querySelector('.search-code')?.textContent.toLowerCase() || '';
                const titleText = row.querySelector('.search-title')?.textContent.toLowerCase() || '';
                
                const statusAttr = row.getAttribute('data-status') || '';
                const ormawaAttr = row.getAttribute('data-ormawa') || '';

                const matchesSearch = codeText.includes(searchTerm) || titleText.includes(searchTerm);
                const matchesStatus = !selectedStatus || statusAttr === selectedStatus;
                const matchesOrmawa = !selectedOrmawa || ormawaAttr === selectedOrmawa;

                if (matchesSearch && matchesStatus && matchesOrmawa) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>