<x-app-layout>
    @section('title', 'Arsip Kegiatan')

    @push('styles')
    <style>
        .period-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .period-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }
    </style>
    @endpush

    {{-- Pemisahan Slot Header Utama --}}
    <x-slot name="header">
        <div class="flex items-center justify-between w-full py-1">
            <h2 class="font-bold text-xl sm:text-2xl text-gray-800 tracking-tight flex items-center gap-2">
                <span>📂</span> {{ __('Arsip Kegiatan Organisasi Mahasiswa') }}
            </h2>
        </div>
    </x-slot>

    {{-- Main Container Wrapper --}}
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen space-y-6">
        
        {{-- Flash Messages Standar --}}
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
        @endif

        {{-- Banner Periode Aktif --}}
        @if($activePeriod)
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white overflow-hidden shadow-sm rounded-xl relative">
            <div class="p-6 sm:p-7 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="px-2.5 py-0.5 bg-white/20 border border-white/10 text-[10px] font-bold tracking-wider uppercase rounded shadow-sm backdrop-blur-sm">
                        Periode Utama Aktif
                    </span>
                    <h3 class="text-2xl font-extrabold mt-2 tracking-tight">{{ $activePeriod->nama_periode }}</h3>
                    <p class="text-xs mt-1 text-blue-100/90 font-medium flex items-center gap-1">
                        <span>🗓️</span> Tahun Kepengurusan: {{ $activePeriod->tahun_mulai }} s/d {{ $activePeriod->tahun_selesai }}
                    </p>
                </div>
                <div class="bg-white/10 p-3.5 rounded-xl backdrop-blur-sm self-end sm:self-center border border-white/10">
                    <svg class="h-6 w-6 text-yellow-300 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>
        </div>
        @endif

        {{-- Konten Utama Dokumen Linimasa --}}
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Daftar Periode Kepengurusan</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Kelola data rekapitulasi arsip berkas per tahun kepengurusan</p>
                    </div>
                    @if(in_array(Auth::user()->role, ['admin', 'bem']))
                    <button onclick="openAddPeriodModal()"
                        class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs px-4 py-2 rounded-lg shadow-sm transition duration-150 uppercase tracking-wider">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Tambah Periode
                    </button>
                    @endif
                </div>

                @if($periods->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <h4 class="text-sm font-bold text-gray-900">Belum ada linimasa periode</h4>
                    <p class="mt-1 text-xs text-gray-400 max-w-xs mx-auto">Silakan tambahkan data periode kepengurusan perdana melalui tombol di atas.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($periods as $period)
                    <div class="period-card group relative bg-white border rounded-xl flex flex-col justify-between overflow-hidden {{ $period->is_active ? 'border-indigo-500 ring-2 ring-indigo-500/10 bg-indigo-50/5' : 'border-gray-200 hover:border-gray-300' }}">
                        
                        @if($period->is_active)
                        <span class="absolute top-4 right-4 bg-indigo-600 text-[9px] text-white font-bold uppercase px-2 py-0.5 rounded shadow-sm tracking-wide">Aktif</span>
                        @endif

                        <div class="p-5">
                            <div class="flex items-center space-x-3.5 mb-4">
                                <div class="p-2.5 rounded-lg shrink-0 {{ $period->is_active ? 'bg-indigo-600 text-white' : 'bg-gray-50 text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-gray-900 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $period->nama_periode }}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium">Tahun {{ $period->tahun_mulai }} - {{ $period->tahun_selesai }}</p>
                                </div>
                            </div>

                            @if(in_array(Auth::user()->role, ['admin', 'bem']))
                            <div class="flex items-center gap-1.5 pt-3 border-t border-dashed border-gray-100">
                                @if(!$period->is_active)
                                <form action="{{ route('periods.toggle', $period) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-2 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:border-amber-500 hover:text-amber-600 shadow-sm transition">
                                        Set Aktif
                                    </button>
                                </form>
                                @endif

                                <button onclick="openEditPeriodModal('{{ $period->id }}', '{{ $period->nama_periode }}', '{{ $period->tahun_mulai }}', '{{ $period->tahun_selesai }}')" 
                                    class="px-2 py-1 text-xs font-medium text-blue-600 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 rounded-md shadow-sm transition">
                                    Edit
                                </button>

                                @if(!$period->is_active)
                                <form action="{{ route('periods.destroy', $period) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-xs font-medium text-rose-600 bg-white border border-gray-300 hover:border-rose-500 hover:bg-rose-50 rounded-md shadow-sm transition">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between group-hover:bg-gray-100/50 transition-colors">
                            <a href="{{ route('archives.show', $period) }}" class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-800 gap-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Detail Arsip
                            </a>
                            <a href="{{ route('archives.export', $period) }}" class="inline-flex items-center text-xs font-medium text-gray-500 hover:text-gray-800 gap-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH PERIODE --}}
    <div id="addPeriodModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center p-4 z-50">
        <div class="relative bg-white rounded-xl max-w-md w-full p-5 shadow-xl border border-gray-200 transform transition-all">
            <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-1.5 text-indigo-600 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> 
                Tambah Periode Baru
            </h3>
            
            <form action="{{ route('periods.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Periode</label>
                    <input type="text" name="nama_periode" placeholder="Contoh: Periode 2024/2025" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm px-3 py-2 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" min="2020" max="2100" placeholder="2024" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm px-3 py-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" min="2020" max="2100" placeholder="2025" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm px-3 py-2 outline-none">
                    </div>
                </div>
                <div class="pt-1">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                        <span class="ml-2 text-xs font-medium text-gray-600">Jadikan sebagai periode utama aktif</span>
                    </label>
                </div>
                <div class="flex gap-2 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeAddPeriodModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 font-medium text-xs rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white font-medium text-xs rounded-lg hover:bg-indigo-700 shadow-sm transition">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UBAH PERIODE --}}
    <div id="editPeriodModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center p-4 z-50">
        <div class="relative bg-white rounded-xl max-w-md w-full p-5 shadow-xl border border-gray-200">
            <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-1.5 text-blue-600 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> 
                Ubah Data Periode
            </h3>
            
            <form id="editPeriodForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Periode</label>
                    <input type="text" id="edit_nama_periode" name="nama_periode" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm px-3 py-2 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tahun Mulai</label>
                        <input type="number" id="edit_tahun_mulai" name="tahun_mulai" min="2020" max="2100" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm px-3 py-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tahun Selesai</label>
                        <input type="number" id="edit_tahun_selesai" name="tahun_selesai" min="2020" max="2100" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm px-3 py-2 outline-none">
                    </div>
                </div>
                <div class="flex gap-2 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeEditPeriodModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 font-medium text-xs rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white font-medium text-xs rounded-lg hover:bg-blue-700 shadow-sm transition">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openAddPeriodModal() {
        const modal = document.getElementById('addPeriodModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAddPeriodModal() {
        const modal = document.getElementById('addPeriodModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openEditPeriodModal(id, name, startYear, endYear) {
        const modal = document.getElementById('editPeriodModal');
        
        document.getElementById('edit_nama_periode').value = name;
        document.getElementById('edit_tahun_mulai').value = startYear;
        document.getElementById('edit_tahun_selesai').value = endYear;
        
        document.getElementById('editPeriodForm').action = `/periods/${id}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditPeriodModal() {
        const modal = document.getElementById('editPeriodModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    </script>
</x-app-layout>