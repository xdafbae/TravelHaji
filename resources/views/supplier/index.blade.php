<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Supplier</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalSuppliers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-500">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Supplier Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeSuppliers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-500">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Supplier Non-Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $inactiveSuppliers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toolbar & Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('supplier.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                    <div class="flex flex-col md:flex-row gap-4 w-full lg:w-auto flex-grow items-center">
                        <!-- Search -->
                        <div class="relative w-full md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, kontak..." class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                        </div>

                        <!-- Filter Kategori -->
                        <select name="category" class="w-full md:w-auto rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach(['Perlengkapan', 'Koper & Tas', 'Akomodasi', 'Transportasi', 'Catering', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>

                        <!-- Filter Status -->
                        <select name="status" class="w-full md:w-auto rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        
                        <!-- Reset -->
                        @if(request()->anyFilled(['q', 'category', 'status']))
                            <a href="{{ route('supplier.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition ease-in-out duration-150">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </a>
                        @endif
                        
                        <!-- Submit for Search (Mobile friendly) -->
                        <button type="submit" class="md:hidden w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Terapkan Filter
                        </button>
                    </div>

                    <div class="w-full lg:w-auto flex justify-end">
                        <a href="{{ route('supplier.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <i class="fas fa-plus mr-2"></i> Tambah Supplier
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('supplier.index', array_merge(request()->query(), ['sort_by' => 'nama_supplier', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center">
                                        Nama Supplier
                                        @if(request('sort_by') == 'nama_supplier')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('supplier.index', array_merge(request()->query(), ['sort_by' => 'kategori', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center">
                                        Kategori
                                        @if(request('sort_by') == 'kategori')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('supplier.index', array_merge(request()->query(), ['sort_by' => 'email', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center">
                                        Email
                                        @if(request('sort_by') == 'email')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1 text-emerald-600"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider group cursor-pointer" onclick="window.location='{{ route('supplier.index', array_merge(request()->query(), ['sort_by' => 'is_active', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    <div class="flex items-center justify-center">
                                        Status
                                        @if(request('sort_by') == 'is_active')
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
                            @forelse($suppliers as $supplier)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $supplier->nama_supplier }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                            {{ $supplier->kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone-alt text-gray-400 mr-2 text-xs"></i>
                                            {{ $supplier->kontak ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if($supplier->email)
                                            <div class="flex items-center">
                                                <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i>
                                                {{ $supplier->email }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($supplier->is_active)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                <i class="fas fa-check-circle mr-1 mt-0.5"></i> Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                <i class="fas fa-times-circle mr-1 mt-0.5"></i> Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-3">
                                            <a href="{{ route('supplier.edit', $supplier->id_supplier) }}" class="text-gray-500 hover:text-indigo-600 transition-colors duration-200 p-1 rounded hover:bg-indigo-50" title="Edit">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>
                                            <button type="button" class="text-gray-500 hover:text-red-600 transition-colors duration-200 p-1 rounded hover:bg-red-50" onclick="confirmDelete('{{ $supplier->id_supplier }}', '{{ $supplier->nama_supplier }}')" title="Hapus">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                            <form id="delete-form-{{ $supplier->id_supplier }}" action="{{ route('supplier.destroy', $supplier->id_supplier) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-4 rounded-full bg-gray-100 mb-4">
                                                <i class="fas fa-inbox fa-3x text-gray-400"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Belum ada data supplier</h3>
                                            <p class="mt-1 text-gray-500">Mulai dengan menambahkan supplier baru atau sesuaikan filter pencarian.</p>
                                            <div class="mt-6">
                                                <a href="{{ route('supplier.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                    <i class="fas fa-plus mr-2"></i> Tambah Supplier Baru
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
                @if($suppliers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $suppliers->links() }}
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
                title: 'Hapus Supplier?',
                text: "Anda akan menghapus data supplier \"" + name + "\". Tindakan ini tidak dapat dibatalkan!",
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