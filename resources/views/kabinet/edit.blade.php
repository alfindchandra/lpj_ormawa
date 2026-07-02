<x-app-layout>
    @section('title', 'Edit Pengurus Inti')

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kabinet.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800">✏️ Edit Pengurus Inti — {{ $kabinet->ormawa_name }}</h2>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-teal-600 text-white">
                <h3 class="font-semibold text-lg">Perbarui Data Kepengurusan</h3>
                <p class="text-amber-100 text-sm mt-1">{{ $kabinet->ormawa_name }} • {{ $kabinet->period->nama_periode ?? '-' }}</p>
            </div>

            <form id="update-form" action="{{ route('kabinet.update', $kabinet) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
                @endif

                {{-- Row 1: Periode Masa Jabatan & Tipe Organisasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Periode Masa Jabatan <span class="text-red-500">*</span></label>
                        <select name="period_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('period_id') border-red-500 @enderror">
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periods as $p)
                            <option value="{{ $p->id }}" {{ (old('period_id', $kabinet->period_id) == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }} ({{ $p->tahun_mulai }}/{{ $p->tahun_selesai }}) {{ $p->is_active ? '✓ Aktif' : '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('period_id')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Organisasi <span class="text-red-500">*</span></label>
                        <select name="ormawa_type" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ormawa_type') border-red-500 @enderror">
                            <option value="ormawa" {{ old('ormawa_type', $kabinet->ormawa_type) === 'ormawa' ? 'selected' : '' }}>🌐 Ormawa (Organisasi Mahasiswa)</option>
                        </select>
                        @error('ormawa_type')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: Nama Ormawa & Nama Kabinet --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Ormawa/UKM/HMP <span class="text-red-500">*</span>
                        </label>
                        <select name="ormawa_name" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ormawa_name') border-red-500 @enderror">
                            
                            @if(auth()->user()->role === 'admin')
                                {{-- TAMPILAN UNTUK ADMIN: Bisa melihat dan memilih semua ormawa --}}
                                <option value="">-- Pilih Ormawa/UKM/HMP --</option>
                                @foreach($ormawas as $o)
                                    <option value="{{ $o->ormawa_name }}" {{ old('ormawa_name', $kabinet->ormawa_name) == $o->ormawa_name ? 'selected' : '' }}>
                                        {{ $o->ormawa_name }} ({{ strtoupper($o->ormawa_type) }})
                                    </option>
                                @endforeach
                            @else
                                {{-- TAMPILAN UNTUK USER BIASA: Mengunci pilihan ke data ormawa milik user tersebut --}}
                                <option value="{{ auth()->user()->ormawa_name }}" selected>
                                    {{ auth()->user()->ormawa_name }}
                                </option>
                            @endif

                        </select>
                        @error('ormawa_name')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kabinet</label>
                        <input type="text" name="nama_kabinet" value="{{ old('nama_kabinet', $kabinet->nama_kabinet) }}" 
                            placeholder="cth: Kabinet Cakrawala (opsional)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_kabinet') border-red-500 @enderror">
                        @error('nama_kabinet')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-2">
                    <p class="text-sm font-bold text-gray-600 mb-4">👤 Data Pengurus Inti</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5"><span class="inline-block w-3 h-3 bg-blue-500 rounded mr-1.5"></span>Ketua <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $kabinet->nama_ketua) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5"><span class="inline-block w-3 h-3 bg-purple-500 rounded mr-1.5"></span>Wakil Ketua</label>
                            <input type="text" name="nama_wakil" value="{{ old('nama_wakil', $kabinet->nama_wakil) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5"><span class="inline-block w-3 h-3 bg-emerald-500 rounded mr-1.5"></span>Bendahara</label>
                            <input type="text" name="nama_bendahara" value="{{ old('nama_bendahara', $kabinet->nama_bendahara) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5"><span class="inline-block w-3 h-3 bg-amber-500 rounded mr-1.5"></span>Sekretaris</label>
                            <input type="text" name="nama_sekretaris" value="{{ old('nama_sekretaris', $kabinet->nama_sekretaris) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-2">
                    <p class="text-sm font-bold text-gray-600 mb-4">📅 Masa Jabatan</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Dilantik <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_dilantik" value="{{ old('tanggal_dilantik', $kabinet->tanggal_dilantik?->format('Y-m-d')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai Jabatan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kabinet->tanggal_selesai?->format('Y-m-d')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $kabinet->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label class="text-sm font-semibold text-gray-700" for="is_active">Kabinet Sedang Aktif</label>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan', $kabinet->keterangan) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <button type="submit" form="delete-form" class="px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                        🗑️ Hapus
                    </button>
                    
                    <div class="flex gap-3">
                        <a href="{{ route('kabinet.index') }}"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold text-white bg-amber-500 rounded-lg hover:bg-amber-600 shadow transition">
                            💾 Perbarui
                        </button>
                    </div>
                </div>
            </form>

            <form id="delete-form" action="{{ route('kabinet.destroy', $kabinet) }}" method="POST" class="hidden"
                onsubmit="return confirm('Yakin ingin menghapus data pengurus ini?')">
                @csrf 
                @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>