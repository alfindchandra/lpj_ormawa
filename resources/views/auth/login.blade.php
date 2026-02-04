<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                <x-text-input id="email"
                    class="block mt-1 w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm py-3"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="Ormawa@ikippgribojonegoro.ac.id" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="space-y-1" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-700 font-medium" />

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <x-text-input id="password"
                    class="block mt-1 w-full pl-10 pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm py-3"
                    x-bind:type="showPassword ? 'text' : 'password'" name="password" required
                    autocomplete="current-password" placeholder="••••••••" />

                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">

                    <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <svg x-show="showPassword" style="display: none;" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.949-5.388" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.882 9.882a3 3 0 103.95 3.95" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

        </div>

        <div>
            <x-primary-button
                class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-base">
                {{ __('Masuk Sistem') }}
            </x-primary-button>
        </div>

        <p class="mt-4 text-center text-sm text-gray-500">
            Belum memiliki akun pengurus?
            <a href="https://wa.me/6287865215760?text=Saya%20ingin%20pengajuan%20pembuatan%20akun"
                class="font-medium text-indigo-600 hover:text-indigo-500">Hubungi Admin/BEM</a>
        </p>
    </form>
</x-guest-layout>
