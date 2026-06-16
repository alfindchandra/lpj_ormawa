<!-- resources/views/dashboard/hmp.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🎓</span>
            <div>
                <h2 class="font-bold text-xl text-gray-800">Dashboard HMP — {{ Auth::user()->ormawa_name }}</h2>
                <p class="text-sm text-gray-500">Himpunan Mahasiswa Program Studi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        {{-- Welcome Banner HMP --}}
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl shadow-lg p-6 mb-6 ">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-emerald-800">HMP {{ Auth::user()->ormawa_name }} — Kelola kegiatan himpunanmu dengan baik</p>
                    @if($activePeriod)
                    <span class="mt-2 inline-block bg-white bg-opacity-20 text-xs px-3 py-1 rounded-full">
                        📅 Periode Aktif: {{ $activePeriod->nama_periode }}
                    </span>
                    @endif
                </div>
                <svg class="w-20 h-20 text-white opacity-20 hidden md:block" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Proposal</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['my_proposals'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Disetujui</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Sedang Berjalan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['ongoing'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                {{-- Quick Actions --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">⚡ Aksi Cepat</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('proposals.create') }}" class="flex items-center gap-3 p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition group">
                            <div class="bg-emerald-500 group-hover:bg-emerald-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Ajukan Proposal</p><p class="text-xs text-gray-500">Buat kegiatan baru</p></div>
                        </a>
                        <a href="{{ route('activities.index') }}" class="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
                            <div class="bg-blue-500 group-hover:bg-blue-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Monitoring</p><p class="text-xs text-gray-500">Lihat kegiatan aktif</p></div>
                        </a>
                        <a href="{{ route('kabinet.index') }}" class="flex items-center gap-3 p-4 bg-teal-50 hover:bg-teal-100 rounded-xl transition group">
                            <div class="bg-teal-500 group-hover:bg-teal-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Pengurus Inti</p><p class="text-xs text-gray-500">Data kepengurusan</p></div>
                        </a>
                        <a href="{{ route('archives.index') }}" class="flex items-center gap-3 p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
                            <div class="bg-orange-500 group-hover:bg-orange-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Arsip</p><p class="text-xs text-gray-500">Riwayat kegiatan</p></div>
                        </a>
                    </div>
                </div>

                {{-- Recent Proposals --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">📋 Proposal Terbaru</h3>
                        <a href="{{ route('proposals.index') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium">Lihat Semua →</a>
                    </div>
                    @if($my_proposals->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-400 text-sm">Belum ada proposal</p>
                        <a href="{{ route('proposals.create') }}" class="mt-3 inline-block bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-emerald-700 transition">Buat Sekarang</a>
                    </div>
                    @else
                    <div class="space-y-3">
                        @foreach($my_proposals->take(5) as $proposal)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ Str::limit($proposal->nama_kegiatan, 40) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $proposal->kode_proposal }} • {{ $proposal->tanggal_mulai->format('d M Y') }}</p>
                            </div>
                            @php $sc = ['pending'=>'bg-yellow-100 text-yellow-800','approved_bem'=>'bg-blue-100 text-blue-800','approved_admin'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800']; @endphp
                            <span class="text-xs {{ $sc[$proposal->status] ?? 'bg-gray-100 text-gray-800' }} px-2 py-1 rounded-full font-medium">
                                {{ ['pending'=>'Pending','approved_bem'=>'Ditinjau BEM','approved_admin'=>'Disetujui','rejected'=>'Ditolak'][$proposal->status] ?? $proposal->status }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                {{-- Pengurus Inti HMP --}}
                @if($kabinetsAktif->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">👥 Pengurus Aktif HMP</h3>
                    @foreach($kabinetsAktif as $kab)
                    <div class="border-l-4 border-emerald-400 pl-3 mb-3">
                        <p class="font-semibold text-sm text-gray-800">{{ $kab->ormawa_name }}</p>
                        @if($kab->nama_kabinet)<p class="text-xs text-emerald-600">{{ $kab->nama_kabinet }}</p>@endif
                        <p class="text-xs text-gray-600 mt-1">Ketua: <strong>{{ $kab->nama_ketua }}</strong></p>
                        @if($kab->nama_wakil)<p class="text-xs text-gray-500">Wakil: {{ $kab->nama_wakil }}</p>@endif
                        <p class="text-xs text-gray-400 mt-1">{{ $kab->tanggal_dilantik->format('d M Y') }} s/d {{ $kab->tanggal_selesai->format('d M Y') }}</p>
                    </div>
                    @endforeach
                    <a href="{{ route('kabinet.index') }}" class="block text-center text-xs text-emerald-600 hover:text-emerald-800 font-medium mt-3">Lihat Semua Pengurus →</a>
                </div>
                @endif

                {{-- Profil --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">🏛️ Profil HMP</h3>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">{{ substr(Auth::user()->ormawa_name ?? 'H', 0, 2) }}</span>
                        </div>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->ormawa_name }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->name }}</p>
                        <span class="inline-block mt-2 text-xs bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-medium">HMP</span>
                        <a href="{{ route('profile.edit') }}" class="block mt-3 text-sm text-gray-600 hover:text-gray-900 underline">Edit Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
