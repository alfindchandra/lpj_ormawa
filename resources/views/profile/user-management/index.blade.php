<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Akun ORMAWA') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50" x-data="{ openEdit: false, openDelete: false, currentUser: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if (session('status') === 'user-updated')
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm text-sm font-medium">
                    ✓ Akun ORMAWA berhasil diperbarui beserta perubahan password (jika ada).
                </div>
            @endif
            @if (session('status') === 'user-deleted')
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow-sm text-sm font-medium">
                    ✓ Akun ORMAWA telah dihapus permanen dari sistem.
                </div>
            @endif

            <!-- Tabel Daftar Akun -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-sm font-semibold uppercase tracking-wider border-b border-gray-100">
                                    <th class="p-4">Nama Akun / ORMAWA</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Role Sistem</th>
                                    <th class="p-4 text-center">Aksi Operasional</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach ($users as $user)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="p-4 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $user->role === 'bem' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center space-x-2">
                                        <!-- Tombol Pemicu Edit (Mengisi data ke Alpine.js) -->
                                        <button @click="currentUser = {{ json_encode($user) }}; openEdit = true" class="text-indigo-600 hover:text-indigo-900 font-medium transition">
                                            Edit & Sandi
                                        </button>
                                        
                                        @if(auth()->id() !== $user->id)
                                        <button @click="currentUser = {{ json_encode($user) }}; openDelete = true" class="text-red-600 hover:text-red-900 font-medium transition">
                                            Hapus
                                        </button>
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
            <x-modal name="edit-user-modal" show="openEdit" focusable>
                <form :action="'/user-management/' + currentUser.id" method="post" class="p-6">
                    @csrf
                    @method('patch')

                    <h2 class="text-lg font-bold text-gray-900">Edit Akun: <span x-text="currentUser.name"></span></h2>
                    <p class="text-xs text-gray-500 mt-1">Kosongkan kolom sandi jika tidak ingin memperbarui password user tersebut.</p>

                    <div class="mt-4 space-y-4">
                        <div>
                            <x-input-label for="name" value="Nama Akun" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" ::value="currentUser.name" required />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" ::value="currentUser.email" required />
                        </div>

                        <div>
                            <x-input-label for="role" value="Role" />
                            <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="currentUser.role">
                                <option value="bem">BEM</option>
                                <option value="hmp">HMP</option>
                                <option value="ukm">UKM</option>
                                <option value="ormawa">ORMAWA</option>
                            </select>
                        </div>

                        <!-- Sesi Update Password Akun Terpilih -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 space-y-3">
                            <span class="text-xs font-bold uppercase text-gray-400 tracking-wider">Perbarui Kredensial Sandi</span>
                            <div>
                                <x-input-label for="password" value="Sandi Baru" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Minimal 8 karakter" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" value="Konfirmasi Sandi Baru" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <x-secondary-button @click="openEdit = false">Batal</x-secondary-button>
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </x-modal>

            <!-- MODAL 2: KONFIRMASI HAPUS AKUN PERMANEN -->
            <x-modal name="delete-user-modal" show="openDelete" focusable>
                <form :action="'/user-management/' + currentUser.id" method="post" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-bold text-gray-900 text-red-600 flex items-center">
                        ⚠️ Konfirmasi Penghapusan Akun
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Apakah Anda yakin ingin menghapus akun <strong x-text="currentUser.name"></strong> secara permanen? Tindakan ini akan mencabut seluruh hak akses log masuk ormawa terkait.
                    </p>

                    <div class="mt-6 flex justify-end space-x-3">
                        <x-secondary-button @click="openDelete = false">Batal</x-secondary-button>
                        <x-danger-button>Ya, Hapus Akun</x-danger-button>
                    </div>
                </form>
            </x-modal>

        </div>
    </div>
</x-app-layout>