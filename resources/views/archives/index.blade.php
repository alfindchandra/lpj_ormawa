<x-app-layout>
    @section('title', 'Arsip Kegiatan')

    {{-- Header Utama --}}
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between py-2">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-3">
                    {{ __('Arsip Kegiatan Ormawa') }}
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- Main Container Wrapper --}}
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen space-y-8 antialiased bg-slate-50/50">
        
        {{-- Flash Notification Alerts --}}
        @if(session('success'))
        <div class="bg-emerald-50/60 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-start gap-3 shadow-sm backdrop-blur-sm animate-fade-in">
            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <span class="text-sm font-semibold block">Berkas Diperbarui</span>
                <span class="text-xs text-emerald-700/90 mt-0.5 block">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-rose-50/60 border border-rose-200 text-rose-800 p-4 rounded-xl flex items-start gap-3 shadow-sm backdrop-blur-sm">
            <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <span class="text-sm font-semibold block">Gagal Memproses</span>
                <span class="text-xs text-rose-700/90 mt-0.5 block">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        {{-- Banner Periode Aktif Utama --}}
        @if($activePeriod)
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white overflow-hidden shadow-md rounded-2xl relative border border-slate-800">
            <div class="absolute -right-10 -bottom-10 opacity-10 text-indigo-500 pointer-events-none">
                <svg class="w-56 h-56" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.47 3.07a.75.75 0 011.06 0l3 3a.75.75 0 11-1.06 1.06l-1.72-1.72V15a.75.75 0 01-1.5 0V5.41L9.53 7.13a.75.75 0 01-1.06-1.06l3-3zM3.47 15.53a.75.75 0 011.06 0L7 18.06V11.25a.75.75 0 011.5 0v6.81l2.47-2.47a.75.75 0 111.06 1.06l-3.75 3.75a.75.75 0 01-1.06 0l-3.75-3.75a.75.75 0 010-1.06zM15.75 11.25a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H16.5v6.81l2.47-2.47a.75.75 0 111.06 1.06l-3.75 3.75a.75.75 0 01-1.06 0l-3.75-3.75a.75.75 0 111.06-1.06l2.47 2.47V11.25z"/>
                </svg>
            </div>
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-500/10 border border-indigo-400/20 text-[10px] font-extrabold tracking-widest uppercase rounded-full shadow-sm backdrop-blur-md text-indigo-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        Periode Berjalan
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent">{{ $activePeriod->nama_periode }}</h3>
                    <p class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Masa Kepengurusan Hukum: <strong class="text-slate-200 font-semibold">{{ $activePeriod->tahun_mulai }}</strong> s/d <strong class="text-slate-200 font-semibold">{{ $activePeriod->tahun_selesai }}</strong></span>
                    </p>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-2xl shadow-lg shadow-indigo-500/20 ring-4 ring-white/10 shrink-0 self-end sm:self-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
        </div>
        @endif

        {{-- Main Grid Content Document Timeline --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-5 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Periode Kepengurusan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Akses kluster arsip proposal, proposal keuangan, dokumen legalitas, dan rekapan instansi.</p>
                    </div>
                    @if(in_array(Auth::user()->role, ['admin', 'bem']))
                    <button onclick="openAddPeriodModal()"
                        class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm transition-all duration-150 uppercase tracking-wider">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Tambah Periode
                    </button>
                    @endif
                </div>

                @if($periods->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-slate-200 max-w-sm mx-auto">
                    <div class="w-12 h-12 bg-slate-50 border border-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 7.5m16.5 0V6a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6v1.5m15 0h-15M9 10.5h6" /></svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">Gudang Arsip Kosong</h4>
                    <p class="mt-1 text-xs text-slate-400 px-4">Silakan definisikan parameter data kluster tahun kepengurusan baru di atas.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($periods as $period)
                    <div class="group bg-white border border-slate-200 rounded-2xl flex flex-col justify-between overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:border-slate-300/80 {{ $period->is_active ? 'ring-2 ring-indigo-600/10 border-indigo-500/80 bg-indigo-50/5' : '' }}">
                        
                        <div class="p-5 relative">
                            @if($period->is_active)
                            <span class="absolute top-5 right-5 bg-indigo-600/10 text-indigo-700 border border-indigo-200/50 text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full tracking-wider shadow-sm">Aktif</span>
                            @endif

                            <div class="flex items-start space-x-4">
                                <div class="p-3 rounded-xl shrink-0 transition-all duration-300 {{ $period->is_active ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'bg-slate-50 text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 border border-slate-100' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <div class="space-y-0.5 pr-10 truncate">
                                    <h4 class="text-base font-bold text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors truncate">{{ $period->nama_periode }}</h4>
                                    <span class="text-[11px] text-slate-500 font-semibold block">Tahun {{ $period->tahun_mulai }} &mdash; {{ $period->tahun_selesai }}</span>
                                </div>
                            </div>

                            @if(in_array(Auth::user()->role, ['admin', 'bem']))
                            <div class="flex items-center gap-1.5 mt-5 pt-3.5 border-t border-slate-100">
                                @if(!$period->is_active)
                                <form action="{{ route('periods.toggle', $period) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 text-[11px] font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:border-slate-400 hover:text-slate-800 shadow-sm transition">
                                        Set Aktif
                                    </button>
                                </form>
                                @endif

                                <button onclick="openEditPeriodModal('{{ $period->id }}', '{{ $period->nama_periode }}', '{{ $period->tahun_mulai }}', '{{ $period->tahun_selesai }}')" 
                                    class="px-2.5 py-1 text-[11px] font-bold text-blue-600 bg-white border border-slate-200 hover:border-blue-500 hover:bg-blue-50 rounded-lg shadow-sm transition">
                                    Edit
                                </button>

                                @if(!$period->is_active)
                                <form action="{{ route('periods.destroy', $period) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen entitas rentang periode ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 text-[11px] font-bold text-rose-600 bg-white border border-slate-200 hover:border-rose-500 hover:bg-rose-50 rounded-lg shadow-sm transition">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>

                        {{-- Card Menu Action Hub --}}
                        <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-slate-100/50 transition-colors">
                            <a href="{{ route('archives.show', $period) }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800 gap-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Detail Arsip
                            </a>
                            <a href="{{ route('archives.export', $period) }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-slate-800 gap-1 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                Rekap PDF
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL DIALOG: TAMBAH PERIODE BARU --}}
    <div id="addPeriodModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 z-50 animate-fade-in">
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 transform transition-all">
            <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <div class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> 
                    </div>
                    <span>Tambah Periode Baru</span>
                </h3>
                <button onclick="closeAddPeriodModal()" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form action="{{ route('periods.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Identitas Periode</label>
                    <input type="text" name="nama_periode" placeholder="Maju Bersama 2026/2027" required 
                        class="w-full rounded-xl border-slate-200 shadow-sm text-xs font-medium px-3.5 py-2.5 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 bg-slate-50/50 transition outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" min="2020" max="2100" placeholder="2026" required 
                            class="w-full rounded-xl border-slate-200 shadow-sm text-xs font-semibold px-3.5 py-2.5 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 bg-slate-50/50 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" min="2020" max="2100" placeholder="2027" required 
                            class="w-full rounded-xl border-slate-200 shadow-sm text-xs font-semibold px-3.5 py-2.5 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 bg-slate-50/50 transition outline-none">
                    </div>
                </div>
                <div class="pt-2">
                    <label class="inline-flex items-center cursor-pointer select-none gap-2.5 group">
                        <input type="checkbox" name="is_active" value="1" class="rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500/20 h-4 w-4 shadow-sm transition">
                        <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">Jadikan sebagai parameter utama aktif</span>
                    </label>
                </div>
                <div class="flex gap-2.5 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeAddPeriodModal()" class="flex-1 px-4 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition shadow-indigo-500/10">Simpan Parameter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DIALOG: UBAH DATA PERIODE --}}
    <div id="editPeriodModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 z-50 animate-fade-in">
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> 
                    </div>
                    <span>Ubah Data Kriteria Periode</span>
                </h3>
                <button onclick="closeEditPeriodModal()" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form id="editPeriodForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Identitas Periode</label>
                    <input type="text" id="edit_nama_periode" name="nama_periode" required 
                        class="w-full rounded-xl border-slate-200 shadow-sm text-xs font-medium px-3.5 py-2.5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-slate-50/50 transition outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Mulai</label>
                        <input type="number" id="edit_tahun_mulai" name="tahun_mulai" min="2020" max="2100" required 
                            class="w-full rounded-xl border-slate-200 shadow-sm text-xs font-semibold px-3.5 py-2.5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-slate-50/50 transition outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Selesai</label>
                        <input type="number" id="edit_tahun_selesai" name="tahun_selesai" min="2020" max="2100" required 
                            class="w-full rounded-xl border-slate-200 shadow-sm text-xs font-semibold px-3.5 py-2.5 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-slate-50/50 transition outline-none">
                    </div>
                </div>
                <div class="flex gap-2.5 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeEditPeriodModal()" class="flex-1 px-4 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition shadow-blue-500/10">Perbarui Rekaman</button>
                </div>
            </form>
        </div>
    </div>

    {{-- INTERACTION CONTROL SCRIPT --}}
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