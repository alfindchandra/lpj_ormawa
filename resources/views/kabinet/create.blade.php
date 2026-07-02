<x-app-layout>
    @section('title', 'Tambah Pengurus Inti')

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kabinet.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800">➕ Tambah Pengurus Inti</h2>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-blue-600 text-white">
                <h3 class="font-semibold text-lg">Data Kepengurusan Inti</h3>
                <p class="text-blue-100 text-sm mt-1">Isi data lengkap pengurus inti sesuai masa jabatan kabinet</p>
            </div>

            <form action="{{ route('kabinet.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                {{-- Errors --}}
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
                @endif

                {{-- Row 1: Periode & Tipe --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Periode Masa Jabatan <span class="text-red-500">*</span></label>
                        <select name="period_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('period_id') border-red-500 @enderror">
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periods as $p)
                            <option value="{{ $p->id }}" {{ (old('period_id', $activePeriod?->id) == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }} ({{ $p->tahun_mulai }}/{{ $p->tahun_selesai }}) {{ $p->is_active ? '✓ Aktif' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Organisasi <span class="text-red-500">*</span></label>
                        <select name="ormawa_type" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ormawa_type') border-red-500 @enderror">
                            <option value="ormawa" {{ old('ormawa_type') === 'ormawa' ? 'selected' : '' }}>🌐 Ormawa (Organisasi Mahasiswa)</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2: Nama Ormawa & Nama Kabinet --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Ormawa/UKM/HMP <span class="text-red-500">*</span>
                        </label>
                        <select name="ormawa_name" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ormawa_name') border-red-500 @enderror">
                            
                            @if(auth()->user()->role === 'admin')
                                {{-- TAMPILAN UNTUK ADMIN: Bisa memilih semua ormawa --}}
                                <option value="">-- Pilih Ormawa/UKM/HMP --</option>
                                
                                @foreach($ormawas as $o)
                                    <option value="{{ $o->ormawa_name }}" {{ old('ormawa_name') == $o->ormawa_name ? 'selected' : '' }}>
                                        {{ $o->ormawa_name }} ({{ strtoupper($o->ormawa_type) }})
                                    </option>
                                @endforeach

                            @else
                                {{-- TAMPILAN UNTUK USER BIASA: Langsung terkunci ke ormawa tempat dia login --}}
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
                        <input type="text" name="nama_kabinet" value="{{ old('nama_kabinet') }}" 
                            placeholder="cth: Kabinet Cakrawala (opsional)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_kabinet') border-red-500 @enderror">
                        @error('nama_kabinet')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-100 pt-2">
                    <p class="text-sm font-bold text-gray-600 mb-4">👤 Data Pengurus Inti</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <span class="inline-block w-3 h-3 bg-blue-500 rounded mr-1.5"></span>
                                Nama Ketua <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua') }}" required placeholder="Nama lengkap ketua"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_ketua') border-red-500 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <span class="inline-block w-3 h-3 bg-purple-500 rounded mr-1.5"></span>
                                Nama Wakil Ketua
                            </label>
                            <input type="text" name="nama_wakil" value="{{ old('nama_wakil') }}" placeholder="Nama lengkap wakil ketua"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <span class="inline-block w-3 h-3 bg-emerald-500 rounded mr-1.5"></span>
                                Nama Bendahara
                            </label>
                            <input type="text" name="nama_bendahara" value="{{ old('nama_bendahara') }}" placeholder="Nama lengkap bendahara"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <span class="inline-block w-3 h-3 bg-amber-500 rounded mr-1.5"></span>
                                Nama Sekretaris
                            </label>
                            <input type="text" name="nama_sekretaris" value="{{ old('nama_sekretaris') }}" placeholder="Nama lengkap sekretaris"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="border-t border-gray-100 pt-2">
                    <p class="text-sm font-bold text-gray-600 mb-4">📅 Masa Jabatan</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Dilantik <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_dilantik" value="{{ old('tanggal_dilantik') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_dilantik') border-red-500 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai Jabatan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_selesai') border-red-500 @enderror">
                        </div>
                    </div>
                </div>

                {{-- Status & Keterangan --}}
                <div class="border-t border-gray-100 pt-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="text-sm font-semibold text-gray-700">
                            Kabinet Sedang Aktif (masa jabatan berlangsung saat ini)
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="3" placeholder="Catatan atau keterangan tambahan (opsional)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('kabinet.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow transition">
                        💾 Simpan Pengurus Inti
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
