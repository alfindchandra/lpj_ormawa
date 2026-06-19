<x-app-layout>
    @section('title', 'Pengurus Inti')

    @push('styles')
    <style>
        /* Perbaikan kontras warna badge agar teks lebih mudah dibaca */
        .badge-bem   { background-color: #dbeafe; color: #1e40af; }
        .badge-hmp   { background-color: #d1fae5; color: #065f46; }
        .badge-ukm   { background-color: #fef3c7; color: #92400e; }
        .tab-active  { border-bottom: 3px solid #2563eb; color: #2563eb; font-weight: 600; }
        
        .kabinet-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .kabinet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }
        .officer-row { border-left: 4px solid #3b82f6; }
        .officer-row.wakil { border-color: #8b5cf6; }
        .officer-row.bendahara { border-color: #10b981; }
        .officer-row.sekretaris { border-color: #f59e0b; }
        
        /* Memastikan x-cloak menyembunyikan elemen sebelum Alpine siap sepenuhnya */
        [x-cloak] { display: none !important; }
    </style>
    @endpush

    <div x-data="{ 
        tab: '{{ request()->get('tab', 'aktif') }}',
        searchAktif: '',
        searchProposal: '',
        changeTab(target) {
            this.tab = target;
            const url = new URL(window.location);
            url.searchParams.set('tab', target);
            window.history.pushState({}, '', url);
        }
    }" class="py-3 px-4 sm:px-6 lg:px-4 max-w-7xl mx-auto min-h-screen">

        <x-slot name="header">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mr-4">
                <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                    👥 Pengurus Inti Ormawa
                </h2>
                @if(in_array(Auth::user()->role, ['admin', 'bem']))
                <a href="{{ route('kabinet.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pengurus
                </a>
                @endif
            </div>
        </x-slot>

        <div class="mt-6">

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3.5 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            @endif

            {{-- TAB Navigation --}}
            <div class="border-b border-gray-200 mb-8 overflow-x-auto whitespace-nowrap scrollbar-hide">
                <nav class="-mb-px flex space-x-8">
                    <button @click="changeTab('aktif')" :class="tab === 'aktif' ? 'tab-active' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200 flex items-center gap-2">
                        <span>🏛️ Kabinet Aktif</span>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $kabinetsAktif->count() }}</span>
                    </button>
                    <button @click="changeTab('riwayat')" :class="tab === 'riwayat' ? 'tab-active' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200 flex items-center gap-2">
                        <span>📚 Riwayat Kepengurusan</span>
                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $kabinetsRiwayat->count() }}</span>
                    </button>
                    <button @click="changeTab('proposal')" :class="tab === 'proposal' ? 'tab-active' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200 flex items-center gap-2">
                        <span>📋 Proposal per Periode</span>
                    </button>
                </nav>
            </div>

            {{-- ===== TAB KONTEN ===== --}}
            
            {{-- ===== TAB: KABINET AKTIF ===== --}}
            <div x-show="tab === 'aktif'" class="space-y-10">
                @if($kabinetsAktif->isEmpty())
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Belum ada data pengurus inti aktif</p>
                        @if(in_array(Auth::user()->role, ['admin','bem']))
                        <a href="{{ route('kabinet.create') }}" class="mt-4 inline-block bg-blue-600 text-white font-medium px-6 py-2.5 rounded-xl hover:bg-blue-700 shadow transition">Tambah Sekarang</a>
                        @endif
                    </div>
                @else
                    @foreach(['bem' => 'BEM', 'hmp' => 'HMP', 'ukm' => 'UKM'] as $type => $label)
                        @php $group = $kabinetsAktif->where('ormawa_type', $type); @endphp
                        @if($group->isNotEmpty())
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
                                <span class="text-2xl">{{ $type === 'bem' ? '🏫' : ($type === 'hmp' ? '🎓' : '⭐') }}</span>
                                <h3 class="text-xl font-bold text-gray-800">{{ $label }}</h3>
                                <span class="badge-{{ $type }} text-xs font-bold px-2.5 py-1 rounded-full">{{ $group->count() }} Kabinet</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($group as $kabinet)
                                <div class="kabinet-card bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden flex flex-col justify-between">
                                    <div>
                                        {{-- Header Card --}}
                                        <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                                            <div class="flex items-start justify-between gap-2">
                                                <div>
                                                    <p class="font-bold text-xl leading-tight tracking-wide">{{ $kabinet->ormawa_name }}</p>
                                                    @if($kabinet->nama_kabinet)
                                                    <p class="text-xs text-blue-100/90 mt-1 font-medium bg-white/10 inline-block px-2 py-0.5 rounded">{{ $kabinet->nama_kabinet }}</p>
                                                    @endif
                                                </div>
                                                <span class="text-xs bg-white/20 text-white border border-white/20 px-2.5 py-1 rounded-full font-semibold backdrop-blur-sm shrink-0">
                                                    {{ $kabinet->period->nama_periode ?? '-' }}
                                                </span>
                                            </div>
                                            <div class="mt-4 text-xs text-blue-100 flex items-center gap-1.5 bg-black/10 -mx-5 -mb-5 px-5 py-2">
                                                <span>🗓️</span> 
                                                <span>{{ $kabinet->tanggal_dilantik->format('d M Y') }} — {{ $kabinet->tanggal_selesai->format('d M Y') }}</span>
                                            </div>
                                        </div>

                                        {{-- Body Card --}}
                                        <div class="p-5 space-y-3.5">
                                            <div class="officer-row pl-3 py-1 bg-gray-50/50 rounded-r-lg">
                                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Ketua</p>
                                                <p class="font-semibold text-gray-900 text-sm">{{ $kabinet->nama_ketua }}</p>
                                            </div>
                                            @if($kabinet->nama_wakil)
                                            <div class="officer-row wakil pl-3 py-1 bg-gray-50/50 rounded-r-lg">
                                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Wakil Ketua</p>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $kabinet->nama_wakil }}</p>
                                            </div>
                                            @endif
                                            @if($kabinet->nama_bendahara)
                                            <div class="officer-row bendahara pl-3 py-1 bg-gray-50/50 rounded-r-lg">
                                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Bendahara</p>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $kabinet->nama_bendahara }}</p>
                                            </div>
                                            @endif
                                            @if($kabinet->nama_sekretaris)
                                            <div class="officer-row sekretaris pl-3 py-1 bg-gray-50/50 rounded-r-lg">
                                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Sekretaris</p>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $kabinet->nama_sekretaris }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Footer Card / Action --}}
                                    @if(in_array(Auth::user()->role, ['admin','bem']))
                                    <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex gap-3">
                                        <a href="{{ route('kabinet.edit', $kabinet) }}"
                                            class="flex-1 text-center text-sm bg-white border border-gray-300 hover:border-blue-500 hover:text-blue-600 px-3 py-2 rounded-xl font-semibold text-gray-700 shadow-sm transition duration-150">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('kabinet.toggle-active', $kabinet) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full text-sm bg-white border border-gray-300 hover:border-amber-500 hover:text-amber-600 px-3 py-2 rounded-xl font-semibold text-gray-700 shadow-sm transition duration-150">
                                                📦 Arsipkan
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

            {{-- ===== TAB: RIWAYAT ===== --}}
            <div x-show="tab === 'riwayat'" x-cloak class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 bg-white rounded-2xl p-5 shadow-sm border border-gray-200/80">
                    <label class="text-sm font-semibold text-gray-700 shrink-0">Filter Periode:</label>
                    <form method="GET" action="{{ route('kabinet.index') }}" class="w-full sm:w-auto">
                        <input type="hidden" name="tab" value="riwayat">
                        <select name="period_id" onchange="this.form.submit()"
                            class="w-full sm:w-72 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-medium text-gray-700">
                            <option value="">-- Semua Periode --</option>
                            @foreach($periods as $p)
                            <option value="{{ $p->id }}" {{ $selectedPeriodId == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_periode }} ({{ $p->tahun_mulai }}/{{ $p->tahun_selesai }})
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if($kabinetsRiwayat->isEmpty())
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <p class="text-gray-400 text-lg font-medium">Tidak ada riwayat kepengurusan</p>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4.5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span>📚</span> Riwayat Kepengurusan Sebelumnya
                            </h3>
                            <span class="text-xs bg-gray-200 text-gray-700 font-bold px-2.5 py-1 rounded-full">{{ $kabinetsRiwayat->count() }} Data</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 text-[11px] font-bold uppercase tracking-wider border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-3.5">Organisasi</th>
                                        <th class="px-4 py-3.5">Kabinet</th>
                                        <th class="px-4 py-3.5">Periode</th>
                                        <th class="px-4 py-3.5">Ketua</th>
                                        <th class="px-4 py-3.5">Wakil</th>
                                        <th class="px-4 py-3.5">Bendahara</th>
                                        <th class="px-4 py-3.5">Sekretaris</th>
                                        <th class="px-4 py-3.5">Masa Jabatan</th>
                                        @if(in_array(Auth::user()->role, ['admin','bem']))
                                        <th class="px-6 py-3.5 text-center">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($kabinetsRiwayat as $kb)
                                    <tr class="hover:bg-gray-50/80 transition duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="badge-{{ $kb->ormawa_type }} text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shrink-0">{{ $kb->ormawa_type }}</span>
                                                <span class="font-semibold text-gray-950 whitespace-nowrap">{{ $kb->ormawa_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600 font-medium whitespace-nowrap">{{ $kb->nama_kabinet ?? '-' }}</td>
                                        <td class="px-4 py-4 text-gray-600 font-semibold text-xs whitespace-nowrap">{{ $kb->period->nama_periode ?? '-' }}</td>
                                        <td class="px-4 py-4 font-semibold text-gray-900 whitespace-nowrap">{{ $kb->nama_ketua }}</td>
                                        <td class="px-4 py-4 text-gray-600 whitespace-nowrap">{{ $kb->nama_wakil ?? '-' }}</td>
                                        <td class="px-4 py-4 text-gray-600 whitespace-nowrap">{{ $kb->nama_bendahara ?? '-' }}</td>
                                        <td class="px-4 py-4 text-gray-600 whitespace-nowrap">{{ $kb->nama_sekretaris ?? '-' }}</td>
                                        <td class="px-4 py-4 text-xs text-gray-500 whitespace-nowrap leading-relaxed">
                                            <span class="font-medium text-gray-700">{{ $kb->tanggal_dilantik->format('d M Y') }}</span><br>
                                            <span class="text-gray-400">s/d</span> <span class="font-medium text-gray-700">{{ $kb->tanggal_selesai->format('d M Y') }}</span>
                                            @if($kb->durasi)
                                            <br><span class="text-blue-600 font-semibold mt-0.5 block text-[10px] bg-blue-50 px-1.5 py-0.2 rounded w-max">{{ $kb->durasi }}</span>
                                            @endif
                                        </td>
                                        @if(in_array(Auth::user()->role, ['admin','bem']))
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('kabinet.edit', $kb) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-200 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('kabinet.toggle-active', $kb) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 text-green-600 hover:bg-green-50 border border-transparent hover:border-green-200 rounded-lg transition" title="Aktifkan Kembali">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('kabinet.destroy', $kb) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pengurus ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 border border-transparent hover:border-red-200 rounded-lg transition" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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

            {{-- ===== TAB: PROPOSAL PER PERIODE ===== --}}
            <div x-show="tab === 'proposal'" x-cloak class="space-y-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200/80">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <label class="text-sm font-semibold text-gray-700 shrink-0">Pilih Periode Kabinet:</label>
                        <form method="GET" action="{{ route('kabinet.index') }}" class="w-full sm:w-auto">
                            <input type="hidden" name="tab" value="proposal">
                            <select name="period_id" onchange="this.form.submit()"
                                class="w-full sm:w-72 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-medium text-gray-700">
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periods as $p)
                                <option value="{{ $p->id }}" {{ $selectedPeriodId == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_periode }} {{ $p->is_active ? '(Aktif)' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                @if($selectedPeriodId && $proposalsPeriode->isNotEmpty())
                    @php
                        $kabsPeriode = $kabinetsAktif->where('period_id', $selectedPeriodId)
                            ->merge($kabinetsRiwayat->where('period_id', $selectedPeriodId));
                    @endphp
                    @if($kabsPeriode->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($kabsPeriode as $kab)
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="badge-{{ $kab->ormawa_type }} text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shrink-0">{{ $kab->ormawa_type }}</span>
                                    <span class="font-bold text-gray-800 text-sm whitespace-nowrap">{{ $kab->ormawa_name }}</span>
                                </div>
                                <p class="text-xs text-gray-500">Ketua: <span class="font-semibold text-gray-700">{{ $kab->nama_ketua }}</span></p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4.5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <span>📋</span> Proposal Kegiatan
                            </h3>
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold">{{ $proposalsPeriode->count() }} Proposal</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 text-[11px] font-bold uppercase tracking-wider border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-3.5">Kode</th>
                                        <th class="px-4 py-3.5">Kegiatan</th>
                                        <th class="px-4 py-3.5">Pengusul</th>
                                        <th class="px-4 py-3.5">Tanggal</th>
                                        <th class="px-4 py-3.5 text-right">Anggaran</th>
                                        <th class="px-6 py-3.5 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($proposalsPeriode as $proposal)
                                    <tr class="hover:bg-gray-50/80 transition duration-150">
                                        <td class="px-6 py-4 font-mono text-xs text-blue-600 font-bold whitespace-nowrap">{{ $proposal->kode_proposal }}</td>
                                        <td class="px-4 py-4 font-semibold text-gray-900 whitespace-nowrap">{{ $proposal->nama_kegiatan }}</td>
                                        <td class="px-4 py-4 text-gray-600 font-medium whitespace-nowrap">{{ $proposal->user->ormawa_name ?? $proposal->user->name }}</td>
                                        <td class="px-4 py-4 text-xs text-gray-500 whitespace-nowrap font-medium">{{ $proposal->tanggal_mulai->format('d M Y') }}</td>
                                        <td class="px-4 py-4 text-right font-bold text-gray-900 whitespace-nowrap">Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            @php
                                                $statusMap = [
                                                    'pending' => ['bg-yellow-50 border-yellow-200 text-yellow-800', 'Pending'],
                                                    'approved_bem' => ['bg-blue-50 border-blue-200 text-blue-800', 'Disetujui BEM'],
                                                    'approved_admin' => ['bg-green-50 border-green-200 text-green-800', 'Disetujui'],
                                                    'rejected' => ['bg-red-50 border-red-200 text-red-800', 'Ditolak'],
                                                ];
                                                [$cls, $lbl] = $statusMap[$proposal->status] ?? ['bg-gray-50 border-gray-200 text-gray-800', $proposal->status];
                                            @endphp
                                            <span class="text-xs {{ $cls }} border px-3 py-1 rounded-full font-bold tracking-wide">{{ $lbl }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($selectedPeriodId)
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-gray-400 font-medium">Tidak ada proposal pada periode ini</p>
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-gray-400 font-medium">Pilih periode untuk melihat proposal</p>
                    </div>
                @endif
            </div>

        </div> 
    </div>
</x-app-layout>