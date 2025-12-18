<!-- resources/views/ormawa/profile.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil {{ Auth::user()->ormawa_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Avatar -->
                            <div class="text-center mb-6">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <span class="text-4xl font-bold text-white">
                                        {{ substr(Auth::user()->ormawa_name, 0, 2) }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->ormawa_name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Organisasi Mahasiswa</p>
                                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    Aktif
                                </span>
                            </div>

                            <!-- Info -->
                            <div class="border-t pt-6 space-y-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Ketua</label>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ Auth::user()->name }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Email</label>
                                    <p class="text-sm text-gray-900 mt-1">{{ Auth::user()->email }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Telepon</label>
                                    <p class="text-sm text-gray-900 mt-1">{{ Auth::user()->phone ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Bergabung</label>
                                    <p class="text-sm text-gray-900 mt-1">{{ Auth::user()->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h4 class="font-semibold mb-4">Statistik Kegiatan</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-sm text-gray-600">Total Kegiatan</span>
                                    <span class="font-semibold text-gray-900">{{ $total_activities ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-sm text-gray-600">Kegiatan Selesai</span>
                                    <span class="font-semibold text-green-600">{{ $completed_activities ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-sm text-gray-600">Kegiatan Berjalan</span>
                                    <span class="font-semibold text-yellow-600">{{ $ongoing_activities ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Anggaran</span>
                                    <span class="font-semibold text-blue-600">Rp {{ number_format($total_budget ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Edit Profile Form -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6">Edit Informasi Profil</h3>
                            
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')

                                <!-- Nama Ketua -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Ketua <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Telepon -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Organisasi (Read-only) -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Organisasi
                                    </label>
                                    <input type="text" value="{{ Auth::user()->ormawa_name }}" readonly
                                        class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm cursor-not-allowed">
                                    <p class="mt-1 text-xs text-gray-500">Nama organisasi tidak dapat diubah. Hubungi admin jika perlu perubahan.</p>
                                </div>

                                <div class="flex gap-4">
                                    <button type="submit" 
                                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                        Simpan Perubahan
                                    </button>
                                    <a href="{{ route('dashboard') }}" 
                                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6">Ubah Password</h3>
                            
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                @method('PUT')

                                <!-- Current Password -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Saat Ini <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="current_password" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Baru <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-red-50 border border-red-200 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-red-900 mb-2">Zona Berbahaya</h3>
                            <p class="text-sm text-red-700 mb-4">
                                Tindakan berikut tidak dapat dibatalkan. Pastikan Anda yakin sebelum melanjutkan.
                            </p>
                            
                            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Semua data akan hilang permanen!');">
                                @csrf
                                @method('DELETE')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-red-900 mb-2">
                                        Ketik password Anda untuk konfirmasi
                                    </label>
                                    <input type="password" name="password" required
                                        class="w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                </div>

                                <button type="submit" 
                                    class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">
                                    Hapus Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>