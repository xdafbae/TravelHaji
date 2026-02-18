<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight">
                    Detail Jamaah
                </h2>
                <p class="text-sm text-secondary-500 mt-1 font-medium">Informasi lengkap data jamaah</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('jamaah.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-semibold text-xs text-secondary-700 uppercase tracking-widest shadow-sm hover:bg-secondary-50 hover:text-primary-600 focus:outline-none transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <a href="{{ route('jamaah.edit', $jamaah->id_jamaah) }}" class="inline-flex items-center px-4 py-2 bg-warning-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning-600 focus:outline-none shadow-md hover:shadow-lg transition ease-in-out duration-150">
                    <i class="fas fa-edit mr-2"></i> Edit Data
                </a>
            </div>
        </div>

        <div class="animate-fade-in-up">
            
            <!-- Profile Header Card -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6 border border-secondary-100">
                <div class="relative h-32 bg-gradient-to-r from-primary-600 to-primary-800">
                    <div class="absolute bottom-0 right-0 p-4 opacity-10">
                        <i class="fas fa-kaaba text-8xl text-white"></i>
                    </div>
                </div>
                <div class="px-6 pb-6 relative">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-12 mb-4">
                        <div class="relative">
                            <div class="h-24 w-24 md:h-32 md:w-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                                @if($jamaah->foto_diri)
                                    <img class="h-full w-full object-cover" src="{{ Storage::url($jamaah->foto_diri) }}" alt="{{ $jamaah->nama_lengkap }}">
                                @else
                                    <img class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($jamaah->nama_lengkap) }}&color=7F9CF5&background=EBF4FF" alt="{{ $jamaah->nama_lengkap }}">
                                @endif
                            </div>
                            <div class="absolute bottom-1 right-1 bg-white rounded-full p-1 shadow-sm">
                                @if($jamaah->jenis_kelamin == 'L')
                                    <div class="bg-blue-100 text-blue-600 rounded-full h-6 w-6 flex items-center justify-center text-xs" title="Laki-laki">
                                        <i class="fas fa-mars"></i>
                                    </div>
                                @else
                                    <div class="bg-pink-100 text-pink-600 rounded-full h-6 w-6 flex items-center justify-center text-xs" title="Perempuan">
                                        <i class="fas fa-venus"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4 md:mt-0 md:ml-6 flex-1">
                            <h1 class="text-2xl font-bold text-secondary-900">{{ $jamaah->nama_lengkap }}</h1>
                            <div class="flex flex-wrap items-center gap-4 mt-1 text-sm text-secondary-600">
                                <span class="bg-secondary-100 px-2 py-0.5 rounded font-mono text-secondary-700">
                                    <i class="fas fa-id-badge mr-1 text-secondary-400"></i> {{ $jamaah->kode_jamaah }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-id-card mr-1 text-secondary-400"></i> {{ $jamaah->nik ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-sm {{ $jamaah->status_keberangkatan == 'Sudah Berangkat' ? 'bg-success-100 text-success-800' : 'bg-warning-100 text-warning-800' }}">
                                <i class="fas {{ $jamaah->status_keberangkatan == 'Sudah Berangkat' ? 'fa-check-circle' : 'fa-clock' }} mr-2"></i>
                                {{ $jamaah->status_keberangkatan }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column: Personal Info -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Personal Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-secondary-100">
                        <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center border-b border-secondary-100 pb-2">
                            <i class="fas fa-user text-primary-500 mr-2 bg-primary-50 p-2 rounded-lg"></i> Informasi Pribadi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</label>
                                <p class="text-secondary-900 font-medium">
                                    {{ $jamaah->tempat_lahir ?? '-' }}, {{ $jamaah->tgl_lahir ? $jamaah->tgl_lahir->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Usia</label>
                                <p class="text-secondary-900 font-medium">
                                    {{ $jamaah->tgl_lahir ? \Carbon\Carbon::parse($jamaah->tgl_lahir)->age . ' Tahun' : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Nomor HP / WA</label>
                                <div class="flex items-center">
                                    <p class="text-secondary-900 font-medium mr-2">{{ $jamaah->no_hp ?? '-' }}</p>
                                    @if($jamaah->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $jamaah->no_hp)) }}" target="_blank" class="text-success-500 hover:text-success-600" title="Chat WhatsApp">
                                            <i class="fab fa-whatsapp text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Kabupaten/Kota</label>
                                <p class="text-secondary-900 font-medium">{{ $jamaah->kabupaten ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                                <p class="text-secondary-900 font-medium leading-relaxed">{{ $jamaah->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment & Package Info -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-secondary-100">
                        <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center border-b border-secondary-100 pb-2">
                            <i class="fas fa-wallet text-info-500 mr-2 bg-info-50 p-2 rounded-lg"></i> Status Pembayaran
                        </h3>
                        
                        @php
                            $latestEmbarkasi = $jamaah->embarkasi->first();
                            $hargaPaket = $latestEmbarkasi ? $latestEmbarkasi->harga_paket : 0;
                            $totalBayar = $jamaah->total_bayar ?? 0;
                            if(!$totalBayar && $jamaah->kas) {
                                $totalBayar = $jamaah->kas->where('jenis', 'DEBET')->sum('jumlah');
                            }
                            $persenBayar = $hargaPaket > 0 ? min(100, round(($totalBayar / $hargaPaket) * 100)) : 0;
                        @endphp

                        @if($latestEmbarkasi)
                            <div class="mb-4">
                                <div class="flex justify-between items-end mb-2">
                                    <div>
                                        <p class="text-sm text-secondary-500">Paket Terdaftar</p>
                                        <p class="font-bold text-secondary-900">{{ $latestEmbarkasi->nama_paket ?? 'Paket Umrah' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-secondary-500">Total Tagihan</p>
                                        <p class="font-bold text-primary-600">Rp {{ number_format($hargaPaket, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-xs font-bold inline-block py-1 px-2 uppercase rounded-full {{ $persenBayar >= 100 ? 'text-success-600 bg-success-100' : 'text-warning-600 bg-warning-100' }}">
                                                {{ $persenBayar >= 100 ? 'Lunas' : 'Belum Lunas' }}
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-bold inline-block text-secondary-600">
                                                Sudah Bayar: Rp {{ number_format($totalBayar, 0, ',', '.') }} ({{ $persenBayar }}%)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-secondary-100">
                                        <div style="width:{{ $persenBayar }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $persenBayar >= 100 ? 'bg-success-500' : 'bg-warning-500' }}"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 bg-secondary-50 rounded-xl border border-dashed border-secondary-300">
                                <p class="text-secondary-500 mb-2">Belum terdaftar di paket keberangkatan manapun.</p>
                                <a href="#" class="text-primary-600 font-bold hover:underline">Daftarkan ke Embarkasi</a>
                            </div>
                        @endif
                        
                        <!-- Bank & Agent Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-secondary-100">
                             <div>
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Bank Pembayaran</label>
                                <div class="flex items-center">
                                    <i class="fas fa-university text-secondary-400 mr-2"></i>
                                    <p class="text-secondary-900 font-medium">{{ $jamaah->bank_pembayaran ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Agen / Syiar</label>
                                <div class="flex items-center">
                                    <i class="fas fa-user-tie text-secondary-400 mr-2"></i>
                                    <p class="text-secondary-900 font-medium">{{ $jamaah->nama_agen ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Documents -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-secondary-100">
                        <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center border-b border-secondary-100 pb-2">
                            <i class="fas fa-folder-open text-warning-500 mr-2 bg-warning-50 p-2 rounded-lg"></i> Dokumen
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- KTP -->
                            <div class="flex items-start p-3 rounded-xl border {{ $jamaah->foto_ktp ? 'border-success-100 bg-success-50' : 'border-secondary-200 bg-secondary-50' }}">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $jamaah->foto_ktp ? 'bg-success-100 text-success-600' : 'bg-secondary-200 text-secondary-400' }}">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-secondary-900">KTP</p>
                                    <p class="text-xs text-secondary-500 truncate">{{ $jamaah->foto_ktp ? 'Tersedia' : 'Belum upload' }}</p>
                                </div>
                                @if($jamaah->foto_ktp)
                                    <a href="{{ Storage::url($jamaah->foto_ktp) }}" target="_blank" class="text-secondary-400 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- KK -->
                            <div class="flex items-start p-3 rounded-xl border {{ $jamaah->foto_kk ? 'border-success-100 bg-success-50' : 'border-secondary-200 bg-secondary-50' }}">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $jamaah->foto_kk ? 'bg-success-100 text-success-600' : 'bg-secondary-200 text-secondary-400' }}">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-secondary-900">Kartu Keluarga</p>
                                    <p class="text-xs text-secondary-500 truncate">{{ $jamaah->foto_kk ? 'Tersedia' : 'Belum upload' }}</p>
                                </div>
                                @if($jamaah->foto_kk)
                                    <a href="{{ Storage::url($jamaah->foto_kk) }}" target="_blank" class="text-secondary-400 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- Passport (Future Placeholder) -->
                            <div class="flex items-start p-3 rounded-xl border border-secondary-200 bg-secondary-50 opacity-60">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-secondary-200 text-secondary-400">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-secondary-900">Paspor</p>
                                    <p class="text-xs text-secondary-500">Data paspor belum tersedia</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-secondary-100 text-center">
                            <a href="{{ route('jamaah.edit', $jamaah->id_jamaah) }}" class="text-sm text-primary-600 hover:text-primary-700 font-bold">
                                <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Dokumen Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>