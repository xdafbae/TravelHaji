<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DNT Travel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons (FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Nunito', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background-color: transparent; }
    </style>
</head>
<body class="font-sans antialiased bg-secondary-50 text-secondary-700" x-data="{ sidebarOpen: true }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="flex flex-col flex-shrink-0 w-64 transition-all duration-300 bg-white border-r border-secondary-200"
               :class="{ '-ml-64': !sidebarOpen }">
            
            <div class="flex items-center h-16 px-6 bg-white border-b border-secondary-100">
                <a href="#" class="flex items-center space-x-2">
                    <i class="fas fa-kaaba text-warning-500 text-2xl"></i>
                    <span class="text-2xl font-bold text-secondary-900 tracking-tight">DNT</span>
                </a>
            </div>

            <div class="flex flex-col flex-1 overflow-y-auto custom-scrollbar py-4">
                <nav class="flex-1 px-3 space-y-1">
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-home w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Dashboard
                    </a>

                    <div class="px-3 mt-4 mb-1 text-xs font-semibold text-secondary-400 uppercase tracking-wider">
                        Operational
                    </div>

                    <a href="{{ route('jamaah.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('jamaah.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-users w-5 h-5 mr-3 {{ request()->routeIs('jamaah.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Jamaah
                    </a>

                    <a href="{{ route('embarkasi.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('embarkasi.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-plane-departure w-5 h-5 mr-3 {{ request()->routeIs('embarkasi.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Embarkasi
                    </a>

                    <a href="{{ route('passport.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('passport.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-passport w-5 h-5 mr-3 {{ request()->routeIs('passport.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Passport
                    </a>

                    <div class="px-3 mt-4 mb-1 text-xs font-semibold text-secondary-400 uppercase tracking-wider">
                        Finance & Purchasing
                    </div>

                    <a href="{{ route('finance.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('finance.index') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-wallet w-5 h-5 mr-3 {{ request()->routeIs('finance.index') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Finance
                    </a>

                    <a href="{{ route('finance.report') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('finance.report') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-file-invoice-dollar w-5 h-5 mr-3 {{ request()->routeIs('finance.report') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Finance Report
                    </a>

                    <a href="{{ route('purchasing.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('purchasing.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-shopping-cart w-5 h-5 mr-3 {{ request()->routeIs('purchasing.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Purchasing
                    </a>

                    <a href="{{ route('supplier.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('supplier.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-truck w-5 h-5 mr-3 {{ request()->routeIs('supplier.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Supplier
                    </a>

                    <a href="{{ route('inventory.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('inventory.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-boxes w-5 h-5 mr-3 {{ request()->routeIs('inventory.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Inventory
                    </a>

                    <div class="px-3 mt-4 mb-1 text-xs font-semibold text-secondary-400 uppercase tracking-wider">
                        Master Data
                    </div>

                    <a href="{{ route('pegawai.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('pegawai.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-user-tie w-5 h-5 mr-3 {{ request()->routeIs('pegawai.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Pegawai
                    </a>

                    <a href="{{ route('price-list.index') }}" class="flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('price-list.*') ? 'text-primary-600 bg-primary-50' : 'text-secondary-600 hover:text-primary-600 hover:bg-secondary-50' }}">
                        <i class="fas fa-tags w-5 h-5 mr-3 {{ request()->routeIs('price-list.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        Price List
                    </a>

                </nav>
            </div>
            
            <div class="p-4 border-t border-secondary-200">
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-secondary-600 rounded-md hover:text-primary-600 hover:bg-secondary-50 transition-colors">
                    <i class="fas fa-chevron-left w-5 h-5 mr-3 text-secondary-400"></i>
                    Collapsed View
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 h-full overflow-hidden bg-secondary-50">
            
            <!-- Topbar -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-secondary-200 shadow-sm z-10">
                <div class="flex items-center flex-1">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-secondary-500 hover:text-primary-600 focus:outline-none mr-4 lg:hidden">
                        <i class="fas fa-bars w-6 h-6"></i>
                    </button>
                    
                    <!-- Search -->
                    <div class="relative w-full max-w-md hidden md:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-secondary-400"></i>
                        </span>
                        <input type="text" class="w-full py-2 pl-10 pr-4 text-sm text-secondary-900 bg-white border border-secondary-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-secondary-400 transition-shadow" placeholder="Search...">
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle (Mock) -->
                    <button class="p-2 text-warning-500 hover:bg-warning-50 rounded-full transition-colors">
                        <i class="fas fa-sun w-5 h-5"></i>
                    </button>

                    <!-- Notifications -->
                    <button class="relative p-2 text-secondary-500 hover:text-primary-600 hover:bg-secondary-50 rounded-full transition-colors">
                        <i class="far fa-bell w-5 h-5"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-danger-500 rounded-full border-2 border-white"></span>
                    </button>

                    <!-- Apps Grid -->
                    <button class="p-2 text-secondary-500 hover:text-primary-600 hover:bg-secondary-50 rounded-full transition-colors">
                        <i class="fas fa-th w-5 h-5"></i>
                    </button>
                    
                    <!-- User Profile -->
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-secondary-200 overflow-hidden border border-secondary-200">
                                <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=random&color=fff" alt="User avatar">
                            </div>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-1" style="display: none;">
                            <div class="px-4 py-2 border-b border-secondary-100">
                                <p class="text-sm font-bold text-secondary-900">{{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p class="text-xs text-secondary-500 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50 hover:text-primary-600">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50 hover:text-primary-600">Settings</a>
                            <div class="border-t border-secondary-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50">Log out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-secondary-50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
