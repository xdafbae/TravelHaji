<x-app-layout>
    <x-slot name="header">
        Edit Data Jamaah
    </x-slot>

    <div x-data="{ step: 1 }" class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
        
        <!-- Stepper -->
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white transition-colors duration-300"
                     :class="step >= 1 ? 'bg-emerald-600' : 'bg-gray-300'">1</div>
                <div class="ml-2 text-sm font-medium text-gray-700">Data Pribadi</div>
            </div>
            <div class="w-16 h-1 mx-4 bg-gray-200 rounded">
                <div class="h-full bg-emerald-600 rounded transition-all duration-300" :style="'width: ' + (step >= 2 ? '100%' : '0%')"></div>
            </div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white transition-colors duration-300"
                     :class="step >= 2 ? 'bg-emerald-600' : 'bg-gray-300'">2</div>
                <div class="ml-2 text-sm font-medium text-gray-700">Kontak & Alamat</div>
            </div>
            <div class="w-16 h-1 mx-4 bg-gray-200 rounded">
                <div class="h-full bg-emerald-600 rounded transition-all duration-300" :style="'width: ' + (step >= 3 ? '100%' : '0%')"></div>
            </div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white transition-colors duration-300"
                     :class="step >= 3 ? 'bg-emerald-600' : 'bg-gray-300'">3</div>
                <div class="ml-2 text-sm font-medium text-gray-700">Dokumen</div>
            </div>
        </div>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Perhatian!</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('jamaah.update', $jamaah->id_jamaah) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Step 1: Data Pribadi -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Informasi Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                        <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $jamaah->nama_lengkap)" required />
                    </div>
                    <div>
                        <x-input-label for="nik" value="NIK" />
                        <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik', $jamaah->nik)" required />
                    </div>
                    <div>
                        <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                        <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="L" {{ old('jenis_kelamin', $jamaah->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $jamaah->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="tgl_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir', $jamaah->tgl_lahir ? $jamaah->tgl_lahir->format('Y-m-d') : '')" />
                    </div>
                    <div>
                        <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $jamaah->tempat_lahir)" />
                    </div>
                </div>
            </div>

            <!-- Step 2: Kontak & Alamat -->
            <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Kontak & Alamat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="alamat" value="Alamat Lengkap" />
                        <textarea name="alamat" id="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('alamat', $jamaah->alamat) }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="kabupaten" value="Kabupaten/Kota" />
                        <x-text-input id="kabupaten" class="block mt-1 w-full" type="text" name="kabupaten" :value="old('kabupaten', $jamaah->kabupaten)" />
                    </div>
                    <div>
                        <x-input-label for="no_hp" value="Nomor HP" />
                        <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp', $jamaah->no_hp)" />
                    </div>
                </div>
            </div>

            <!-- Step 3: Dokumen -->
            <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Upload Dokumen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="foto_ktp" value="Foto KTP" />
                        @if($jamaah->foto_ktp)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $jamaah->foto_ktp) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat KTP Saat Ini</a>
                            </div>
                        @endif
                        <input type="file" name="foto_ktp" id="foto_ktp" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                    </div>
                    <div>
                        <x-input-label for="foto_kk" value="Foto KK" />
                        @if($jamaah->foto_kk)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $jamaah->foto_kk) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat KK Saat Ini</a>
                            </div>
                        @endif
                        <input type="file" name="foto_kk" id="foto_kk" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                    </div>
                    <div>
                        <x-input-label for="foto_diri" value="Foto Diri (Formal)" />
                        @if($jamaah->foto_diri)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $jamaah->foto_diri) }}" alt="Foto Diri" class="h-20 w-20 object-cover rounded-full border border-gray-200">
                            </div>
                        @endif
                        <input type="file" name="foto_diri" id="foto_diri" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8">
                <button type="button" @click="step--" x-show="step > 1" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Kembali
                </button>
                <div x-show="step === 1"></div> <!-- Spacer -->
                
                <button type="button" @click="step++" x-show="step < 3" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">
                    Lanjut
                </button>
                <button type="submit" x-show="step === 3" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">
                    Update Jamaah
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
