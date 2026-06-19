<x-app-layout>
    @section('title', 'Pengurus Inti')

    {{-- Header Utama --}}
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between py-2">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-3">
                    
                    Pengurus Inti
                </h2>
            </div>
            
            @if(in_array(Auth::user()->role, ['admin', 'bem']))
            <a href="{{ route('kabinet.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200">
                <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengurus
            </a>
            @endif
        </div>
    </x-slot>

    {{-- Main Wrapper (Alpine.js State) --}}
    <div x-data="{ 
        tab: '{{ request()->get('tab', 'aktif') }}',
        changeTab(target) {
            this.tab = target;
            const url = new URL(window.location);
            url.searchParams.set('tab', target);
            window.history.pushState({}, '', url);
        }
    }" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen antialiased bg-slate-50/50" x-cloak>

        {{-- Flash Notification Alerts --}}
        @if(session('success'))
        <div class="mb-6 bg-emerald-50/60 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-start gap-3 shadow-sm backdrop-blur-sm animate-fade-in">
            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <span class="text-sm font-semibold block">Aksi Berhasil</span>
                <span class="text-xs text-emerald-700/90 mt-0.5 block">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="mb-6 bg-rose-50/60 border border-rose-200 text-rose-800 p-4 rounded-xl flex items-start gap-3 shadow-sm backdrop-blur-sm">
            <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <span class="text-sm font-semibold block">Terjadi Kesalahan</span>
                <span class="text-xs text-rose-700/90 mt-0.5 block">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        {{-- Segmented Navigation Bar --}}
        <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm mb-8 flex overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            <div class="flex space-x-1 w-full min-w-max">
                <button @click="changeTab('aktif')" 
                    :class="tab === 'aktif' ? 'bg-slate-900 text-white shadow-sm font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium'"
                    class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm transition-all duration-200 outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Kabinet Aktif</span>
                    <span :class="tab === 'aktif' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700'" class="text-xs px-2 py-0.5 rounded-md font-bold transition-colors">{{ $kabinetsAktif->count() }}</span>
                </button>

                <button @click="changeTab('riwayat')" 
                    :class="tab === 'riwayat' ? 'bg-slate-900 text-white shadow-sm font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium'"
                    class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm transition-all duration-200 outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Riwayat Kepengurusan</span>
                    <span :class="tab === 'riwayat' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700'" class="text-xs px-2 py-0.5 rounded-md font-bold transition-colors">{{ $kabinetsRiwayat->count() }}</span>
                </button>

                <button @click="changeTab('proposal')" 
                    :class="tab === 'proposal' ? 'bg-slate-900 text-white shadow-sm font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium'"
                    class="flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm transition-all duration-200 outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Proposal per Periode</span>
                </button>
            </div>
        </div>

        {{-- ===== TAB PANEL CONTENT ===== --}}
        
        {{-- TAB PANEL 1: KABINET AKTIF --}}
        <div x-show="tab === 'aktif'" class="space-y-12" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @if($kabinetsAktif->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm max-w-md mx-auto">
                    <div class="p-4 bg-slate-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-2.533-4.65l-1.447-.548A3.308 3.308 0 0115 10.276V7.5m-6 3.978V7.5M12 21.75a9.004 9.004 0 008.316-5.56H3.684A9.004 9.004 0 0012 21.75z"/>
                        </svg>
                    </div>
                    <h3 class="text-slate-800 font-bold text-base">Belum Ada Struktur Aktif</h3>
                    <p class="text-xs text-slate-500 mt-1 px-4">Seluruh data organisasi untuk periode berjalan saat ini kosong atau telah diarsipkan.</p>
                    @if(in_array(Auth::user()->role, ['admin','bem']))
                    <a href="{{ route('kabinet.create') }}" class="mt-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                        Buat Kabinet Pertama
                    </a>
                    @endif
                </div>
            @else
                @foreach(['bem' => ['BEM', 'bg-blue-600/10 text-blue-700 border-blue-200/60', 'from-blue-600 to-indigo-600', 'ring-blue-100'], 
                          'hmp' => ['HMP', 'bg-emerald-600/10 text-emerald-700 border-emerald-200/60', 'from-emerald-600 to-teal-600', 'ring-emerald-100'], 
                          'ukm' => ['UKM', 'bg-amber-600/10 text-amber-700 border-amber-200/60', 'from-amber-500 to-orange-600', 'ring-amber-100']] as $type => $meta)
                    
                    @php $group = $kabinetsAktif->where('ormawa_type', $type); @endphp
                    @if($group->isNotEmpty())
                    <div class="space-y-5">
                        {{-- Section Header --}}
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
                            <div class="w-2.5 h-6 rounded-md bg-gradient-to-b {{ $meta[2] }}"></div>
                            <h3 class="text-lg font-bold text-slate-800 tracking-tight">{{ $meta[0] }}</h3>
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full border {{ $meta[1] }} shadow-sm">{{ $group->count() }} Organisasi</span>
                        </div>
                        
                        {{-- Card Layout Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($group as $kabinet)
                            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1">
                                <div>
                                    {{-- Banner Card --}}
                                    <div class="p-5 bg-gradient-to-br {{ $meta[2] }} text-white relative">
                                        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 transition-transform duration-500">
                                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>

                                        <div class="flex items-start justify-between gap-3 relative z-10">
                                            <div>
                                                <h4 class="font-bold text-base leading-snug tracking-wide drop-shadow-sm">{{ $kabinet->ormawa_name }}</h4>
                                                @if($kabinet->nama_kabinet)
                                                <span class="text-[10px] font-medium text-white/95 bg-white/15 px-2 py-0.5 rounded-md mt-2 inline-flex items-center gap-1 backdrop-blur-md border border-white/10">
                                                    <span>💼</span> Kabinet: {{ $kabinet->nama_kabinet }}
                                                </span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] font-bold bg-black/15 px-2.5 py-1 rounded-full border border-white/10 backdrop-blur-md uppercase shrink-0 whitespace-nowrap">
                                                {{ $kabinet->period->nama_periode ?? '-' }}
                                            </span>
                                        </div>

                                        <div class="mt-5 text-[10px] text-white/80 flex items-center gap-1.5 relative z-10 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>Dilantik: {{ $kabinet->tanggal_dilantik->format('d M Y') }}</span>
                                        </div>
                                    </div>

                                    {{-- Struktur Pokok Mandat --}}
                                    <div class="p-5 space-y-3.5">
                                        {{-- Row Ketua --}}
                                        <div class="flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-100 ring-2 ring-transparent group-hover:bg-white group-hover:ring-slate-100/80 transition-all">
                                            <div class="w-8 h-8 rounded-lg bg-blue-600/10 text-blue-600 font-bold text-xs flex items-center justify-center shrink-0">K</div>
                                            <div class="truncate">
                                                <span class="text-[9px] text-slate-400 block font-bold uppercase tracking-wider">Ketua Umum</span>
                                                <span class="text-sm font-semibold text-slate-800 truncate block">{{ $kabinet->nama_ketua }}</span>
                                            </div>
                                        </div>
                                        
                                        {{-- Row Wakil --}}
                                        @if($kabinet->nama_wakil)
                                        <div class="flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-100 ring-2 ring-transparent group-hover:bg-white group-hover:ring-slate-100/80 transition-all">
                                            <div class="w-8 h-8 rounded-lg bg-purple-600/10 text-purple-600 font-bold text-xs flex items-center justify-center shrink-0">W</div>
                                            <div class="truncate">
                                                <span class="text-[9px] text-slate-400 block font-bold uppercase tracking-wider">Wakil Ketua</span>
                                                <span class="text-sm font-medium text-slate-700 truncate block">{{ $kabinet->nama_wakil }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Multi Columns Sek & Bend --}}
                                        <div class="grid grid-cols-2 gap-3">
                                            @if($kabinet->nama_sekretaris)
                                            <div class="p-2.5 bg-slate-50/50 rounded-xl border border-slate-100 truncate">
                                                <span class="text-[9px] text-slate-400 block font-bold uppercase tracking-wider">Sekretaris</span>
                                                <span class="text-xs font-semibold text-slate-700 truncate block mt-0.5">{{ $kabinet->nama_sekretaris }}</span>
                                            </div>
                                            @endif
                                            
                                            @if($kabinet->nama_bendahara)
                                            <div class="p-2.5 bg-slate-50/50 rounded-xl border border-slate-100 truncate">
                                                <span class="text-[9px] text-slate-400 block font-bold uppercase tracking-wider">Bendahara</span>
                                                <span class="text-xs font-semibold text-slate-700 truncate block mt-0.5">{{ $kabinet->nama_bendahara }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Action Footer --}}
                                @if(in_array(Auth::user()->role, ['admin','bem']))
                                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex gap-2">
                                    <a href="{{ route('kabinet.edit', $kabinet) }}"
                                        class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs bg-white border border-slate-200 hover:border-blue-500 hover:text-blue-600 py-2 rounded-lg font-semibold text-slate-600 shadow-sm transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('kabinet.toggle-active', $kabinet) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 text-xs bg-white border border-slate-200 hover:border-amber-500 hover:text-amber-600 py-2 rounded-lg font-semibold text-slate-600 shadow-sm transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                            </svg>
                                            Arsipkan
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- TAB PANEL 2: RIWAYAT KEPENGURUSAN --}}
        <div x-show="tab === 'riwayat'" class="space-y-6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            {{-- Advance Filter Header --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-slate-100 text-slate-700 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide block">Filter Linimasa</label>
                        <span class="text-[11px] text-slate-400">Batasi penelusuran histori kepengurusan</span>
                    </div>
                </div>
                <form method="GET" action="{{ route('kabinet.index') }}" class="w-full sm:w-auto">
                    <input type="hidden" name="tab" value="riwayat">
                    <select name="period_id" onchange="this.form.submit()"
                        class="w-full sm:w-72 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-slate-50 text-slate-700 transition outline-none">
                        <option value="">-- Tampilkan Semua Periode --</option>
                        @foreach($periods as $p)
                        <option value="{{ $p->id }}" {{ $selectedPeriodId == $p->id ? 'selected' : '' }}>
                            Periode {{ $p->nama_periode }} ({{ $p->tahun_mulai }}/{{ $p->tahun_selesai }})
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($kabinetsRiwayat->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 7.5m16.5 0V6a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6v1.5m15 0h-15M9 10.5h6"/>
                    </svg>
                    <p class="text-slate-500 text-sm font-medium">Arsip riwayat tidak ditemukan</p>
                </div>
            @else
                {{-- Data Table Container --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between">
                        <h3 class="font-bold text-xs text-slate-700 uppercase tracking-wider flex items-center gap-2">
                            <span>📚</span> Log Arsip Struktural Lama
                        </h3>
                        <span class="text-[11px] bg-slate-200 text-slate-700 font-bold px-2.5 py-0.5 rounded-full">{{ $kabinetsRiwayat->count() }} Record</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 text-slate-500 text-[10px] font-bold uppercase tracking-wider border-b border-slate-200">
                                    <th class="px-6 py-3.5">Organisasi</th>
                                    <th class="px-4 py-3.5">Nama Kabinet</th>
                                    <th class="px-4 py-3.5">Periode</th>
                                    <th class="px-4 py-3.5">Ketua Umum</th>
                                    <th class="px-4 py-3.5">Wakil Ketua</th>
                                    <th class="px-4 py-3.5">Masa Bakti</th>
                                    @if(in_array(Auth::user()->role, ['admin','bem']))
                                    <th class="px-6 py-3.5 text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-150 text-xs text-slate-600">
                                @foreach($kabinetsRiwayat as $kb)
                                @php
                                    $badgeMap = [
                                        'bem' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'hmp' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'ukm' => 'bg-amber-50 text-amber-700 border-amber-200'
                                    ];
                                    $badgeCls = $badgeMap[$kb->ormawa_type] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="{{ $badgeCls }} text-[9px] px-1.5 py-0.5 rounded font-bold uppercase border tracking-wide shrink-0">{{ $kb->ormawa_type }}</span>
                                            <span class="font-bold text-slate-800 whitespace-nowrap">{{ $kb->ormawa_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap font-medium text-slate-700">{{ $kb->nama_kabinet ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap font-semibold text-slate-500 text-[11px]">{{ $kb->period->nama_periode ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap font-bold text-slate-800">{{ $kb->nama_ketua }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-slate-500">{{ $kb->nama_wakil ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-[11px]">
                                            <span class="text-slate-700 font-medium">{{ $kb->tanggal_dilantik->format('d/m/y') }}</span> - 
                                            <span class="text-slate-700 font-medium">{{ $kb->tanggal_selesai->format('d/m/y') }}</span>
                                            @if($kb->durasi)
                                            <span class="text-blue-600 font-bold block text-[9px] mt-0.5">{{ $kb->durasi }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    @if(in_array(Auth::user()->role, ['admin','bem']))
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('kabinet.edit', $kb) }}" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg border border-transparent hover:border-blue-100 transition" title="Edit Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('kabinet.toggle-active', $kb) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg border border-transparent hover:border-emerald-100 transition" title="Aktifkan Kembali">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('kabinet.destroy', $kb) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen rekaman riwayat ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg border border-transparent hover:border-rose-100 transition" title="Hapus Permanen">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        {{-- TAB PANEL 3: PROPOSAL PER PERIODE --}}
        <div x-show="tab === 'proposal'" class="space-y-6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            {{-- Dropdown Periode Selection --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide block">Data Anggaran & Kinerja</label>
                        <span class="text-[11px] text-slate-400">Pilih rentang periode kepengurusan aktif/arsip</span>
                    </div>
                </div>
                <form method="GET" action="{{ route('kabinet.index') }}" class="w-full sm:w-auto">
                    <input type="hidden" name="tab" value="proposal">
                    <select name="period_id" onchange="this.form.submit()"
                        class="w-full sm:w-52 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-slate-50 text-slate-700 transition outline-none">
                        <option value="">-- Hubungkan ke Periode --</option>
                        @foreach($periods as $p)
                        <option value="{{ $p->id }}" {{ $selectedPeriodId == $p->id ? 'selected' : '' }}>
                            Periode {{ $p->nama_periode }} 
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($selectedPeriodId && $proposalsPeriode->isNotEmpty())
                @php
                    $kabsPeriode = $kabinetsAktif->where('period_id', $selectedPeriodId)
                        ->merge($kabinetsRiwayat->where('period_id', $selectedPeriodId));
                @endphp
                
                {{-- Horizontal Mini-Cards Org --}}
                @if($kabsPeriode->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($kabsPeriode as $kab)
                    @php
                        $miniBadge = [
                            'bem' => 'bg-blue-600',
                            'hmp' => 'bg-emerald-600',
                            'ukm' => 'bg-amber-500'
                        ][$kab->ormawa_type] ?? 'bg-slate-600';
                    @endphp
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                        <div class="w-2 h-10 rounded-md {{ $miniBadge }} shrink-0"></div>
                        <div class="truncate">
                            <span class="text-xs font-bold text-slate-800 truncate block">{{ $kab->ormawa_name }}</span>
                            <span class="text-[10px] text-slate-400 block truncate">Ketua: {{ $kab->nama_ketua }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Proposal Data Grid Table --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between">
                        <h3 class="font-bold text-xs text-slate-700 uppercase tracking-wider flex items-center gap-2">
                            <span>📋</span> Manuskrip Pengajuan Proposal
                        </h3>
                        <span class="bg-blue-600/10 text-blue-700 text-xs px-2.5 py-0.5 rounded-full font-bold border border-blue-100 shadow-sm">{{ $proposalsPeriode->count() }} Berkas</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 text-slate-500 text-[10px] font-bold uppercase tracking-wider border-b border-slate-200">
                                    <th class="px-6 py-3.5">Kode</th>
                                    <th class="px-4 py-3.5">Nama Kegiatan</th>
                                    <th class="px-4 py-3.5">Delegasi Pengusul</th>
                                    <th class="px-4 py-3.5">Pelaksanaan</th>
                                    <th class="px-4 py-3.5 text-right">Alokasi Anggaran</th>
                                    <th class="px-6 py-3.5 text-center">Status Akses</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-150 text-xs text-slate-600">
                                @foreach($proposalsPeriode as $proposal)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 font-mono font-bold text-blue-600 whitespace-nowrap text-[11px] tracking-wider">{{ $proposal->kode_proposal }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-800 whitespace-nowrap">{{ $proposal->nama_kegiatan }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-slate-600 font-medium">{{ $proposal->user->ormawa_name ?? $proposal->user->name }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-slate-400 text-[11px]">{{ $proposal->tanggal_mulai->format('d M Y') }}</td>
                                    <td class="px-4 py-4 text-right font-bold text-slate-900 whitespace-nowrap text-[13px]">Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusStyle = [
                                                'pending' => 'bg-amber-50 border-amber-200 text-amber-700',
                                                'approved_bem' => 'bg-indigo-50 border-indigo-200 text-indigo-700',
                                                'approved_admin' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                                'rejected' => 'bg-rose-50 border-rose-200 text-rose-700',
                                            ][$proposal->status] ?? 'bg-slate-50 border-slate-200 text-slate-700';

                                            $statusLabel = [
                                                'pending' => 'Menunggu Review',
                                                'approved_bem' => 'Verifikasi BEM',
                                                'approved_admin' => 'Disetujui Lembaga',
                                                'rejected' => 'Ditolak',
                                            ][$proposal->status] ?? $proposal->status;
                                        @endphp
                                        <span class="text-[10px] {{ $statusStyle }} border px-2.5 py-1 rounded-full font-bold tracking-wide shadow-sm inline-block">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($selectedPeriodId)
                <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm max-w-sm mx-auto">
                    <div class="p-3 bg-slate-50 text-slate-400 w-12 h-12 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-16"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-semibold">Kosong</p>
                    <p class="text-xs text-slate-400 mt-1">Tidak ada ajuan proposal kegiatan terekam di bawah periode yang Anda pilih.</p>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 shadow-sm border-dashed">
                    <p class="text-slate-400 text-xs font-medium">Silakan tentukan pilihan opsi periode di atas untuk merender kompilasi data proposal.</p>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>