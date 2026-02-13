<x-app-layout>
    <x-slot name="header">
        Edit Data Pegawai: {{ $pegawai->nama_pegawai }}
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Pegawai -->
                        <div class="md:col-span-2">
                            <x-input-label for="nama_pegawai" :value="__('Nama Lengkap Pegawai')" />
                            <x-text-input id="nama_pegawai" class="block mt-1 w-full" type="text" name="nama_pegawai" :value="old('nama_pegawai', $pegawai->nama_pegawai)" required />
                            <x-input-error :messages="$errors->get('nama_pegawai')" class="mt-2" />
                        </div>

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username', $pegawai->username)" required />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password (Kosongkan jika tidak diubah)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan" :value="old('jabatan', $pegawai->jabatan)" />
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        <!-- No HP -->
                        <div>
                            <x-input-label for="no_hp" :value="__('No. Handphone')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp', $pegawai->no_hp)" />
                            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                        </div>

                        <!-- Tim Syiar -->
                        <div>
                            <x-input-label for="tim_syiar" :value="__('Tim Syiar (Opsional)')" />
                            <x-text-input id="tim_syiar" class="block mt-1 w-full" type="text" name="tim_syiar" :value="old('tim_syiar', $pegawai->tim_syiar)" />
                            <x-input-error :messages="$errors->get('tim_syiar')" class="mt-2" />
                        </div>

                        <!-- Wilayah -->
                        <div>
                            <x-input-label for="wilayah" :value="__('Wilayah (Opsional)')" />
                            <x-text-input id="wilayah" class="block mt-1 w-full" type="text" name="wilayah" :value="old('wilayah', $pegawai->wilayah)" />
                            <x-input-error :messages="$errors->get('wilayah')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status Akun')" />
                            <select id="status" name="status" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="AKTIF" {{ old('status', $pegawai->status) == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                                <option value="TIDAK AKTIF" {{ old('status', $pegawai->status) == 'TIDAK AKTIF' ? 'selected' : '' }}>TIDAK AKTIF</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('pegawai.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Update Pegawai') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
