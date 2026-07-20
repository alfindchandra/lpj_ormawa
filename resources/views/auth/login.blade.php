<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen bg-gradient-to-br from-emerald-50/40 via-white to-emerald-50/30 font-sans antialiased py-12">
        <div class="max-w-5xl mx-auto px-4">
            
            <!-- Logo & Judul Utama -->
            <div class="text-center mb-10">
                <a href="#" class="inline-flex justify-center mb-6">
                    <img class="w-48 object-contain" src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">
                    Sistem Monitoring Organisasi Mahasiswa
                </h1>
                <p class="mt-2 text-sm md:text-base text-gray-600">
                    IKIP PGRI Bojonegoro
                </p>
            </div>

            <!-- Layout Grid Utama (Kiri: Login, Kanan: Registrasi) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                
                <!-- KOLOM KIRI: CARD LOGIN -->
                <div class="bg-white rounded-2xl shadow-xl shadow-emerald-900/5 border border-gray-100 overflow-hidden">
                    <!-- Header Card (Hijau Gradasi) -->
                    <div class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-500 p-6 text-white relative overflow-hidden">
                        <!-- Dekorasi Lingkaran Abstrak -->
                        <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-white/10 pointer-events-none"></div>
                        
                        <div class="flex items-center space-x-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center text-xl backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-lg font-bold tracking-wide">Masuk ke Sistem</h5>
                                <p class="text-xs text-emerald-100/90 mt-0.5">Silakan masukkan kredensial Anda</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body Card Form -->
                    <div class="p-6 md:p-8 bg-gray-50/30">
                        <form method="POST" action="{{ route('login') }}" id="main_form" class="space-y-5">
                            @csrf
                            
                            <!-- Input Email -->
                            <div class="space-y-1">
                                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                                <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-gray-50/50 focus-within:border-emerald-500 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                                    <div class="absolute left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="email"
                                        class="block w-full pl-11 pr-4 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none"
                                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                        placeholder="Ormawa@ikippgribojonegoro.ac.id" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Input Password -->
                            <div class="space-y-1" x-data="{ showPassword: false }">
                                <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700 font-medium" />

                                <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-gray-50/50 focus-within:border-emerald-500 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                                    <div class="absolute left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>

                                    <x-text-input id="password"
                                        class="block w-full pl-11 pr-11 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none"
                                        x-bind:type="showPassword ? 'text' : 'password'" name="password" required
                                        autocomplete="current-password" placeholder="••••••••" />

                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">

                                        <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                        <svg x-show="showPassword" style="display: none;" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.949-5.388" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.882 9.882a3 3 0 103.95 3.95" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                                </label>
                            </div>

                            <!-- Tombol Masuk -->
                            <div>
                                <x-primary-button class="w-full justify-center py-3 bg-emerald-700 hover:bg-emerald-800 focus:ring-emerald-500 text-sm font-bold tracking-wide rounded-xl shadow-md shadow-emerald-700/20 active:scale-[0.99] transition-all duration-200">
                                    {{ __('Masuk Sistem') }}
                                </x-primary-button>
                            </div>

                            
                        </form>
                    </div>
                </div>

                <!-- KOLOM KANAN: REGISTRASI & DOKUMEN -->
                <div class="flex flex-col space-y-4">
                    
                    <!-- Button Registrasi Operator -->
                    <a class="group flex items-center space-x-5 p-6 bg-white border-2 border-emerald-600/80 hover:border-emerald-500 rounded-2xl shadow-xl shadow-emerald-900/5 hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-900/10 hover:bg-gradient-to-br hover:from-white hover:to-emerald-50/40 transition-all duration-300" href="{{ route('register') }}">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-700 to-emerald-500 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-700/20 group-hover:scale-105 transition-transform shrink-0">
                            <svg xmlns="http://www.w3.org/2000/xl" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <strong class="block text-base font-extrabold text-gray-800 mb-0.5 group-hover:text-emerald-800 transition-colors">
                                Registrasi Ormawa kamu
                            </strong>
                            <span class="text-xs text-gray-500 leading-relaxed block">
                                Kelola organisasi dan data kegiatan mahasiswa di kampus.
                            </span>
                        </div>
                        <div class="text-emerald-600 group-hover:translate-x-1 transition-transform shrink-0 pl-2">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </div>
                    </a>

                    <!-- Button Download Format Surat -->
                    <a class="flex items-center justify-center space-x-2 w-full py-3 px-5 text-sm font-bold rounded-xl border border-emerald-600 bg-emerald-50/50 hover:bg-emerald-50 text-emerald-800 hover:text-emerald-700 hover:-translate-y-0.5 shadow-sm transition-all self-end" target="_blank" href="https://drive.google.com/drive/folders/1Jc_YKtmQEgWlwXBrz50Sn_jw-McGNewT?usp=sharing">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Format Surat Permohonan Akun</span>
                    </a>

                    <!-- Section Ajax Pengumuman -->
                    <div id="tempat_pengumuman" class="mt-4">
                        <!-- Ajax content will load here -->
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Scripts Tetap Dipertahankan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/Ajax/Pengumuman",
                data: { kode: "UMUM" },
                success: function(res) {
                    $("#tempat_pengumuman").html(res);
                }
            });
        });
    </script>
</x-guest-layout>