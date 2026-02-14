<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800 flex items-center">
            <span class="w-1.5 h-8 bg-emerald-600 rounded-r-md mr-4 shadow-sm"></span>
            {{ __('Edit Data Pegawai') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('pegawai.update', $pegawai->id_pegawai) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Form -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Section: Identitas & Pekerjaan -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-id-card text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Identitas & Pekerjaan</h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Pegawai -->
                            <div class="col-span-2">
                                <x-input-label for="nama_pegawai" :value="__('Nama Lengkap')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="nama_pegawai" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" type="text" name="nama_pegawai" :value="old('nama_pegawai', $pegawai->nama_pegawai)" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap pegawai" />
                                </div>
                                <x-input-error :messages="$errors->get('nama_pegawai')" class="mt-2" />
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <x-input-label for="jabatan" :value="__('Jabatan')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-briefcase text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="jabatan" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" type="text" name="jabatan" :value="old('jabatan', $pegawai->jabatan)" placeholder="Contoh: Staff Admin" />
                                </div>
                                <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                            </div>

                            <!-- No HP -->
                            <div>
                                <x-input-label for="no_hp" :value="__('No. Handphone')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="no_hp" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" type="text" name="no_hp" :value="old('no_hp', $pegawai->no_hp)" placeholder="08..." />
                                </div>
                                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                            </div>

                            <!-- Tim Syiar -->
                            <div>
                                <x-input-label for="tim_syiar" :value="__('Tim Syiar (Opsional)')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="tim_syiar" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" type="text" name="tim_syiar" :value="old('tim_syiar', $pegawai->tim_syiar)" placeholder="Nama tim syiar" />
                                </div>
                                <x-input-error :messages="$errors->get('tim_syiar')" class="mt-2" />
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <x-input-label for="wilayah" :value="__('Wilayah (Opsional)')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="wilayah" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" type="text" name="wilayah" :value="old('wilayah', $pegawai->wilayah)" placeholder="Nama wilayah" />
                                </div>
                                <x-input-error :messages="$errors->get('wilayah')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Akun Login -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-user-lock text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Akun Login</h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div class="col-span-2 md:col-span-1">
                                <x-input-label for="username" :value="__('Username')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-user-circle text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="username" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" type="text" name="username" :value="old('username', $pegawai->username)" required autocomplete="username" placeholder="Username login" />
                                </div>
                                <p class="mt-1.5 text-xs text-gray-500 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i> Digunakan untuk login ke sistem.
                                </p>
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="col-span-2 md:col-span-1">
                                <x-input-label for="password" :value="__('Password')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <x-text-input id="password" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" type="password" name="password" autocomplete="new-password" placeholder="••••••••" />
                                </div>
                                <p class="mt-1.5 text-xs text-gray-500 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i> Kosongkan jika tidak ingin mengubah password.
                                </p>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status & Actions -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Section: Pengaturan Status -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 relative z-20">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center rounded-t-2xl">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-cog text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Pengaturan</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status Akun')" class="mb-1.5 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fas fa-toggle-on text-gray-400 group-focus-within:text-purple-500 transition-colors"></i>
                                    </div>
                                    <select id="status" name="status" class="block w-full pl-10 rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm cursor-pointer">
                                        <option value="AKTIF" {{ old('status', $pegawai->status) == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                                        <option value="TIDAK AKTIF" {{ old('status', $pegawai->status) == 'TIDAK AKTIF' ? 'selected' : '' }}>TIDAK AKTIF</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Sticky Action Buttons -->
                    <div class="sticky top-6 z-10">
                        <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100 relative">
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:-translate-y-0.5 mb-3">
                                <i class="fas fa-save mr-2"></i> Perbarui Data
                            </button>
                            <a href="{{ route('pegawai.index') }}" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
