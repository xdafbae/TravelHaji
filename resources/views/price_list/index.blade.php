<x-app-layout>
    <div x-data="{ 
        selected: [], 
        allSelected: false,
        toggleAll() {
            this.allSelected = !this.allSelected;
            if (this.allSelected) {
                this.selected = [{{ $priceLists->pluck('id_pricelist')->implode(',') }}];
            } else {
                this.selected = [];
            }
        },
        toggle(id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(item => item !== id);
                this.allSelected = false;
            } else {
                this.selected.push(id);
            }
        }
    }">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <i class="fas fa-tags text-emerald-600"></i>
                    {{ __('Price List / Katalog Harga') }}
                </h2>
                <div class="flex gap-3">
                    <a href="{{ route('price-list.export') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-file-export mr-2 text-emerald-600"></i> Export
                    </a>
                    <a href="{{ route('price-list.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i> Tambah Item
                    </a>
                </div>
            </div>
        </x-slot>

        <!-- Toast Notification -->
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" class="fixed top-20 right-5 z-50">
            @if(session('success'))
                <div x-show="show" x-transition:enter="transform ease-out duration-300 transition-translate-opacity"
                     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-lg flex items-center" role="alert">
                    <div class="bg-emerald-100 rounded-full p-2 mr-3">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="font-bold">Sukses!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-emerald-400 hover:text-emerald-600 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div x-show="show" x-transition:enter="transform ease-out duration-300 transition-translate-opacity"
                     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg flex items-center" role="alert">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-bold">Error!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-red-400 hover:text-red-600 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                                <i class="fas fa-box text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Item</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Item Aktif</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['active'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-50 text-red-600 mr-4">
                                <i class="fas fa-times-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Non-Aktif</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['inactive'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Rata-rata Harga</p>
                                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($stats['avg_price'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filters -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <form method="GET" action="{{ route('price-list.index') }}" class="space-y-4">
                        <div class="flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex-1 w-full">
                                <x-input-label for="search" :value="__('Cari Item')" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <x-text-input id="search" name="search" value="{{ request('search') }}" class="pl-10 block w-full rounded-lg" placeholder="Nama atau Kode Item..." />
                                </div>
                            </div>
                            
                            <div class="w-full md:w-48">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>

                            <div class="w-full md:w-48">
                                <x-input-label for="category" :value="__('Kategori')" />
                                <select id="category" name="category" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm">
                                    <option value="">Semua Kategori</option>
                                    <option value="form_a" {{ request('category') == 'form_a' ? 'selected' : '' }}>Form A (Paket)</option>
                                    <option value="form_b" {{ request('category') == 'form_b' ? 'selected' : '' }}>Form B (Perlengkapan)</option>
                                    <option value="form_c" {{ request('category') == 'form_c' ? 'selected' : '' }}>Form C (Dokumen)</option>
                                    <option value="form_d" {{ request('category') == 'form_d' ? 'selected' : '' }}>Form D (Lain-lain)</option>
                                    <option value="form_d_barang" {{ request('category') == 'form_d_barang' ? 'selected' : '' }}>Barang</option>
                                    <option value="form_d_jasa" {{ request('category') == 'form_d_jasa' ? 'selected' : '' }}>Jasa</option>
                                </select>
                            </div>

                            <div class="w-full md:w-auto flex gap-2">
                                <x-primary-button class="h-[42px] bg-gray-800 hover:bg-gray-700 rounded-lg">
                                    {{ __('Filter') }}
                                </x-primary-button>
                                @if(request()->hasAny(['search', 'status', 'category']))
                                    <a href="{{ route('price-list.index') }}" class="h-[42px] px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition flex items-center justify-center border border-gray-200">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Active Filters (Chips) -->
                        @if(request()->hasAny(['search', 'status', 'category']))
                        <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 self-center">Filter Aktif:</span>
                            
                            @if(request('search'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Search: {{ request('search') }}
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-2 text-blue-600 hover:text-blue-900"><i class="fas fa-times"></i></a>
                                </span>
                            @endif

                            @if(request('status') !== null)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Status: {{ request('status') == '1' ? 'Aktif' : 'Non-Aktif' }}
                                    <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="ml-2 text-green-600 hover:text-green-900"><i class="fas fa-times"></i></a>
                                </span>
                            @endif

                            @if(request('category'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Kategori: {{ ucwords(str_replace('_', ' ', request('category'))) }}
                                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="ml-2 text-purple-600 hover:text-purple-900"><i class="fas fa-times"></i></a>
                                </span>
                            @endif
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Bulk Actions Toolbar -->
                <div x-show="selected.length > 0" x-transition 
                     class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex justify-between items-center shadow-sm sticky top-0 z-30">
                    <div class="flex items-center gap-3">
                        <span class="bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded-full" x-text="selected.length"></span>
                        <span class="text-sm text-emerald-800 font-medium">Item dipilih</span>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('price-list.bulk-action') }}" method="POST" onsubmit="return confirm('Aktifkan item yang dipilih?');">
                            @csrf
                            <input type="hidden" name="action" value="activate">
                            <input type="hidden" name="ids" :value="selected.join(',')">
                            <button type="submit" class="text-xs bg-white border border-emerald-300 text-emerald-700 px-3 py-1.5 rounded-md hover:bg-emerald-50 transition font-medium">
                                <i class="fas fa-check mr-1"></i> Aktifkan
                            </button>
                        </form>
                        <form action="{{ route('price-list.bulk-action') }}" method="POST" onsubmit="return confirm('Non-aktifkan item yang dipilih?');">
                            @csrf
                            <input type="hidden" name="action" value="deactivate">
                            <input type="hidden" name="ids" :value="selected.join(',')">
                            <button type="submit" class="text-xs bg-white border border-gray-300 text-gray-700 px-3 py-1.5 rounded-md hover:bg-gray-50 transition font-medium">
                                <i class="fas fa-ban mr-1"></i> Non-Aktifkan
                            </button>
                        </form>
                        <form action="{{ route('price-list.bulk-action') }}" method="POST" onsubmit="return confirm('Hapus permanen item yang dipilih?');">
                            @csrf
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="ids" :value="selected.join(',')">
                            <button type="submit" class="text-xs bg-red-600 text-white px-3 py-1.5 rounded-md hover:bg-red-700 transition font-medium shadow-sm">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Table List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="overflow-x-auto max-h-[70vh]">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0 z-20 shadow-sm">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left w-10">
                                        <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                               @click="toggleAll()" :checked="allSelected">
                                    </th>
                                    @php
                                        $sortLink = function($field, $label) {
                                            $direction = request('direction') === 'asc' ? 'desc' : 'asc';
                                            $icon = '';
                                            if (request('sort') === $field) {
                                                $icon = request('direction') === 'asc' 
                                                    ? '<i class="fas fa-sort-up ml-1 text-emerald-600"></i>' 
                                                    : '<i class="fas fa-sort-down ml-1 text-emerald-600"></i>';
                                            } else {
                                                $icon = '<i class="fas fa-sort ml-1 text-gray-300 hover:text-gray-500"></i>';
                                            }
                                            $url = request()->fullUrlWithQuery(['sort' => $field, 'direction' => $direction]);
                                            return "<a href='{$url}' class='group inline-flex items-center text-xs font-bold text-gray-500 uppercase tracking-wider hover:text-gray-800 transition'>{$label} {$icon}</a>";
                                        };
                                    @endphp
                                    <th scope="col" class="px-6 py-3 text-left">
                                        {!! $sortLink('kode_item', 'Kode') !!}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left">
                                        {!! $sortLink('nama_item', 'Nama Item') !!}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        {!! $sortLink('harga', 'Harga') !!}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        {!! $sortLink('is_active', 'Status') !!}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($priceLists as $item)
                                <tr class="hover:bg-emerald-50/30 transition-colors duration-150 ease-in-out group" :class="selected.includes({{ $item->id_pricelist }}) ? 'bg-emerald-50' : ''">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                                               value="{{ $item->id_pricelist }}" @click="toggle({{ $item->id_pricelist }})" :checked="selected.includes({{ $item->id_pricelist }})">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600 font-medium">
                                        {{ $item->kode_item }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-gray-900 group-hover:text-emerald-700 transition">{{ $item->nama_item }}</span>
                                            @if($item->keterangan)
                                                <span class="text-xs text-gray-500 mt-0.5 truncate max-w-xs" title="{{ $item->keterangan }}">{{ $item->keterangan }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900 font-mono tabular-nums">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1">
                                            @if($item->form_a) <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100 rounded-md" title="Form A (Paket)">A</span> @endif
                                            @if($item->form_b) <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-100 rounded-md" title="Form B (Perlengkapan)">B</span> @endif
                                            @if($item->form_c) <span class="px-2 py-0.5 text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-md" title="Form C (Dokumen)">C</span> @endif
                                            @if($item->form_d) <span class="px-2 py-0.5 text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100 rounded-md" title="Form D (Lain-lain)">D</span> @endif
                                            @if($item->form_d_barang) <span class="px-2 py-0.5 text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 rounded-md" title="Barang">Brg</span> @endif
                                            @if($item->form_d_jasa) <span class="px-2 py-0.5 text-[10px] font-bold bg-orange-50 text-orange-700 border border-orange-100 rounded-md" title="Jasa">Jasa</span> @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-3" x-data="{ open: false }">
                                            <a href="{{ route('price-list.edit', $item->id_pricelist) }}" class="text-gray-400 hover:text-indigo-600 transition transform hover:scale-110" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Delete with Confirmation -->
                                            <div class="inline-block relative">
                                                <button type="button" @click="$dispatch('open-delete-modal', '{{ route('price-list.destroy', $item->id_pricelist) }}')" class="text-gray-400 hover:text-red-600 transition transform hover:scale-110" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-50 p-6 rounded-full mb-4">
                                                <i class="fas fa-search text-4xl text-gray-300"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada data ditemukan</h3>
                                            <p class="text-sm text-gray-500 mb-6 max-w-sm">
                                                Coba ubah kata kunci pencarian atau filter Anda untuk menemukan apa yang Anda cari.
                                            </p>
                                            <div class="flex gap-3">
                                                <a href="{{ route('price-list.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                    Reset Filter
                                                </a>
                                                <a href="{{ route('price-list.create') }}" class="px-4 py-2 bg-emerald-600 rounded-lg text-sm font-medium text-white hover:bg-emerald-700">
                                                    Tambah Item Baru
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($priceLists->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $priceLists->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Global Delete Modal -->
        <div x-data="{ open: false, action: '' }" 
             @open-delete-modal.window="open = true; action = $event.detail" 
             x-show="open" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75 backdrop-blur-sm"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Konfirmasi Hapus
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin menghapus item ini? Data yang dihapus tidak dapat dikembalikan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <form :action="action" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                Ya, Hapus
                            </button>
                        </form>
                        <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>