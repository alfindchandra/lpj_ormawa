<x-app-layout>
    @section('title', 'Pengurus Inti')

    @push('styles')
    <style>
        .badge-bem   { background: #dbeafe; color: #1e40af; }
        .badge-hmp   { background: #d1fae5; color: #065f46; }
        .badge-ukm   { background: #fef3c7; color: #92400e; }
        .tab-active  { border-bottom: 3px solid #2563eb; color: #2563eb; font-weight: 600; }
        .kabinet-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .kabinet-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .officer-row { border-left: 4px solid #3b82f6; }
        .officer-row.wakil { border-color: #8b5cf6; }
        .officer-row.bendahara { border-color: #10b981; }
        .officer-row.sekretaris { border-color: #f59e0b; }
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
    }" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <x-slot name="header">
            <div class="flex items-center justify-between mr-4">
                <h2 class="font-bold text-xl text-gray-800">
                    👥 Pengurus Inti Ormawa
                </h2>
                @if(in_array(Auth::user()->role, ['admin', 'bem']))
                <a href="{{ route('kabinet.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pengurus
                </a>
                @endif
            </div>
        </x-slot>

        <div class="py-6 px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- TAB Navigation (x-data pembungkus di sini dihapus karena sudah ikut scope utama) --}}
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8">
                    <button @click="changeTab('aktif')" :class="tab === 'aktif' ? 'tab-active border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition">
                        🏛️ Kabinet Aktif
                        <span class="ml-1 bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">{{ $kabinetsAktif->count() }}</span>
                    </button>
                    <button @click="changeTab('riwayat')" :class="tab === 'riwayat' ? 'tab-active border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition">
                        📚 Riwayat Kepengurusan
                        <span class="ml-1 bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $kabinetsRiwayat->count() }}</span>
                    </button>
                    <button @click="changeTab('proposal')" :class="tab === 'proposal' ? 'tab-active border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition">
                        📋 Proposal per Periode
                    </button>
                </nav>
            </div>

            {{-- ===== TAB KONTEN ===== --}}
            
            {{-- ===== TAB: KABINET AKTIF ===== --}}
            <div x-show="tab === 'aktif'">
                @if($kabinetsAktif->isEmpty())
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-400 text-lg">Belum ada data pengurus inti aktif</p>
                        @if(in_array(Auth::user()->role, ['admin','bem']))
                        <a href="{{ route('kabinet.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Tambah Sekarang</a>
                        @endif
                    </div>
                @else
                    @foreach(['bem' => 'BEM', 'hmp' => 'HMP', 'ukm' => 'UKM'] as $type => $label)
                        @php $group = $kabinetsAktif->where('ormawa_type', $type); @endphp
                        @if($group->isNotEmpty())
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-2xl">{{ $type === 'bem' ? '🏫' : ($type === 'hmp' ? '🎓' : '⭐') }}</span>
                                <h3 class="text-lg font-bold text-gray-800">{{ $label }}</h3>
                                <span class="badge-{{ $type }} text-xs font-semibold px-2 py-1 rounded-full">{{ $group->count() }} kabinet</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach($group as $kabinet)
                                <div class="kabinet-card bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                                    <div class="px-5 py-4 bg-blue-600 text-white">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-bold text-lg leading-tight">{{ $kabinet->ormawa_name }}</p>
                                                @if($kabinet->nama_kabinet)
                                                <p class="text-xs opacity-90 mt-0.5">{{ $kabinet->nama_kabinet }}</p>
                                                @endif
                                            </div>
                                            <span class="text-xs bg-white text-gray-200 bg-opacity-20 px-2 py-1 rounded-full">{{ $kabinet->period->nama_periode ?? '-' }}</span>
                                        </div>
                                        <div class="mt-3 text-xs opacity-90">
                                            🗓️ {{ $kabinet->tanggal_dilantik->format('d M Y') }} — {{ $kabinet->tanggal_selesai->format('d M Y') }}
                                        </div>
                                    </div>

                                    <div class="px-5 py-4 space-y-2">
                                        <div class="officer-row pl-3 py-1 rounded-r">
                                            <p class="text-xs text-gray-400 font-medium">Ketua</p>
                                            <p class="font-semibold text-gray-800">{{ $kabinet->nama_ketua }}</p>
                                        </div>
                                        @if($kabinet->nama_wakil)
                                        <div class="officer-row wakil pl-3 py-1 rounded-r">
                                            <p class="text-xs text-gray-400 font-medium">Wakil Ketua</p>
                                            <p class="font-semibold text-gray-700">{{ $kabinet->nama_wakil }}</p>
                                        </div>
                                        @endif
                                        @if($kabinet->nama_bendahara)
                                        <div class="officer-row bendahara pl-3 py-1 rounded-r">
                                            <p class="text-xs text-gray-400 font-medium">Bendahara</p>
                                            <p class="font-semibold text-gray-700">{{ $kabinet->nama_bendahara }}</p>
                                        </div>
                                        @endif
                                        @if($kabinet->nama_sekretaris)
                                        <div class="officer-row sekretaris pl-3 py-1 rounded-r">
                                            <p class="text-xs text-gray-400 font-medium">Sekretaris</p>
                                            <p class="font-semibold text-gray-700">{{ $kabinet->nama_sekretaris }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    @if(in_array(Auth::user()->role, ['admin','bem']))
                                    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex gap-2">
                                        <a href="{{ route('kabinet.edit', $kabinet) }}"
                                            class="flex-1 text-center text-sm bg-white border border-gray-300 hover:border-blue-400 hover:text-blue-600 px-3 py-1.5 rounded-lg font-medium transition">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('kabinet.toggle-active', $kabinet) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full text-sm bg-white border border-gray-300 hover:border-amber-400 hover:text-amber-600 px-3 py-1.5 rounded-lg font-medium transition">
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
            <div x-show="tab === 'riwayat'" x-cloak>
                <div class="mb-6 flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <label class="text-sm font-medium text-gray-600">Filter Periode:</label>
                    <form method="GET" action="{{ route('kabinet.index') }}" class="flex items-center gap-3">
                        <input type="hidden" name="tab" value="riwayat">
                        <select name="period_id" onchange="this.form.submit()"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <p class="text-gray-400 text-lg">Tidak ada riwayat kepengurusan</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-700">📚 Riwayat Kepengurusan Sebelumnya</h3>
                            <span class="text-sm text-gray-400">{{ $kabinetsRiwayat->count() }} data</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Organisasi</th>
                                        <th class="px-4 py-3 text-left">Kabinet</th>
                                        <th class="px-4 py-3 text-left">Periode</th>
                                        <th class="px-4 py-3 text-left">Ketua</th>
                                        <th class="px-4 py-3 text-left">Wakil</th>
                                        <th class="px-4 py-3 text-left">Bendahara</th>
                                        <th class="px-4 py-3 text-left">Sekretaris</th>
                                        <th class="px-4 py-3 text-left">Masa Jabatan</th>
                                        @if(in_array(Auth::user()->role, ['admin','bem']))
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($kabinetsRiwayat as $kb)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <span class="badge-{{ $kb->ormawa_type }} text-xs px-2 py-0.5 rounded-full font-semibold uppercase">{{ $kb->ormawa_type }}</span>
                                                <span class="font-medium text-gray-800">{{ $kb->ormawa_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $kb->nama_kabinet ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $kb->period->nama_periode ?? '-' }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $kb->nama_ketua }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $kb->nama_wakil ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $kb->nama_bendahara ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $kb->nama_sekretaris ?? '-' }}</td>
                                        <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $kb->tanggal_dilantik->format('d M Y') }}<br>
                                            s/d {{ $kb->tanggal_selesai->format('d M Y') }}
                                            <br><span class="text-blue-500">{{ $kb->durasi }}</span>
                                        </td>
                                        @if(in_array(Auth::user()->role, ['admin','bem']))
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="{{ route('kabinet.edit', $kb) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('kabinet.toggle-active', $kb) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition" title="Aktifkan Kembali">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('kabinet.destroy', $kb) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pengurus ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
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
            <div x-show="tab === 'proposal'" x-cloak>
                <div class="mb-6 bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4">
                        <label class="text-sm font-medium text-gray-600">Pilih Periode Kabinet:</label>
                        <form method="GET" action="{{ route('kabinet.index') }}" class="flex items-center gap-3">
                            <input type="hidden" name="tab" value="proposal">
                            <select name="period_id" onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                    <div class="mb-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($kabsPeriode as $kab)
                        <div class="bg-gradient-to-br {{ $kab->ormawa_type === 'bem' ? 'from-blue-50 to-blue-100' : ($kab->ormawa_type === 'hmp' ? 'from-emerald-50 to-emerald-100' : 'from-amber-50 to-amber-100') }} rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="badge-{{ $kab->ormawa_type }} text-xs px-2 py-0.5 rounded-full font-semibold uppercase">{{ $kab->ormawa_type }}</span>
                                <span class="font-semibold text-gray-800">{{ $kab->ormawa_name }}</span>
                            </div>
                            <p class="text-xs text-gray-600">Ketua: <span class="font-medium">{{ $kab->nama_ketua }}</span></p>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-700">📋 Proposal Kegiatan</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">{{ $proposalsPeriode->count() }} proposal</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Kode</th>
                                        <th class="px-4 py-3 text-left">Kegiatan</th>
                                        <th class="px-4 py-3 text-left">Pengusul</th>
                                        <th class="px-4 py-3 text-left">Tanggal</th>
                                        <th class="px-4 py-3 text-right">Anggaran</th>
                                        <th class="px-4 py-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($proposalsPeriode as $proposal)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-mono text-xs text-blue-600">{{ $proposal->kode_proposal }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $proposal->nama_kegiatan }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $proposal->user->ormawa_name ?? $proposal->user->name }}</td>
                                        <td class="px-4 py-3 text-xs text-gray-500">{{ $proposal->tanggal_mulai->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-right font-medium text-gray-800">Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $statusMap = [
                                                    'pending' => ['bg-yellow-100 text-yellow-800', 'Pending'],
                                                    'approved_bem' => ['bg-blue-100 text-blue-800', 'Disetujui BEM'],
                                                    'approved_admin' => ['bg-green-100 text-green-800', 'Disetujui'],
                                                    'rejected' => ['bg-red-100 text-red-800', 'Ditolak'],
                                                ];
                                                [$cls, $lbl] = $statusMap[$proposal->status] ?? ['bg-gray-100 text-gray-800', $proposal->status];
                                            @endphp
                                            <span class="text-xs {{ $cls }} px-2 py-1 rounded-full font-medium">{{ $lbl }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($selectedPeriodId)
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-100">
                        <p class="text-gray-400">Tidak ada proposal pada periode ini</p>
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-100">
                        <p class="text-gray-400">Pilih periode untuk melihat proposal</p>
                    </div>
                @endif
            </div>

        </div> 
    </div>
</x-app-layout>