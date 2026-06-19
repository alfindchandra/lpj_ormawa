{{--
    Ganti bagian "Detail Anggaran" di dalam proposals/show.blade.php
    (dari <!-- Detail Anggaran --> sampai penutup </div> section itu)
    dengan kode di bawah ini.

    Pastikan di ProposalController::show() sudah ada:
        $proposal->load(['user', 'activity', 'period', 'internalItems', 'externalItems', 'barangItems']);
--}}

<!-- Detail Anggaran -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Detail Anggaran</h3>

        <div class="space-y-6">

            {{-- ── INTERNAL ITEMS ──────────────────────────────────────────── --}}
            @if($proposal->internalItems->isNotEmpty())
            <div>
                <p class="text-sm font-medium text-gray-500 mb-2">Internal: Anggaran Perlengkapan &amp; Kegiatan</p>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Barang / Item</th>
                                <th class="px-4 py-3 text-center w-20">Jumlah</th>
                                <th class="px-4 py-3 text-right w-36">Harga/Satuan</th>
                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposal->internalItems as $item)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-gray-700">{{ $item->nama ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="border-t bg-gray-50">
                                <td colspan="3" class="px-4 py-2 text-right text-xs font-medium text-gray-500">Subtotal Internal</td>
                                <td class="px-4 py-2 text-right font-bold text-gray-700">
                                    Rp {{ number_format($proposal->internalItems->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- ── EXTERNAL ITEMS (Jasa) ───────────────────────────────────── --}}
            @if($proposal->externalItems->isNotEmpty())
            <div>
                <p class="text-sm font-medium text-gray-500 mb-2">Eksternal: Jasa / Layanan</p>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Jasa / Layanan</th>
                                <th class="px-4 py-3 text-center w-20">Jumlah</th>
                                <th class="px-4 py-3 text-right w-36">Harga/Satuan</th>
                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposal->externalItems as $item)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-gray-700">{{ $item->jasa ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="border-t bg-gray-50">
                                <td colspan="3" class="px-4 py-2 text-right text-xs font-medium text-gray-500">Subtotal Jasa</td>
                                <td class="px-4 py-2 text-right font-bold text-gray-700">
                                    Rp {{ number_format($proposal->externalItems->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- ── BARANG ITEMS ─────────────────────────────────────────────── --}}
            @if($proposal->barangItems->isNotEmpty())
            <div>
                <p class="text-sm font-medium text-gray-500 mb-2">Barang: ATK / Perlengkapan</p>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Barang</th>
                                <th class="px-4 py-3 text-center w-20">Jumlah</th>
                                <th class="px-4 py-3 text-right w-36">Harga/Satuan</th>
                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposal->barangItems as $item)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-gray-700">{{ $item->nama ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="border-t bg-gray-50">
                                <td colspan="3" class="px-4 py-2 text-right text-xs font-medium text-gray-500">Subtotal Barang</td>
                                <td class="px-4 py-2 text-right font-bold text-gray-700">
                                    Rp {{ number_format($proposal->barangItems->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Fallback jika belum ada item sama sekali --}}
            @if($proposal->internalItems->isEmpty() && $proposal->externalItems->isEmpty() && $proposal->barangItems->isEmpty())
            <p class="text-sm text-gray-400 italic">Belum ada rincian item anggaran.</p>
            @endif

            {{-- ── TOTAL ANGGARAN ──────────────────────────────────────────── --}}
            <div class="pt-4 border-t-2 border-gray-200">
                <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <span class="text-sm font-semibold text-blue-900">Total Anggaran</span>
                    <span class="text-2xl font-bold text-blue-900">
                        Rp {{ number_format($proposal->anggaran ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>