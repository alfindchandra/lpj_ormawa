<!-- resources/views/dashboard/ukm.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-2xl">⭐</span>
            <div>
                <h2 class="font-bold text-xl text-gray-800">Dashboard UKM — {{ Auth::user()->ormawa_name }}</h2>
                <p class="text-sm text-gray-500">Unit Kegiatan Mahasiswa</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        {{-- Welcome Banner UKM --}}
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-amber-100">UKM {{ Auth::user()->ormawa_name }} — Wujudkan potensi mahasiswa bersama kami</p>
                    @if($activePeriod)
                    <span class="mt-2 inline-block bg-white bg-opacity-20 text-xs px-3 py-1 rounded-full">
                        📅 Periode Aktif: {{ $activePeriod->nama_periode }}
                    </span>
                    @endif
                </div>
                <svg class="w-20 h-20 text-white opacity-20 hidden md:block" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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
                        <p class="text-xs text-gray-500">Berjalan</p>
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
                        <a href="{{ route('proposals.create') }}" class="flex items-center gap-3 p-4 bg-amber-50 hover:bg-amber-100 rounded-xl transition group">
                            <div class="bg-amber-500 group-hover:bg-amber-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Ajukan Proposal</p><p class="text-xs text-gray-500">Buat program baru</p></div>
                        </a>
                        <a href="{{ route('activities.index') }}" class="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
                            <div class="bg-blue-500 group-hover:bg-blue-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Monitoring</p><p class="text-xs text-gray-500">Lihat aktivitas</p></div>
                        </a>
                        <a href="{{ route('kabinet.index') }}" class="flex items-center gap-3 p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
                            <div class="bg-orange-500 group-hover:bg-orange-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Pengurus Inti</p><p class="text-xs text-gray-500">Data kepengurusan</p></div>
                        </a>
                        <a href="{{ route('archives.index') }}" class="flex items-center gap-3 p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
                            <div class="bg-purple-500 group-hover:bg-purple-600 p-2.5 rounded-lg transition"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg></div>
                            <div><p class="text-sm font-semibold text-gray-800">Arsip</p><p class="text-xs text-gray-500">Riwayat kegiatan</p></div>
                        </a>
                    </div>
                </div>

                {{-- Recent Proposals --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">📋 Proposal Terbaru</h3>
                        <a href="{{ route('proposals.index') }}" class="text-sm text-amber-600 hover:text-amber-800 font-medium">Lihat Semua →</a>
                    </div>
                    @if($my_proposals->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-400 text-sm">Belum ada proposal</p>
                        <a href="{{ route('proposals.create') }}" class="mt-3 inline-block bg-amber-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-amber-600 transition">Buat Sekarang</a>
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
                {{-- Pengurus Aktif UKM --}}
                @if($kabinetsAktif->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">👥 Pengurus Aktif UKM</h3>
                    @foreach($kabinetsAktif as $kab)
                    <div class="border-l-4 border-amber-400 pl-3 mb-3">
                        <p class="font-semibold text-sm text-gray-800">{{ $kab->ormawa_name }}</p>
                        @if($kab->nama_kabinet)<p class="text-xs text-amber-600">{{ $kab->nama_kabinet }}</p>@endif
                        <p class="text-xs text-gray-600 mt-1">Ketua: <strong>{{ $kab->nama_ketua }}</strong></p>
                        @if($kab->nama_wakil)<p class="text-xs text-gray-500">Wakil: {{ $kab->nama_wakil }}</p>@endif
                        <p class="text-xs text-gray-400 mt-1">{{ $kab->tanggal_dilantik->format('d M Y') }} s/d {{ $kab->tanggal_selesai->format('d M Y') }}</p>
                    </div>
                    @endforeach
                    <a href="{{ route('kabinet.index') }}" class="block text-center text-xs text-amber-600 hover:text-amber-800 font-medium mt-3">Lihat Semua Pengurus →</a>
                </div>
                @endif

                {{-- Profil --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">🏆 Profil UKM</h3>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">{{ substr(Auth::user()->ormawa_name ?? 'U', 0, 2) }}</span>
                        </div>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->ormawa_name }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->name }}</p>
                        <span class="inline-block mt-2 text-xs bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-medium">UKM</span>
                        <a href="{{ route('profile.edit') }}" class="block mt-3 text-sm text-gray-600 hover:text-gray-900 underline">Edit Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
