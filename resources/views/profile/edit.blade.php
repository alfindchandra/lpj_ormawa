<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <!-- Icon User / Akun -->
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pengaturan Akun BEM') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Breadcrumbs / Penunjuk Halaman Semu -->
            <div class="text-sm text-gray-500 px-4 sm:px-0">
                <span>Dashboard</span> / <span class="text-gray-800 font-medium">Pengaturan Akun</span>
            </div>

            <!-- CARD 1: Update Informasi Profil (Nama & Email) -->
            <div class="p-6 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-xl transition duration-200 hover:shadow-md">
                <div class="max-w-xl">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Informasi Profil BEM</h3>
                        <p class="text-sm text-gray-600 mt-1">Perbarui nama identitas organisasi kabinet BEM dan alamat email resmi Anda.</p>
                    </div>
                    <hr class="border-gray-100 mb-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- CARD 2: Update Password Keamanan -->
            <div class="p-6 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-xl transition duration-200 hover:shadow-md">
                <div class="max-w-xl">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Sandi & Keamanan</h3>
                        <p class="text-sm text-gray-600 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan data.</p>
                    </div>
                    <hr class="border-gray-100 mb-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- CARD 3: Hapus Akun (Zona Bahaya) -->
            <div class="p-6 sm:p-8 bg-white shadow-sm border border-red-100 bg-red-50/30 sm:rounded-xl transition duration-200 hover:shadow-md">
                <div class="max-w-xl">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-red-600 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Hapus Akun Permanen
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Setelah akun dihapus, semua data proposal, laporan kegiatan (LPJ), dan arsip di dalamnya akan terhapus secara permanen.</p>
                    </div>
                    <hr class="border-red-100 mb-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>