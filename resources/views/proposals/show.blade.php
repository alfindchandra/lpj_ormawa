
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Proposal: {{ $proposal->kode_proposal }}
            </h2>
            <a href="{{ route('proposals.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Kegiatan -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Informasi Kegiatan</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Kegiatan</label>
                                    <p class="text-gray-900 font-medium">{{ $proposal->nama_kegiatan }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                                    <p class="text-gray-700">{{ $proposal->deskripsi }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tanggal Mulai</label>
                                        <p class="text-gray-900">{{ $proposal->tanggal_mulai->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tanggal Selesai</label>
                                        <p class="text-gray-900">{{ $proposal->tanggal_selesai->format('d F Y') }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tempat</label>
                                    <p class="text-gray-900">{{ $proposal->tempat }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500">Anggaran</label>
                                    <p class="text-gray-900 font-semibold text-lg">Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500">Organisasi</label>
                                    <p class="text-gray-900">{{ $proposal->user->ormawa_name }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 block mb-2">File Proposal</label>
                                    <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download Proposal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    @if($proposal->catatan_bem || $proposal->catatan_admin)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Catatan</h3>
                                
                                @if($proposal->catatan_bem)
                                    <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                                        <p class="text-sm font-medium text-blue-900 mb-1">Catatan BEM:</p>
                                        <p class="text-gray-700">{{ $proposal->catatan_bem }}</p>
                                    </div>
                                @endif

                                @if($proposal->catatan_admin)
                                    <div class="p-4 bg-green-50 rounded-lg">
                                        <p class="text-sm font-medium text-green-900 mb-1">Catatan Admin:</p>
                                        <p class="text-gray-700">{{ $proposal->catatan_admin }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Status Proposal</h3>
                            
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'yellow', 'text' => 'Menunggu Persetujuan BEM', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                    'approved_bem' => ['color' => 'blue', 'text' => 'Disetujui BEM - Menunggu Admin', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                    'approved_admin' => ['color' => 'green', 'text' => 'Disetujui - Siap Dilaksanakan', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                    'rejected' => ['color' => 'red', 'text' => 'Ditolak', 'icon' => 'M6 18L18 6M6 6l12 12']
                                ];
                                $status = $statusConfig[$proposal->status];
                            @endphp

                            <div class="flex items-center p-4 bg-{{ $status['color'] }}-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-{{ $status['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-{{ $status['color'] }}-900">
                                        {{ $status['text'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="mt-6 space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Diajukan</p>
                                        <p class="text-xs text-gray-500">{{ $proposal->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full {{ in_array($proposal->status, ['approved_bem', 'approved_admin']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Persetujuan BEM</p>
                                        <p class="text-xs text-gray-500">
                                            {{ in_array($proposal->status, ['approved_bem', 'approved_admin']) ? 'Disetujui' : 'Menunggu' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full {{ $proposal->status === 'approved_admin' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Persetujuan Admin</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $proposal->status === 'approved_admin' ? 'Disetujui' : 'Menunggu' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if(Auth::user()->role === 'bem' && $proposal->status === 'pending')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4">Aksi</h3>
                                
                                <form action="{{ route('proposals.approve-bem', $proposal) }}" method="POST" class="mb-3">
                                    @csrf
                                    <textarea name="catatan_bem" rows="3" placeholder="Catatan (opsional)"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-3"></textarea>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Setujui Proposal
                                    </button>
                                </form>

                                <form action="{{ route('proposals.reject', $proposal) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak proposal ini?')">
                                    @csrf
                                    <textarea name="catatan" rows="2" placeholder="Alasan penolakan (wajib)" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 mb-3"></textarea>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Tolak Proposal
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->role === 'admin' && $proposal->status === 'approved_bem')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4">Aksi Admin</h3>
                                
                                <form action="{{ route('proposals.approve-admin', $proposal) }}" method="POST" class="mb-3">
                                    @csrf
                                    <textarea name="catatan_admin" rows="3" placeholder="Catatan (opsional)"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-3"></textarea>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                        Setujui & Buat Kegiatan
                                    </button>
                                </form>

                                <form action="{{ route('proposals.reject', $proposal) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak proposal ini?')">
                                    @csrf
                                    <textarea name="catatan" rows="2" placeholder="Alasan penolakan (wajib)" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 mb-3"></textarea>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        Tolak Proposal
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Activity Link -->
                    @if($proposal->activity && $proposal->status === 'approved_admin')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4">Kegiatan</h3>
                                <a href="{{ route('activities.show', $proposal->activity) }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Lihat Detail Kegiatan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>