<!-- resources/views/dashboard/ormawa.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard {{ Auth::user()->ormawa_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-blue-100">Mari kelola kegiatan {{ Auth::user()->ormawa_name }} dengan lebih efektif</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-24 h-24 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Proposal</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['my_proposals'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Disetujui</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['approved'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Sedang Berjalan</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['ongoing'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Selesai</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['completed'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Aksi Cepat
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('proposals.create') }}" 
                                   class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-colors group">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3 group-hover:bg-blue-600 transition-colors">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-gray-900">Ajukan Proposal</p>
                                        <p class="text-xs text-gray-600">Buat proposal baru</p>
                                    </div>
                                </a>

                                <a href="{{ route('activities.index') }}" 
                                   class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition-colors group">
                                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-3 group-hover:bg-green-600 transition-colors">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-gray-900">Lihat Kegiatan</p>
                                        <p class="text-xs text-gray-600">Monitor progress</p>
                                    </div>
                                </a>

                                <a href="{{ route('proposals.index') }}" 
                                   class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-colors group">
                                    <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3 group-hover:bg-purple-600 transition-colors">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-gray-900">Daftar Proposal</p>
                                        <p class="text-xs text-gray-600">Lihat semua</p>
                                    </div>
                                </a>

                                <a href="{{ route('archives.index') }}" 
                                   class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg hover:from-orange-100 hover:to-orange-200 transition-colors group">
                                    <div class="flex-shrink-0 bg-orange-500 rounded-lg p-3 group-hover:bg-orange-600 transition-colors">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-gray-900">Arsip</p>
                                        <p class="text-xs text-gray-600">Riwayat kegiatan</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Proposals -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Proposal Terbaru
                                </h3>
                                <a href="{{ route('proposals.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat Semua →
                                </a>
                            </div>
                            
                            @if($my_proposals->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Belum ada proposal yang diajukan</p>
                                    <a href="{{ route('proposals.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Buat Proposal Pertama
                                    </a>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($my_proposals->take(5) as $proposal)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <h4 class="text-sm font-semibold text-gray-900">{{ Str::limit($proposal->nama_kegiatan, 40) }}</h4>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'approved_bem' => 'bg-blue-100 text-blue-800',
                                                            'approved_admin' => 'bg-green-100 text-green-800',
                                                            'rejected' => 'bg-red-100 text-red-800'
                                                        ];
                                                        $statusLabels = [
                                                            'pending' => 'Pending',
                                                            'approved_bem' => 'Approved BEM',
                                                            'approved_admin' => 'Approved',
                                                            'rejected' => 'Ditolak'
                                                        ];
                                                    @endphp
                                                    <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full {{ $statusColors[$proposal->status] }}">
                                                        {{ $statusLabels[$proposal->status] }}
                                                    </span>
                                                </div>
                                                <div class="mt-1 flex items-center text-xs text-gray-500">
                                                    <span>{{ $proposal->kode_proposal }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $proposal->tanggal_mulai->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('proposals.show', $proposal) }}" 
                                               class="ml-4 text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Profile Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Profil Organisasi</h3>
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr(Auth::user()->ormawa_name, 0, 2) }}
                                    </span>
                                </div>
                                <h4 class="font-semibold text-gray-900">{{ Auth::user()->ormawa_name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                <a href="{{ route('profile.edit') }}" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Panduan -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-900">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tips & Panduan
                            </h3>
                            <ul class="space-y-3 text-sm">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-2 mt-0.5">1</span>
                                    <span class="text-gray-700">Pastikan data proposal lengkap sebelum diajukan</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-2 mt-0.5">2</span>
                                    <span class="text-gray-700">Upload file proposal dalam format PDF</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-2 mt-0.5">3</span>
                                    <span class="text-gray-700">Update status kegiatan secara berkala</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-2 mt-0.5">4</span>
                                    <span class="text-gray-700">Buat LPJ maksimal 7 hari setelah kegiatan</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Help Center -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-3">Butuh Bantuan?</h3>
                            <p class="text-sm text-gray-600 mb-4">Hubungi admin jika mengalami kendala</p>
                            <a href="#" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">
                                Hubungi Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>