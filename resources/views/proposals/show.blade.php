<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Proposal: {{ $proposal->kode_proposal }}
            </h2>
            <a href="{{ route('proposals.index') }}" class="text-sm mx-4 text-blue-600 hover:text-blue-800">
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
                                    <label class="text-sm font-medium text-gray-500">Tipe Lokasi</label>
                                    <p class="text-gray-900">
                                        @if($proposal->tipe_lokasi === 'internal')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Internal Kampus
                                        </span>
                                        @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            Eksternal Kampus
                                        </span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tempat Pelaksanaan</label>
                                    <p class="text-gray-900">{{ $proposal->tempat }}</p>
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Proposal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Anggaran -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Detail Anggaran</h3>

                            <div class="space-y-6">
                                {{-- 1. INTERNAL ITEMS --}}
                                @if(!empty($proposal->internal_items) && count($proposal->internal_items) > 0)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Internal: Anggaran Perlengkapan & Kegiatan</label>
                                    <div class="overflow-x-auto border rounded-lg">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">Nama Barang / Item</th>
                                                    <th class="px-4 py-3 text-center">Jumlah</th>
                                                    <th class="px-4 py-3 text-right">Harga/Satuan</th>
                                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($proposal->internal_items as $item)
                                                <tr class="border-t">
                                                    <td class="px-4 py-3 text-gray-700">{{ $item['nama'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-center text-gray-700">{{ $item['jumlah'] ?? 1 }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-700 font-semibold">
                                                        Rp {{ number_format(($item['jumlah'] ?? 1) * ($item['harga'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                                {{-- 2. EXTERNAL ITEMS --}}
                                @if(!empty($proposal->external_items) && count($proposal->external_items) > 0)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 block mb-2">External: Jasa MC dll</label>
                                    <div class="overflow-x-auto border rounded-lg">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">Jasa/Layanan</th>
                                                    <th class="px-4 py-3 text-center">Jumlah</th>
                                                    <th class="px-4 py-3 text-right">Harga/Satuan</th>
                                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($proposal->external_items as $item)
                                                <tr class="border-t">
                                                    <td class="px-4 py-3 text-gray-700">{{ $item['jasa'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-center text-gray-700">{{ $item['jumlah'] ?? 1 }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-700 font-semibold">
                                                        Rp {{ number_format(($item['jumlah'] ?? 1) * ($item['harga'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                                {{-- 3. BARANG ITEMS --}}
                                @if(!empty($proposal->barang_items) && count($proposal->barang_items) > 0)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Barang: ATK/Perlengkapan</label>
                                    <div class="overflow-x-auto border rounded-lg">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">Nama Barang</th>
                                                    <th class="px-4 py-3 text-center">Jumlah</th>
                                                    <th class="px-4 py-3 text-right">Harga/Satuan</th>
                                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($proposal->barang_items as $item)
                                                <tr class="border-t">
                                                    <td class="px-4 py-3 text-gray-700">{{ $item['nama'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-center text-gray-700">{{ $item['jumlah'] ?? 1 }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-700 font-semibold">
                                                        Rp {{ number_format(($item['jumlah'] ?? 1) * ($item['harga'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                                {{-- TOTAL ANGGARAN --}}
                                <div class="pt-4 border-t-2 border-gray-200">
                                    <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <label class="text-sm font-semibold text-blue-900">Total Anggaran</label>
                                        <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($proposal->anggaran ?? 0, 0, ',', '.') }}</p>
                                    </div>
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
                    <!-- Edit Button for Owner or Admin -->
                    @if(Auth::user()->id === $proposal->user_id)
                    @if($proposal->status === 'pending')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <a href="{{ route('proposals.edit', $proposal) }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Proposal
                            </a>
                        </div>
                    </div>
                    @endif
                    @endif

                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6">Status Proposal</h3>

                            <!-- Status List -->
                            <div class="space-y-4">
                                <!-- Status 1: Diajukan -->
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 pt-1">
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-green-500">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Proposal Diajukan</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $proposal->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Status 2: Persetujuan BEM -->
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 pt-1">
                                        @if(in_array($proposal->status, ['approved_bem', 'approved_admin']))
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-green-500">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @elseif($proposal->status === 'rejected')
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-red-500">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @else
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-gray-300">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Proposal disetujui BEM</p>
                                        <p class="text-xs text-gray-500">
                                            @if(in_array($proposal->status, ['approved_bem', 'approved_admin']))
                                            Disetujui
                                            @elseif($proposal->status === 'rejected')
                                            Ditolak
                                            @else
                                            Menunggu
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Status 3: Persetujuan Admin -->
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 pt-1">
                                        @if($proposal->status === 'approved_admin')
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-green-500">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @else
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-gray-300">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">Proposal disetujui Wakil Rektor 1</p>
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
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Proposal
                                </button>
                            </form>

                            <form action="{{ route('proposals.reject', $proposal) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menolak proposal ini?')">
                                @csrf
                                <textarea name="catatan" rows="2" placeholder="Alasan penolakan (wajib)" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 mb-3"></textarea>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
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
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Setujui & Buat Kegiatan
                                </button>
                            </form>

                            <form action="{{ route('proposals.reject', $proposal) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menolak proposal ini?')">
                                @csrf
                                <textarea name="catatan" rows="2" placeholder="Alasan penolakan (wajib)" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 mb-3"></textarea>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
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