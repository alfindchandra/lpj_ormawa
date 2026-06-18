<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Kegiatan Organisasi Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200" role="alert">
                    <span class="font-semibold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200" role="alert">
                    <span class="font-semibold">Gagal!</span> {{ session('error') }}
                </div>
            @endif

            @if($activePeriod)
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 overflow-hidden shadow-xl rounded-2xl transition duration-300 transform hover:scale-[1.01]">
                <div class="p-6 sm:p-8 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-3 py-1 bg-white/20 text-xs font-bold tracking-wider uppercase rounded-full">Periode Utama Aktif</span>
                        <h3 class="text-3xl font-black mt-2 tracking-tight">{{ $activePeriod->nama_periode }}</h3>
                        <p class="text-sm mt-1 text-indigo-100 font-medium">
                            Tahun Kepengurusan: {{ $activePeriod->tahun_mulai }} s/d {{ $activePeriod->tahun_selesai }}
                        </p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm self-end sm:self-center">
                        <svg class="h-10 w-10 text-yellow-300 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Daftar Periode Kepengurusan</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Kelola data rekapitulasi arsip berkas per tahun kepengurusan</p>
                        </div>
                        @if(in_array(Auth::user()->role, ['admin', 'bem']))
                        <button onclick="openAddPeriodModal()"
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-all duration-150">
                            <svg class="w-4 h-4 mr-2 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            Tambah Periode
                        </button>
                        @endif
                    </div>

                    @if($periods->isEmpty())
                    <div class="text-center py-16 border-2 border-dashed border-gray-100 rounded-2xl">
                        <svg class="mx-auto h-14 w-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <h3 class="mt-4 text-base font-bold text-gray-900">Belum ada linimasa periode</h3>
                        <p class="mt-1 text-sm text-gray-400 max-w-xs mx-auto">Silakan tambahkan data periode kepengurusan perdana melalui tombol di atas.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($periods as $period)
                        <div class="group relative bg-white border rounded-2xl transition-all duration-300 flex flex-col justify-between overflow-hidden {{ $period->is_active ? 'border-indigo-500 ring-2 ring-indigo-500/10 bg-indigo-50/10' : 'border-gray-200 hover:shadow-xl hover:border-gray-300' }}">
                            
                            @if($period->is_active)
                            <span class="absolute top-4 right-4 bg-indigo-600 text-[10px] text-white font-extrabold uppercase px-2.5 py-1 rounded-full shadow-sm tracking-wide">Aktif</span>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="p-3 rounded-xl {{ $period->is_active ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'bg-gray-50 text-gray-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors' }}">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $period->nama_periode }}</h4>
                                        <p class="text-xs text-gray-500 font-medium">Tahun {{ $period->tahun_mulai }} - {{ $period->tahun_selesai }}</p>
                                    </div>
                                </div>

                                @if(in_array(Auth::user()->role, ['admin', 'bem']))
                                <div class="flex items-center gap-2 pt-3 mb-4 border-t border-dashed border-gray-100">
                                    @if(!$period->is_active)
                                    <form action="{{ route('periods.toggle', $period) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1.5 text-xs font-bold text-gray-700 bg-gray-50 border rounded-lg hover:bg-yellow-50 hover:text-yellow-600 hover:border-yellow-200 transition-all duration-150 shadow-sm">
                                            Set Aktif
                                        </button>
                                    </form>
                                    @endif

                                    <button onclick="openEditPeriodModal('{{ $period->id }}', '{{ $period->nama_periode }}', '{{ $period->tahun_mulai }}', '{{ $period->tahun_selesai }}')" 
                                        class="px-2.5 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 transition-all duration-150 shadow-sm">
                                        Edit
                                    </button>

                                    @if(!$period->is_active)
                                    <form action="{{ route('periods.destroy', $period) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 text-xs font-bold text-red-600 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-all duration-150 shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endif
                            </div>

                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between group-hover:bg-gray-100/50 transition-colors">
                                <a href="{{ route('archives.show', $period) }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    Detail Arsip
                                </a>
                                <a href="{{ route('archives.export', $period) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-gray-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
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
    </div>

    <div id="addPeriodModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50 animate-fade-in">
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 transform transition-all">
            <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center"><svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg> Tambah Periode Baru</h3>
            
            <form action="{{ route('periods.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Periode</label>
                    <input type="text" name="nama_periode" placeholder="Contoh: Periode 2024/2025" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 px-4 py-2.5">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" min="2020" max="2100" placeholder="2024" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" min="2020" max="2100" placeholder="2025" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 px-4 py-2.5">
                    </div>
                </div>
                <div class="pt-2">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500/20 h-4 w-4">
                        <span class="ml-2.5 text-sm text-gray-600 font-medium">Jadikan sebagai periode utama aktif</span>
                    </label>
                </div>
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddPeriodModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-colors">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editPeriodModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center"><svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Ubah Data Periode</h3>
            
            <form id="editPeriodForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Periode</label>
                    <input type="text" id="edit_nama_periode" name="nama_periode" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 px-4 py-2.5">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Mulai</label>
                        <input type="number" id="edit_tahun_mulai" name="tahun_mulai" min="2020" max="2100" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Selesai</label>
                        <input type="number" id="edit_tahun_selesai" name="tahun_selesai" min="2020" max="2100" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 px-4 py-2.5">
                    </div>
                </div>
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditPeriodModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 shadow-md shadow-blue-100 transition-colors">Perbarui</button>
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

    // Menggunakan fungsi penutup yang seragam
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

    // Menggunakan fungsi penutup yang seragam
    function closeEditPeriodModal() {
        const modal = document.getElementById('editPeriodModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    </script>
</x-app-layout>