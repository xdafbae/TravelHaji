<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-2xl font-bold leading-tight text-gray-800 flex items-center">
                <span class="w-1.5 h-8 bg-emerald-600 rounded-r-md mr-4 shadow-sm"></span>
                {{ __('Data Pegawai') }}
            </h2>
            <a href="{{ route('pegawai.create') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wide hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2.5"></i> Tambah Pegawai
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8" x-data="{ deletingId: null }">
        
        <!-- Feedback Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-4 rounded-xl relative shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    <button class="ml-auto bg-transparent text-emerald-500 hover:text-emerald-700 focus:outline-none p-1.5 rounded-md hover:bg-emerald-100 transition-colors" @click="show = false">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Toolbar: Search & Filter -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6 mb-8">
            <form method="GET" action="{{ route('pegawai.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Search -->
                <div class="md:col-span-5 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama, username, atau jabatan..." 
                           class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-all duration-200 h-11">
                </div>

                <!-- Filter Status -->
                <div class="md:col-span-3 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-filter text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200"></i>
                    </div>
                    <select name="status" onchange="this.form.submit()" 
                            class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-all duration-200 h-11 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="AKTIF" {{ request('status') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                        <option value="TIDAK AKTIF" {{ request('status') == 'TIDAK AKTIF' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <!-- Filter Jabatan -->
                <div class="md:col-span-3 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-briefcase text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200"></i>
                    </div>
                    <select name="filter_jabatan" onchange="this.form.submit()" 
                            class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-all duration-200 h-11 cursor-pointer">
                        <option value="">Semua Jabatan</option>
                        @foreach($jabatans as $jab)
                            <option value="{{ $jab }}" {{ request('filter_jabatan') == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset -->
                <div class="md:col-span-1 flex items-center justify-end md:justify-start">
                    @if(request()->anyFilled(['search', 'status', 'filter_jabatan', 'filter_wilayah']))
                        <a href="{{ route('pegawai.index') }}" class="inline-flex items-center justify-center w-full md:w-auto h-11 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200" title="Reset Filter">
                            <i class="fas fa-undo mr-2 md:mr-0 lg:mr-2"></i> <span class="md:hidden lg:inline">Reset</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Content -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
            
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider group cursor-pointer hover:bg-gray-100 transition-colors duration-200" onclick="window.location='{{ route('pegawai.index', array_merge(request()->query(), ['sort_by' => 'nama_pegawai', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}'">
                                <div class="flex items-center space-x-2">
                                    <span>Nama Pegawai</span>
                                    <span class="flex flex-col text-[10px] leading-none text-gray-400">
                                        <i class="fas fa-caret-up {{ request('sort_by') == 'nama_pegawai' && request('sort_order') == 'asc' ? 'text-emerald-600' : '' }}"></i>
                                        <i class="fas fa-caret-down {{ request('sort_by') == 'nama_pegawai' && request('sort_order') == 'desc' ? 'text-emerald-600' : '' }}"></i>
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Info Akun
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Jabatan & Wilayah
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Kontak
                            </th>
                            <th scope="col" class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($pegawai as $p)
                            <tr class="hover:bg-emerald-50/30 transition-colors duration-200 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-11 w-11">
                                            <div class="h-11 w-11 rounded-full bg-gradient-to-br from-emerald-100 to-teal-50 flex items-center justify-center text-emerald-700 font-bold text-lg border-2 border-white shadow-sm group-hover:scale-105 transition-transform duration-200">
                                                {{ strtoupper(substr($p->nama_pegawai, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">
                                                {{ $p->nama_pegawai }}
                                            </div>
                                            @if($p->tim_syiar)
                                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                                    <i class="fas fa-users mr-1.5 text-[10px] text-gray-400"></i> {{ $p->tim_syiar }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200 font-mono">
                                        {{ $p->username }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $p->jabatan ?? '-' }}</div>
                                    @if($p->wilayah)
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <i class="fas fa-map-marker-alt mr-1.5 text-[10px] text-gray-400"></i> {{ $p->wilayah }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($p->no_hp)
                                        <div class="flex items-center group/phone cursor-pointer" title="{{ $p->no_hp }}">
                                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center mr-2 group-hover/phone:bg-emerald-100 transition-colors">
                                                <i class="fas fa-phone text-emerald-600 text-xs"></i>
                                            </div>
                                            <span class="group-hover/phone:text-emerald-700 transition-colors">{{ $p->no_hp }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Tidak ada kontak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <x-status-badge :status="$p->status" class="shadow-sm border border-transparent" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}" 
                                           class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1" 
                                           title="Edit Data">
                                            <i class="fas fa-pencil-alt text-sm"></i>
                                        </a>
                                        <button 
                                            @click="deletingId = {{ $p->id_pegawai }}; $dispatch('open-modal', 'confirm-pegawai-deletion')" 
                                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1" 
                                            title="Hapus Data"
                                        >
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-inner">
                                            <i class="fas fa-users-slash text-gray-300 text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak ada data pegawai</h3>
                                        <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">Data yang Anda cari tidak ditemukan. Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
                                        <a href="{{ route('pegawai.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            <i class="fas fa-plus mr-2 text-emerald-500"></i> Tambah Pegawai Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden">
                <div class="grid grid-cols-1 gap-4 p-4 bg-gray-50">
                    @forelse($pegawai as $p)
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-lg shadow-sm border border-emerald-50">
                                        {{ strtoupper(substr($p->nama_pegawai, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900">{{ $p->nama_pegawai }}</h3>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <i class="fas fa-briefcase mr-1.5 opacity-70"></i> {{ $p->jabatan ?? 'Tanpa Jabatan' }}
                                        </div>
                                    </div>
                                </div>
                                <x-status-badge :status="$p->status" />
                            </div>
                            
                            <div class="space-y-3 text-sm text-gray-600 mb-5 bg-gray-50 p-3 rounded-xl">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 flex items-center"><i class="fas fa-user-circle mr-2 opacity-70 w-4"></i> Username</span>
                                    <span class="font-mono font-bold">{{ $p->username }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 flex items-center"><i class="fas fa-phone mr-2 opacity-70 w-4"></i> No HP</span>
                                    <span>{{ $p->no_hp ?? '-' }}</span>
                                </div>
                                @if($p->wilayah)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 flex items-center"><i class="fas fa-map-marker-alt mr-2 opacity-70 w-4"></i> Wilayah</span>
                                    <span>{{ $p->wilayah }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('pegawai.edit', $p->id_pegawai) }}" class="flex-1 flex justify-center items-center py-2 px-4 border border-emerald-200 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-bold hover:bg-emerald-100 transition-colors">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                                <button 
                                    @click="deletingId = {{ $p->id_pegawai }}; $dispatch('open-modal', 'confirm-pegawai-deletion')"
                                    class="flex-1 flex justify-center items-center py-2 px-4 border border-red-200 bg-red-50 text-red-700 rounded-xl text-sm font-bold hover:bg-red-100 transition-colors"
                                >
                                    <i class="fas fa-trash-alt mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Tidak ada data pegawai.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-4 border-t border-gray-100 sm:px-6">
                {{ $pegawai->links() }}
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <x-modal name="confirm-pegawai-deletion" focusable>
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">
                    {{ __('Hapus Data Pegawai?') }}
                </h2>

                <p class="text-sm text-gray-500 max-w-xs mx-auto mb-6">
                    {{ __('Data yang dihapus tidak dapat dikembalikan. Pastikan Anda menghapus data yang benar.') }}
                </p>

                <div class="flex justify-center gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')" class="justify-center w-32">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <form method="POST" :action="`{{ route('pegawai.destroy', '') }}/${deletingId}`">
                        @csrf
                        @method('DELETE')
                        
                        <x-danger-button class="justify-center w-32 bg-red-600 hover:bg-red-700">
                            {{ __('Ya, Hapus') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>