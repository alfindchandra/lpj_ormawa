<x-guest-layout>
    <div class="w-full sm:max-w-xl mt-6 px-8 py-8 bg-white shadow-xl rounded-2xl border border-gray-100 token-register-card">
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan isi formulir di bawah ini untuk mendaftarkan lembaga Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-medium mb-1.5" />
                    <x-text-input id="name" class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/20 px-4 py-2.5 transition duration-200 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-700 font-medium mb-1.5" />
                    <x-text-input id="email" class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/20 px-4 py-2.5 transition duration-200 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@domain.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <x-input-label for="role" :value="__('Daftar Sebagai (Role)')" class="text-gray-700 font-medium mb-1.5" />
                    <div class="relative">
                        <select id="role" name="role" class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/20 px-4 py-2.5 bg-white text-gray-700 shadow-sm transition duration-200 appearance-none" required>
                            <option value="hmp" {{ old('role') == 'hmp' ? 'selected' : '' }}>Himpunan Mahasiswa Prodi (HMP)</option>
                            <option value="ukm" {{ old('role') == 'ukm' ? 'selected' : '' }}>Unit Kegiatan Mahasiswa (UKM)</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="ormawa_name" :value="__('Nama Ormawa / UKM / HMP')" class="text-gray-700 font-medium mb-1.5" />
                    <x-text-input id="ormawa_name" class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/20 px-4 py-2.5 transition duration-200 shadow-sm" type="text" name="ormawa_name" :value="old('ormawa_name')" placeholder="Contoh: HMP TI / UKM Musik" />
                    <x-input-error :messages="$errors->get('ormawa_name')" class="mt-1" />
                </div>
            </div>

            <hr class="border-gray-100 my-2">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700 font-medium mb-1.5" />
                    <x-text-input id="password" class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/20 px-4 py-2.5 transition duration-200 shadow-sm" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-gray-700 font-medium mb-1.5" />
                    <x-text-input id="password_confirmation" class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/20 px-4 py-2.5 transition duration-200 shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 gap-4">
                <a class="text-sm text-gray-500 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 text-center sm:text-left font-medium" href="{{ route('login') }}">
                    {{ __('Sudah memiliki akun?') }}
                </a>

                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md shadow-indigo-200 transition duration-150 ease-in-out">
                    {{ __('Daftar Sekarang') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>