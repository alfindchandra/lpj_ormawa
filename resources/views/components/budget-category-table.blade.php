@props([
    'title',
    'subtitle',
    'section',
    'items' => [['nama' => '', 'jumlah' => '', 'harga' => '']], // DIUBAH: default jumlah kosong (''), bukan 1
    'placeholder' => '',
    'unitLabel' => 'item'
])

<div id="cat-{{ $section }}" {{ $attributes->merge(['class' => 'rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm']) }}>
    <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
        <div>
            <h4 class="text-sm font-semibold text-gray-800">{{ $title }}</h4>
            <span class="text-xs text-gray-500">{{ $subtitle }}</span>
        </div>
        <button type="button" onclick="addRow('{{ $section }}')"
            class="px-3 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded text-xs font-semibold flex items-center gap-1 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Baris
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50/70 text-gray-600 font-medium text-left">
                <tr>
                    <th class="px-4 py-2 w-5/12">Nama Spesifikasi / Item</th>
                    <th class="px-4 py-2 w-2/12">Vol / Kuantitas</th>
                    <th class="px-4 py-2 w-2/12">Harga Satuan (Rp)</th>
                    <th class="px-4 py-2 w-2/12 text-right">Jumlah (Rp)</th>
                    <th class="px-4 py-2 w-1/12 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody-{{ $section }}" class="divide-y divide-gray-200">
                @foreach ($items as $index => $item)
                <tr class="item-row" data-section="{{ $section }}">
                    <td class="px-4 py-2">
                        <input type="text" 
                            name="{{ $section }}_items[{{ $index }}][nama]"
                            value="{{ old($section.'._items.'.$index.'.nama', $item['nama'] ?? '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                            placeholder="{{ $placeholder }}">
                    </td>
                    
                    <td class="px-4 py-2">
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" 
                                name="{{ $section }}_items[{{ $index }}][jumlah]"
                                value="{{ old($section.'._items.'.$index.'.jumlah', $item['jumlah'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm pr-12 jumlah-input"
                                min="0" placeholder="0" oninput="recalcRow(this)">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-xs">{{ $unitLabel }}</span>
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-4 py-2">
                        <input type="number" 
                            name="{{ $section }}_items[{{ $index }}][harga]"
                            value="{{ old($section.'._items.'.$index.'.harga', $item['harga'] ?? '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm harga-input"
                            step="1" min="0" placeholder="0" oninput="recalcRow(this)">
                    </td>
                    
                    <td class="px-4 py-2 text-right text-gray-700 font-medium subtotal-display align-middle">
                        Rp 0
                    </td>
                    
                    <td class="px-4 py-2 text-center align-middle">
                        <button type="button" onclick="removeRow(this)"
                            class="text-gray-400 hover:text-red-500 text-lg p-1 transition-colors leading-none">
                            &times;
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>