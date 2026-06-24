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
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ══════════════════════════════════════════════════════════
                     MAIN CONTENT (kiri)
                ══════════════════════════════════════════════════════════ --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- ── Informasi Kegiatan ─────────────────────────────── --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Informasi Kegiatan</h3>
                            <div class="space-y-4">

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nama Kegiatan</p>
                                    <p class="text-gray-900 font-medium">{{ $proposal->nama_kegiatan }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Deskripsi</p>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $proposal->deskripsi }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Tanggal Mulai</p>
                                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($proposal->tanggal_mulai)->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Tanggal Selesai</p>
                                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($proposal->tanggal_selesai)->format('d F Y') }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500 my-2">Tipe Proposal</p>
                                    @if($proposal->type === 'dana')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Dana
                                    </span>
                                    @elseif($proposal->type === 'non_dana')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        Non-Dana
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Belum Ditentukan
                                    </span>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Tipe Lokasi</p>
                                    @if($proposal->tipe_lokasi === 'internal')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Internal Kampus
                                    </span>
                                    @elseif($proposal->tipe_lokasi === 'eksternal')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        Eksternal Kampus
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Belum Ditentukan
                                    </span>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Tempat Pelaksanaan</p>
                                    <p class="text-gray-900">{{ $proposal->tempat }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Organisasi</p>
                                    <p class="text-gray-900">{{ $proposal->user->ormawa_name ?? 'Ormawa' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">File Proposal</p>
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

                    {{-- ── Detail Anggaran ────────────────────────────────── --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Detail Anggaran</h3>

                            <div class="space-y-6">
                                @php
                                    // Kelompokkan item anggaran dinamis yang kuantitasnya > 0 dan nama tidak kosong
                                    $filteredItems = $proposal->items->filter(function($item) {
                                        return !empty($item->nama) && $item->jumlah > 0;
                                    })->groupBy('tipe');

                                    // Mapping label judul untuk mempercantik tampilan tabel kategori
                                    $labels = [
                                        'konsumsi'     => '1. Konsumsi (Makanan, Snack, Minuman)',
                                        'atk'          => '2. Barang Habis Pakai & ATK',
                                        'honor'        => '3. Honor dan Jasa (MC, Pemateri, dll)',
                                        'sewa'         => '4. Penyewaan Alat / Aula',
                                        'dokumentasi'  => '5. Dokumentasi & Penggandaan Kegiatan',
                                        'transportasi' => '5. Biaya Transportasi & Operasional',
                                    ];
                                @endphp

                                {{-- Loop hanya kategori yang terbukti memiliki data valid di database --}}
                                @forelse($filteredItems as $tipe => $items)
                                <div>
                                    <p class="text-sm font-semibold text-blue-800 mb-2">
                                        {{ $labels[$tipe] ?? text_transform(str_replace('_', ' ', $tipe)) }}
                                    </p>
                                    <div class="overflow-x-auto border rounded-lg">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">Nama Spesifikasi / Item</th>
                                                    <th class="px-4 py-3 text-center w-24">Kuantitas</th>
                                                    <th class="px-4 py-3 text-right w-36">Harga Satuan</th>
                                                    <th class="px-4 py-3 text-right w-36">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($items as $item)
                                                <tr class="hover:bg-gray-50/80 transition-colors">
                                                    <td class="px-4 py-3 text-gray-700 font-medium">{{ $item->nama }}</td>
                                                    <td class="px-4 py-3 text-center text-gray-600">{{ $item->jumlah }}</td>
                                                    <td class="px-4 py-3 text-right text-gray-600">
                                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-right font-semibold text-gray-800">
                                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-gray-50/50">
                                                <tr class="border-t font-semibold">
                                                    <td colspan="3" class="px-4 py-2.5 text-right text-xs text-gray-500">
                                                        Subtotal Kategori
                                                    </td>
                                                    <td class="px-4 py-2.5 text-right text-gray-900 bg-gray-50">
                                                        Rp {{ number_format($items->sum('subtotal'), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @empty
                                    {{-- KONDISI JIKA TIDAK ADA ITEM DENGAN JUMLAH > 0 SAMA SEKALI --}}
                                    @if(!($proposal->kebersihan_biaya > 0))
                                    <p class="text-sm text-gray-400 italic text-center py-6">
                                        Belum ada rincian item anggaran yang dimasukkan.
                                    </p>
                                    @endif
                                @endforelse

                                {{-- ── Tampilkan Biaya Kebersihan secara Mandiri jika > 0 ── --}}
                                @if($proposal->kebersihan_biaya > 0)
                                <div class="p-4 bg-gray-50 border rounded-lg">
                                    <p class="text-sm font-semibold text-gray-800 mb-1">6. Kebersihan Tempat Kegiatan</p>
                                    <p class="text-xs text-gray-500 mb-2">Keterangan: {{ $proposal->kebersihan_keterangan ?? 'Sewa petugas kebersihan' }}</p>
                                    <div class="flex justify-between text-sm font-medium pt-2 border-t border-gray-200">
                                        <span class="text-gray-600">Biaya Kebersihan</span>
                                        <span class="text-gray-900 font-bold">Rp {{ number_format($proposal->kebersihan_biaya, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @endif

                                {{-- TOTAL AKHIR ANGGARAN --}}
                                <div class="pt-4 border-t-2 border-gray-200">
                                    <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <span class="text-sm font-semibold text-blue-900">Total Anggaran Keseluruhan</span>
                                        <span class="text-2xl font-bold text-blue-900">
                                            Rp {{ number_format($proposal->anggaran ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ── Catatan BEM / Admin ────────────────────────────── --}}
                    @if($proposal->catatan_bem || $proposal->catatan_admin)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Catatan</h3>

                            @if($proposal->catatan_bem)
                            <div class="mb-3 p-4 bg-blue-50 rounded-lg">
                                <p class="text-sm font-medium text-blue-900 mb-1">Catatan BEM:</p>
                                <p class="text-gray-700 text-sm">{{ $proposal->catatan_bem }}</p>
                            </div>
                            @endif

                            @if($proposal->catatan_admin)
                            <div class="p-4 bg-green-50 rounded-lg">
                                <p class="text-sm font-medium text-green-900 mb-1">Catatan Admin:</p>
                                <p class="text-gray-700 text-sm">{{ $proposal->catatan_admin }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>{{-- end main content --}}

                {{-- ══════════════════════════════════════════════════════════
                     SIDEBAR (kanan)
                ══════════════════════════════════════════════════════════ --}}
                <div class="space-y-6">

                    {{-- Tombol Edit (hanya pemilik & status pending) --}}
                    @if(Auth::user()->id === $proposal->user_id && $proposal->status === 'pending')
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

                    {{-- Status Tracker --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6">Status Proposal</h3>

                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 pt-0.5">
                                        <div class="h-6 w-6 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Proposal Diajukan</p>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 pt-0.5">
                                        @if(in_array($proposal->status, ['approved_bem', 'approved_admin']))
                                        <div class="h-6 w-6 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @elseif($proposal->status === 'rejected')
                                        <div class="h-6 w-6 rounded-full bg-red-500 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @else
                                        <div class="h-6 w-6 rounded-full bg-gray-300"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Disetujui BEM</p>
                                        <p class="text-xs text-gray-500">
                                            @if(in_array($proposal->status, ['approved_bem', 'approved_admin'])) Disetujui
                                            @elseif($proposal->status === 'rejected') Ditolak
                                            @else Menunggu
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 pt-0.5">
                                        @if($proposal->status === 'approved_admin')
                                        <div class="h-6 w-6 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @else
                                        <div class="h-6 w-6 rounded-full bg-gray-300"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Disetujui Wakil Rektor 1</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $proposal->status === 'approved_admin' ? 'Disetujui' : 'Menunggu' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Aksi BEM --}}
                    @if(Auth::user()->role === 'bem' && $proposal->status === 'pending')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Aksi BEM</h3>

                            <form action="{{ route('proposals.approve-bem', $proposal) }}" method="POST" class="mb-3">
                                @csrf
                                <textarea name="catatan_bem" rows="3" placeholder="Catatan (opsional)"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-3 text-sm"></textarea>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Proposal
                                </button>
                            </form>

                            <form action="{{ route('proposals.reject', $proposal) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menolak proposal ini?')">
                                @csrf
                                <textarea name="catatan" rows="2" placeholder="Alasan penolakan (wajib)" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 mb-3 text-sm"></textarea>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Proposal
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Aksi Admin --}}
                    @if(Auth::user()->role === 'admin' && $proposal->status === 'approved_bem')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Aksi Admin</h3>

                            <form action="{{ route('proposals.approve-admin', $proposal) }}" method="POST" class="mb-3">
                                @csrf
                                <textarea name="catatan_admin" rows="3" placeholder="Catatan (opsional)"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-3 text-sm"></textarea>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Setujui &amp; Buat Kegiatan
                                </button>
                            </form>

                            <form action="{{ route('proposals.reject', $proposal) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menolak proposal ini?')">
                                @csrf
                                <textarea name="catatan" rows="2" placeholder="Alasan penolakan (wajib)" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 mb-3 text-sm"></textarea>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    Tolak Proposal
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Link ke Kegiatan --}}
                    @if($proposal->activity && $proposal->status === 'approved_admin')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Kegiatan</h3>
                            <a href="{{ route('activities.show', $proposal->activity) }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Lihat Detail Kegiatan
                            </a>
                        </div>
                    </div>
                    @endif

                </div>{{-- end sidebar --}}

            </div>
        </div>
    </div>
</x-app-layout>