<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitoring Kegiatan: {{ $activity->proposal->nama_kegiatan }}
            </h2>
            <a href="{{ route('activities.index') }}" class="text-sm mx-4 text-blue-600 hover:text-blue-800">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi Proposal
                            </h3>

                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Kode Proposal:</span>
                                    <p class="font-semibold text-gray-900">{{ $activity->proposal->kode_proposal }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Organisasi:</span>
                                    <p class="font-semibold text-gray-900">{{ $activity->user->ormawa_name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Tanggal:</span>
                                    <p class="font-semibold text-gray-900">
                                        {{ $activity->proposal->tanggal_mulai->format('d/m/Y') }} - {{ $activity->proposal->tanggal_selesai->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Tempat:</span>
                                    <p class="font-semibold text-gray-900">{{ $activity->proposal->tempat }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Anggaran:</span>
                                    <p class="font-semibold text-gray-900">Rp {{ number_format($activity->proposal->anggaran, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Jumlah Peserta:</span>
                                    <p class="font-semibold text-gray-900">{{ $activity->jumlah_peserta ?? 'Belum diisi' }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('proposals.show', $activity->proposal) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                    Lihat Detail Proposal →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status Form (Hanya Pembuat Proposal/Kegiatan) -->
                    @if(in_array(Auth::user()->role, ['ormawa', 'bem', 'ukm', 'hmp']) && Auth::id() === $activity->user_id)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Update Status Kegiatan</h3>

                            <form action="{{ route('activities.update-status', $activity) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="scheduled" {{ $activity->status === 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                                        <option value="ongoing" {{ $activity->status === 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                        <option value="completed" {{ $activity->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $activity->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Peserta</label>
                                    <input type="number" name="jumlah_peserta" value="{{ $activity->jumlah_peserta }}" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pelaksanaan</label>
                                    <textarea name="catatan_pelaksanaan" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $activity->catatan_pelaksanaan }}</textarea>
                                </div>

                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Upload Dokumentasi (Hanya Pembuat Proposal/Kegiatan) -->
                    @if(in_array(Auth::user()->role, ['ormawa', 'bem', 'ukm', 'hmp']) && Auth::id() === $activity->user_id)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Upload Dokumentasi</h3>

                            <form action="{{ route('activities.upload-documentation', $activity) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">File (JPG, PNG - Max 5MB)</label>
                                    <input type="file" name="file" accept=".jpg,.jpeg,.png" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                                    <input type="text" name="keterangan" placeholder="Contoh: Foto pembukaan acara" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Upload Dokumentasi
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Dokumentasi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Dokumentasi Kegiatan</h3>

                            @if($activity->documentations->isEmpty())
                            <p class="text-gray-500 text-center py-8">Belum ada dokumentasi yang diunggah</p>
                            @else
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($activity->documentations as $doc)
                                <div class="border rounded-lg overflow-hidden">
                                    @if(in_array($doc->file_type, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->keterangan }}" class="w-full h-40 object-cover">
                                    @else
                                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="p-2">
                                        <p class="text-xs text-gray-600 truncate">{{ $doc->keterangan ?? 'Dokumentasi' }}</p>
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800">Lihat</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- LPJ Section -->
                    @if($activity->lpj)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center justify-between">
                                <span>Laporan Pertanggungjawaban (LPJ)</span>
                                @php
                                $lpjStatusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $lpjStatusColors[$activity->lpj->status] }}">
                                    {{ strtoupper($activity->lpj->status) }}
                                </span>
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Laporan Kegiatan</label>
                                    <p class="text-gray-900">{{ $activity->lpj->laporan_kegiatan }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Anggaran Diajukan</label>
                                        <p class="text-gray-900 font-semibold">Rp {{ number_format($activity->proposal->anggaran, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Realisasi Anggaran</label>
                                        <p class="text-gray-900 font-semibold">Rp {{ number_format($activity->lpj->realisasi_anggaran, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                @if($activity->lpj->kendala)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Kendala</label>
                                    <p class="text-gray-700">{{ $activity->lpj->kendala }}</p>
                                </div>
                                @endif

                                @if($activity->lpj->solusi)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Solusi</label>
                                    <p class="text-gray-700">{{ $activity->lpj->solusi }}</p>
                                </div>
                                @endif

                                <div>
                                    <a href="{{ Storage::url($activity->lpj->file_lpj) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download LPJ
                                    </a>
                                </div>

                                @if($activity->lpj->catatan_verifikasi)
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <p class="text-sm font-medium text-blue-900 mb-1">Catatan Verifikasi:</p>
                                    <p class="text-gray-700">{{ $activity->lpj->catatan_verifikasi }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Admin Verification -->
                            @if(Auth::user()->role === 'admin' && $activity->lpj->status === 'pending')
                            <form action="{{ route('lpj.verify', $activity->lpj) }}" method="POST" class="mt-6">
                                @csrf
                                <textarea name="catatan_verifikasi" rows="2" placeholder="Catatan verifikasi (opsional)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-3"></textarea>

                                <div class="flex gap-3">
                                    <button type="submit" name="status" value="approved" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                        Setujui LPJ
                                    </button>
                                    <button type="submit" name="status" value="rejected" onclick="return confirm('Yakin ingin menolak LPJ ini?')" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        Tolak LPJ
                                    </button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                    @else
                        <!-- Tombol Buat LPJ (Hanya muncul jika berstatus 'completed' dan user login adalah pembuat proposal) -->
                        @if(in_array(Auth::user()->role, ['ormawa', 'bem', 'ukm', 'hmp']) && Auth::id() === $activity->user_id && $activity->status === 'completed')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-yellow-900 mb-2">LPJ Belum Dibuat</h4>
                                    <p class="text-sm text-yellow-700 mb-4">Kegiatan sudah selesai. Silakan buat laporan pertanggungjawaban (LPJ).</p>
                                    <a href="{{ route('lpj.create', $activity) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                                        Buat LPJ Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Status Kegiatan</h3>

                            @php
                            $activityStatusConfig = [
                                'scheduled' => ['color' => 'blue', 'text' => 'Dijadwalkan', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                'ongoing' => ['color' => 'yellow', 'text' => 'Sedang Berlangsung', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                'completed' => ['color' => 'green', 'text' => 'Selesai', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                'cancelled' => ['color' => 'red', 'text' => 'Dibatalkan', 'icon' => 'M6 18L18 6M6 6l12 12']
                            ];
                            $actStatus = $activityStatusConfig[$activity->status];
                            @endphp

                            <div class="flex items-center p-4 bg-{{ $actStatus['color'] }}-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-{{ $actStatus['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $actStatus['icon'] }}" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-{{ $actStatus['color'] }}-900">
                                        {{ $actStatus['text'] }}
                                    </p>
                                </div>
                            </div>

                            @if($activity->catatan_pelaksanaan)
                            <div class="mt-4 p-3 bg-gray-50 rounded">
                                <p class="text-xs font-medium text-gray-600 mb-1">Catatan:</p>
                                <p class="text-sm text-gray-800">{{ $activity->catatan_pelaksanaan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Statistik</h3>

                            <div class="space-y-3">
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-sm text-gray-600">Total Dokumentasi</span>
                                    <span class="font-semibold text-gray-900">{{ $activity->documentations->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-sm text-gray-600">Status LPJ</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $activity->lpj ? ucfirst($activity->lpj->status) : 'Belum dibuat' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Dibuat</span>
                                    <span class="font-semibold text-gray-900">{{ $activity->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>