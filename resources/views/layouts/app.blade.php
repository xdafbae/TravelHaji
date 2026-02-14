<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travel Haji & Umrah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Icons (FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: true }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="flex flex-col flex-shrink-0 w-64 transition-all duration-300 bg-emerald-900 border-r border-gray-200"
               :class="{ '-ml-64': !sidebarOpen }">
            
            <div class="flex items-center justify-center h-16 bg-emerald-800 shadow-md">
                <span class="text-xl font-bold text-white tracking-wider">TRAVEL H&U</span>
            </div>

            <div class="flex flex-col flex-1 overflow-y-auto custom-scrollbar">
                <nav class="flex-1 px-2 py-4 space-y-1">
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 group {{ request()->routeIs('dashboard') ? 'bg-emerald-800' : '' }}">
                        <i class="fas fa-home w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>

                    <!-- Pendaftaran Jamaah Group -->
                    <div x-data="{ open: {{ request()->routeIs('jamaah.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="flex items-center w-full px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 focus:outline-none {{ request()->routeIs('jamaah.*') ? 'bg-emerald-800' : '' }}">
                            <i class="fas fa-users w-5 h-5 mr-3"></i>
                            <span class="flex-1 text-left">Pendaftaran</span>
                            <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200" :class="{ 'transform rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 space-y-1">
                            <a href="{{ route('jamaah.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('jamaah.index') ? 'bg-emerald-700 text-white' : '' }}">
                                Daftar Jamaah
                            </a>
                            <a href="{{ route('jamaah.create') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('jamaah.create') ? 'bg-emerald-700 text-white' : '' }}">
                                Tambah Jamaah
                            </a>
                        </div>
                    </div>

                    <!-- Keberangkatan -->
                    <a href="{{ route('embarkasi.index') }}" class="flex items-center px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 {{ request()->routeIs('embarkasi.*') ? 'bg-emerald-800' : '' }}">
                        <i class="fas fa-plane-departure w-5 h-5 mr-3"></i>
                        Keberangkatan
                    </a>

                    <!-- Manifest & Visa -->
                    <a href="{{ route('passport.index') }}" class="flex items-center px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 {{ request()->routeIs('passport.*') ? 'bg-emerald-800' : '' }}">
                        <i class="fas fa-passport w-5 h-5 mr-3"></i>
                        Manifest & Visa
                    </a>

                    <!-- Keuangan Group -->
                    <div x-data="{ open: {{ request()->routeIs('finance.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="flex items-center w-full px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 focus:outline-none {{ request()->routeIs('finance.*') ? 'bg-emerald-800' : '' }}">
                            <i class="fas fa-wallet w-5 h-5 mr-3"></i>
                            <span class="flex-1 text-left">Keuangan</span>
                            <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200" :class="{ 'transform rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 space-y-1">
                            <a href="{{ route('finance.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('finance.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Buku Kas & Transaksi
                            </a>
                            <a href="{{ route('finance.report') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('finance.report') ? 'bg-emerald-700 text-white' : '' }}">
                                Laporan Keuangan
                            </a>
                        </div>
                    </div>

                    <!-- Purchasing Group -->
                    <div x-data="{ open: {{ request()->routeIs('purchasing.*') || request()->routeIs('supplier.*') || request()->routeIs('inventory.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="flex items-center w-full px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 focus:outline-none {{ request()->routeIs('purchasing.*') || request()->routeIs('supplier.*') || request()->routeIs('inventory.*') ? 'bg-emerald-800' : '' }}">
                            <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
                            <span class="flex-1 text-left">Purchasing</span>
                            <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200" :class="{ 'transform rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 space-y-1">
                            <a href="{{ route('purchasing.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('purchasing.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Purchase Order
                            </a>
                            <a href="{{ route('supplier.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('supplier.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Data Supplier
                            </a>
                            <a href="{{ route('inventory.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('inventory.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Stok Barang
                            </a>
                        </div>
                    </div>

                    <!-- Master Data -->
                    <div x-data="{ open: {{ request()->routeIs('price-list.*') || request()->routeIs('pegawai.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="flex items-center w-full px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700 focus:outline-none {{ request()->routeIs('price-list.*') || request()->routeIs('pegawai.*') ? 'bg-emerald-800' : '' }}">
                            <i class="fas fa-database w-5 h-5 mr-3"></i>
                            <span class="flex-1 text-left">Master Data</span>
                            <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200" :class="{ 'transform rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 space-y-1">
                            <a href="{{ route('pegawai.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('pegawai.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Pegawai
                            </a>
                            <a href="{{ route('supplier.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('supplier.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Vendor / Supplier
                            </a>
                            <a href="{{ route('price-list.index') }}" class="flex items-center px-4 py-2 text-sm text-emerald-100 rounded-md hover:bg-emerald-700 hover:text-white {{ request()->routeIs('price-list.*') ? 'bg-emerald-700 text-white' : '' }}">
                                Price List
                            </a>
                        </div>
                    </div>

                    <!-- Settings -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-100 transition-colors rounded-md hover:bg-emerald-700">
                        <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                        Pengaturan
                    </a>

                </nav>
            </div>
            
            <div class="p-4 border-t border-emerald-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-white bg-emerald-800 rounded-md hover:bg-emerald-700">
                        <i class="fas fa-sign-out-alt w-4 h-4 mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 h-full overflow-hidden">
            
            <!-- Topbar -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars w-6 h-6"></i>
                    </button>
                    <h1 class="ml-4 text-xl font-semibold text-gray-800">
                        {{ $header ?? 'Dashboard' }}
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-bell w-6 h-6"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                    </button>
                    
                    <!-- User Profile -->
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                            <img class="w-8 h-8 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=10b981&color=fff" alt="User avatar">
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <i class="fas fa-chevron-down w-3 h-3 text-gray-500"></i>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
