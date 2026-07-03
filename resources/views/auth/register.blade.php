<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50/40 via-white to-emerald-50/30 font-sans antialiased flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="w-full sm:max-w-xl bg-white shadow-xl shadow-emerald-900/5 rounded-3xl border border-gray-100 overflow-hidden">
            <!-- Header Card -->
            <div class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-500 p-6 text-white relative overflow-hidden text-center">
                <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-white/10 pointer-events-none"></div>
                <h2 class="text-2xl font-extrabold tracking-tight relative z-10">Buat Akun Pengurus</h2>
                <p class="text-xs text-emerald-100/90 mt-1.5 relative z-10">Silakan isi formulir untuk mendaftarkan organisasi Anda di IKIP PGRI Bojonegoro</p>
            </div>

            <!-- Body Card Form -->
            <!-- PERBAIKAN: Menambahkan enctype="multipart/form-data" untuk upload file -->
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-5 bg-gray-50/30">
                @csrf

                <!-- Kirim data role secara otomatis tanpa input field di UI -->
                <input type="hidden" name="role" value="ormawa" />

                <!-- Input Nama Lengkap -->
                <div class="space-y-1.5">
                    <x-input-label for="name" :value="__('Nama Lengkap Ketua / Pengurus')" class="text-gray-700 font-semibold text-xs uppercase tracking-wider" />
                    <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-white focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                        <x-text-input id="name" class="block w-full px-4 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap Anda" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Input Alamat Email -->
                <div class="space-y-1.5">
                    <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-700 font-semibold text-xs uppercase tracking-wider" />
                    <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-white focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                        <x-text-input id="email" class="block w-full px-4 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ormawa@ikippgribojonegoro.ac.id" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Input Nama Ormawa -->
                <div class="space-y-1.5">
                    <x-input-label for="ormawa_name" :value="__('Nama Ormawa / UKM / HMP')" class="text-gray-700 font-semibold text-xs uppercase tracking-wider" />
                    <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-white focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                        <x-text-input id="ormawa_name" class="block w-full px-4 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none" type="text" name="ormawa_name" :value="old('ormawa_name')" required placeholder="Contoh: HMP TI / UKM Musik / BEM" />
                    </div>
                    <x-input-error :messages="$errors->get('ormawa_name')" class="mt-1" />
                </div>

                <!-- PERBAIKAN: Input Upload Logo Ormawa -->
                <div class="space-y-1.5">
                    <x-input-label for="logo" :value="__('Logo Ormawa')" class="text-gray-700 font-semibold text-xs uppercase tracking-wider" />
                    <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-white focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                        <input id="logo" class="block w-full px-4 py-2.5 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" type="file" name="logo" accept="image/*" required />
                    </div>
                    <p class="text-[10px] text-gray-400 italic mt-0.5">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                    <x-input-error :messages="$errors->get('logo')" class="mt-1" />
                </div>

                <!-- Input Kata Sandi -->
                <div class="space-y-1.5">
                    <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700 font-semibold text-xs uppercase tracking-wider" />
                    <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-white focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                        <x-text-input id="password" class="block w-full px-4 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Input Konfirmasi Kata Sandi -->
                <div class="space-y-1.5">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-gray-700 font-semibold text-xs uppercase tracking-wider" />
                    <div class="relative flex items-center shadow-sm rounded-xl overflow-hidden border border-gray-300 bg-white focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/10 transition-all duration-200">
                        <x-text-input id="password_confirmation" class="block w-full px-4 py-3 text-sm text-gray-800 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400 shadow-none" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center space-x-3 pt-3">
                    <button type="button" onclick="window.location='{{ route('login') }}'" class="w-1/3 py-3 px-4 bg-gray-200 hover:bg-gray-300 active:scale-[0.99] text-gray-700 font-bold text-sm tracking-wide rounded-xl transition-all duration-200 text-center">
                        {{ __('Batal') }}
                    </button>
                    <button type="submit" class="w-2/3 py-3 px-4 bg-emerald-700 hover:bg-emerald-800 active:scale-[0.99] text-white font-bold text-sm tracking-wide rounded-xl shadow-md shadow-emerald-700/20 hover:shadow-lg hover:shadow-emerald-700/30 transition-all duration-200 text-center">
                        {{ __('Daftar Sekarang') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-guest-layout>