<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight leading-tight">
                {{ __('Manajemen Akun ORMAWA') }}
            </h2>
            <!-- Tambah Tombol Aksi Utama (Meningkatkan UX) -->
            <a href="{{ route('register') }}" class="inline-flex items-center mr-4 px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm w-fit">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Akun Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen" x-data="{ currentUser: { id: '', name: '', email: '', role: '' } }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Sukses (Lebih Estetik dengan Ikon) -->
            @if (session('status') === 'user-updated')
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm text-sm font-medium flex items-center">
                    <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Akun ORMAWA berhasil diperbarui beserta perubahan password (jika ada).</span>
                </div>
            @endif
            
            @if (session('status') === 'user-deleted')
                <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-xl shadow-sm text-sm font-medium flex items-center">
                    <svg class="w-5 h-5 mr-3 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Akun ORMAWA telah dihapus permanen dari sistem.</span>
                </div>
            @endif

            <!-- Tabel Daftar Akun -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200/80">
                <div class="p-0 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6">Nama Akun / ORMAWA</th>
                                    <th class="py-4 px-6">Email</th>
                                    <th class="py-4 px-6">Role Sistem</th>
                                    <th class="py-4 px-6 text-center">Aksi Operasional</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach ($users as $user)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="py-4 px-6 font-semibold text-gray-900">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 font-mono text-xs">{{ $user->email }}</td>
                                    <td class="py-4 px-6">
                                        @php
                                            $badgeClass = match($user->role) {
                                                'bem' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/10',
                                                'hmp' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-600/10',
                                                'ukm' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/10',
                                                default => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-md {{ $badgeClass }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center space-x-3">
                                        <!-- Tombol Edit -->
                                        <button @click="currentUser = {{ json_encode($user) }}; $dispatch('open-modal', 'edit-user-modal')" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold transition text-xs bg-indigo-50 hover:bg-indigo-100/80 px-2.5 py-1.5 rounded-lg">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit & Sandi
                                        </button>
                                        
                                        <!-- Tombol Hapus (Proteksi Diri Sendiri) -->
                                        @if(auth()->id() !== $user->id)
                                        <button @click="currentUser = {{ json_encode($user) }}; $dispatch('open-modal', 'delete-user-modal')" class="inline-flex items-center text-rose-600 hover:text-rose-900 font-semibold transition text-xs bg-rose-50 hover:bg-rose-100/80 px-2.5 py-1.5 rounded-lg">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                        @else
                                        <span class="text-xs text-gray-400 italic">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MODAL 1: EDIT INFORMASI & UPDATE PASSWORD -->
            <x-modal name="edit-user-modal" focusable>
                <form :action="'/user-management/' + currentUser.id" method="post" class="p-6">
                    @csrf
                    @method('patch')

                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <span class="bg-indigo-100 text-indigo-700 p-1.5 rounded-lg mr-2.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            Edit Kredensial: <span x-text="currentUser.name" class="ml-1 text-indigo-600"></span>
                        </h2>
                        <button type="button" @click="$dispatch('close-modal', 'edit-user-modal')" class="text-gray-400 hover:text-gray-600">✕</button>
                    </div>
                    
                    <p class="text-xs text-amber-600 bg-amber-50 p-2.5 rounded-lg border border-amber-200/60 mb-4">
                        💡 Kosongkan kolom sandi jika tidak ingin memperbarui password user tersebut.
                    </p>

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="edit_name" value="Nama Akun" />
                            <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full bg-gray-50/50" x-model="currentUser.name" required />
                        </div>

                        <div>
                            <x-input-label for="edit_email" value="Email" />
                            <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full bg-gray-50/50" x-model="currentUser.email" required />
                        </div>

                        <div>
                            <x-input-label for="edit_role" value="Role Sistem" />
                            <select id="edit_role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" x-model="currentUser.role">
                                <option value="bem">BEM</option>
                                <option value="hmp">HMP</option>
                                <option value="ukm">UKM</option>
                                <option value="ormawa">ORMAWA</option>
                            </select>
                        </div>

                        <!-- Sesi Update Password Akun Terpilih -->
                        <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-200/60 space-y-3">
                            <span class="text-xs font-bold uppercase text-gray-500 tracking-wider block">Ganti Kata Sandi (Opsional)</span>
                            <div>
                                <x-input-label for="edit_password" value="Sandi Baru" />
                                <x-text-input id="edit_password" name="password" type="password" class="mt-1 block w-full bg-white" placeholder="Minimal 8 karakter" />
                            </div>
                            <div>
                                <x-input-label for="edit_password_confirmation" value="Konfirmasi Sandi Baru" />
                                <x-text-input id="edit_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-white" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3 border-t border-gray-100 pt-4">
                        <x-secondary-button type="button" @click="$dispatch('close-modal', 'edit-user-modal')">Batal</x-secondary-button>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </x-modal>

            <!-- MODAL 2: KONFIRMASI HAPUS AKUN PERMANEN -->
            <x-modal name="delete-user-modal" focusable>
                <form :action="'/user-management/' + currentUser.id" method="post" class="p-6">
                    @csrf
                    @method('delete')

                    <div class="flex items-start space-x-4">
                        <div class="p-3 bg-red-100 text-red-600 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-lg font-bold text-gray-900">
                                Konfirmasi Penghapusan Akun
                            </h2>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                Apakah Anda yakin ingin menghapus akun <strong class="text-gray-950 font-semibold" x-text="currentUser.name"></strong> secara permanen? Tindakan ini tidak bisa dibatalkan dan akan mencabut seluruh hak akses log masuk sistem ormawa terkait.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3 border-t border-gray-100 pt-4">
                        <x-secondary-button type="button" @click="$dispatch('close-modal', 'delete-user-modal')">Batal</x-secondary-button>
                        <x-danger-button type="submit">Ya, Hapus Akun Permanen</x-danger-button>
                    </div>
                </form>
            </x-modal>

        </div>
    </div>
</x-app-layout>