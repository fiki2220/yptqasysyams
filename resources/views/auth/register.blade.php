<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-green-800">Formulir PPDB Online</h2>
        <p class="text-gray-600 text-sm">Silakan isi data calon santri dengan benar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <!-- Nama Lengkap -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="name" :value="__('Nama Lengkap Calon Santri')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email (Untuk Login) -->
            <div>
                <x-input-label for="email" :value="__('Email (Untuk Login)')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- No HP / WA -->
            <div>
                <x-input-label for="phone" :value="__('No. Handphone / WA')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- NISN -->
            <div>
                <x-input-label for="nisn" :value="__('NISN')" />
                <x-text-input id="nisn" class="block mt-1 w-full" type="number" name="nisn" :value="old('nisn')" required />
                <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
            </div>

            <!-- Nama Ibu -->
            <div>
                <x-input-label for="mother_name" :value="__('Nama Ibu Kandung')" />
                <x-text-input id="mother_name" class="block mt-1 w-full" type="text" name="mother_name" :value="old('mother_name')" required />
                <x-input-error :messages="$errors->get('mother_name')" class="mt-2" />
            </div>

            <!-- Jenjang / Kelas -->
            <div>
                <x-input-label for="grade_level" :value="__('Daftar Untuk Jenjang')" />
                <select id="grade_level" name="grade_level" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                    <option value="" disabled selected>Pilih Jenjang</option>
                    <option value="TK">TK Asy-Syams (Coming Soon)</option>
                    <option value="Rumah Qur'an">Rumah Qur'an Asy-Syams</option>
                </select>
                <x-input-error :messages="$errors->get('grade_level')" class="mt-2" />
            </div>

            <!-- Asal Sekolah -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="school_origin" :value="__('Asal Sekolah Sebelumnya (TK/SD/SMP)')" />
                <x-text-input id="school_origin" class="block mt-1 w-full" type="text" name="school_origin" :value="old('school_origin')" required />
                <x-input-error :messages="$errors->get('school_origin')" class="mt-2" />
            </div>

            <!-- Alamat -->
            <div class="col-span-1 md:col-span-2">
                <x-input-label for="address" :value="__('Alamat Lengkap')" />
                <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" rows="3" required>{{ old('address') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Gender -->
            <div>
                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password Baru')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4 bg-green-600 hover:bg-green-700">
                {{ __('Kirim Pendaftaran') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>