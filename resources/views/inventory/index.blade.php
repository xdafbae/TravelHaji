<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stok Barang (Inventory)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Barang</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalItems ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $lowStockItems ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-500">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Barang Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeItems ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Inactive Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-500">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Non-Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $inactiveItems ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toolbar & Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('inventory.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                    <div class="flex flex-col md:flex-row gap-4 w-full lg:w-auto flex-grow items-center">
                        <!-- Search -->
                        <div class="relative w-full md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode, nama, inisial..." class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                        </div>

                        <!-- Filter Status -->
                        <select name="status" class="w-full md:w-auto rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>

                        <!-- Filter Low Stock -->
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="low_stock" value="1" class="sr-only peer" onchange="this.form.submit()" {{ request('low_stock') ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-700">Hanya Low Stock</span>
                        </label>
                        
                        <!-- Reset -->
                        @if(request()->anyFilled(['q', 'status', 'low_stock']))
                            <a href="{{ route('inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition ease-in-out duration-150">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </a>
                        @endif

                        <!-- Submit for Search (Mobile friendly) -->
                        <button type="submit" class="md:hidden w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Terapkan Filter
                        </button>
                    </div>

                    <div class="w-full lg:w-auto flex justify-end">
                        <a href="{{ route('inventory.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <i class="fas fa-plus mr-2"></i> Tambah Barang
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('inventory.index', array_merge(request()->query(), ['sort_by' => 'kode_barang', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center">
                                        Kode
                                        @if(request('sort_by') == 'kode_barang')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('inventory.index', array_merge(request()->query(), ['sort_by' => 'nama_barang', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center">
                                        Nama Barang
                                        @if(request('sort_by') == 'nama_barang' || !request('sort_by'))
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inisial</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('inventory.index', array_merge(request()->query(), ['sort_by' => 'stok_tersedia', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center justify-center">
                                        Stok Tersedia
                                        @if(request('sort_by') == 'stok_tersedia')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('inventory.index', array_merge(request()->query(), ['sort_by' => 'buffer_stok', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center justify-center">
                                        Buffer Stok
                                        @if(request('sort_by') == 'buffer_stok')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('inventory.index', array_merge(request()->query(), ['sort_by' => 'is_tersedia', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center justify-center">
                                        Status
                                        @if(request('sort_by') == 'is_tersedia')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($items as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                        {{ $item->kode_barang }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->inisial_barang ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item->stok_tersedia <= $item->buffer_stok)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded bg-red-100 text-red-800 animate-pulse">
                                                {{ number_format($item->stok_tersedia, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-sm font-bold text-emerald-600">
                                                {{ number_format($item->stok_tersedia, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        {{ $item->buffer_stok }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item->is_tersedia)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('inventory.edit', $item->id_stok) }}" class="text-gray-500 hover:text-indigo-600 transition-colors duration-200 p-1 rounded hover:bg-indigo-50" title="Edit">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>
                                            <button type="button" class="text-gray-500 hover:text-red-600 transition-colors duration-200 p-1 rounded hover:bg-red-50" onclick="confirmDelete('{{ $item->id_stok }}', '{{ $item->nama_barang }}')" title="Hapus">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                            <form id="delete-form-{{ $item->id_stok }}" action="{{ route('inventory.destroy', $item->id_stok) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 whitespace-nowrap text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-4 rounded-full bg-gray-100 mb-4">
                                                <i class="fas fa-box-open fa-3x text-gray-400"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Belum ada data barang</h3>
                                            <p class="mt-1 text-gray-500">Mulai dengan menambahkan master barang baru atau sesuaikan filter.</p>
                                            <div class="mt-6">
                                                <a href="{{ route('inventory.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                    <i class="fas fa-plus mr-2"></i> Tambah Barang
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
                @if($items->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Flash Messages
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Delete Confirmation
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Barang?',
                text: "Anda akan menghapus \"" + name + "\". Data stok yang terkait mungkin akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>