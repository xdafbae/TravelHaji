<nav x-data="{ open: false }" class="bg-white border-b border-secondary-100 sticky top-0 z-30 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-primary-600 group-hover:text-primary-700 transition-colors" />
                        <span class="font-extrabold text-xl text-secondary-900 tracking-tight hidden md:block">DNT<span class="text-primary-600">Travel</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-home mr-2 text-lg {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <!-- Operasional Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-secondary-500 hover:text-secondary-700 hover:border-secondary-300 focus:outline-none transition duration-150 ease-in-out {{ request()->routeIs('jamaah.*') || request()->routeIs('embarkasi.*') || request()->routeIs('passport.*') ? '!text-secondary-900 !border-primary-500' : '' }}">
                                    <i class="fas fa-plane-departure mr-2 text-lg {{ request()->routeIs('jamaah.*') || request()->routeIs('embarkasi.*') || request()->routeIs('passport.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                                    Operasional
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('jamaah.index')" :active="request()->routeIs('jamaah.*')">
                                    <i class="fas fa-users mr-2 w-5 text-center"></i> {{ __('Data Jamaah') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('embarkasi.index')" :active="request()->routeIs('embarkasi.*')">
                                    <i class="fas fa-calendar-alt mr-2 w-5 text-center"></i> {{ __('Jadwal Keberangkatan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('passport.index')" :active="request()->routeIs('passport.*')">
                                    <i class="fas fa-passport mr-2 w-5 text-center"></i> {{ __('Manajemen Paspor') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Keuangan Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-secondary-500 hover:text-secondary-700 hover:border-secondary-300 focus:outline-none transition duration-150 ease-in-out {{ request()->routeIs('finance.*') || request()->routeIs('price-list.*') ? '!text-secondary-900 !border-primary-500' : '' }}">
                                    <i class="fas fa-wallet mr-2 text-lg {{ request()->routeIs('finance.*') || request()->routeIs('price-list.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                                    Keuangan
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('finance.index')" :active="request()->routeIs('finance.*')">
                                    <i class="fas fa-file-invoice-dollar mr-2 w-5 text-center"></i> {{ __('Buku Kas & Transaksi') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('price-list.index')" :active="request()->routeIs('price-list.*')">
                                    <i class="fas fa-tags mr-2 w-5 text-center"></i> {{ __('Daftar Harga Paket') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Logistik Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="top" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-secondary-500 hover:text-secondary-700 hover:border-secondary-300 focus:outline-none transition duration-150 ease-in-out {{ request()->routeIs('inventory.*') || request()->routeIs('purchasing.*') || request()->routeIs('supplier.*') ? '!text-secondary-900 !border-primary-500' : '' }}">
                                    <i class="fas fa-boxes mr-2 text-lg {{ request()->routeIs('inventory.*') || request()->routeIs('purchasing.*') || request()->routeIs('supplier.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                                    Logistik
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">
                                    <i class="fas fa-warehouse mr-2 w-5 text-center"></i> {{ __('Stok Barang') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('purchasing.index')" :active="request()->routeIs('purchasing.*')">
                                    <i class="fas fa-shopping-cart mr-2 w-5 text-center"></i> {{ __('Pembelian') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('supplier.index')" :active="request()->routeIs('supplier.*')">
                                    <i class="fas fa-truck mr-2 w-5 text-center"></i> {{ __('Data Supplier') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">
                        <i class="fas fa-user-tie mr-2 text-lg {{ request()->routeIs('pegawai.*') ? 'text-primary-600' : 'text-secondary-400' }}"></i>
                        {{ __('Pegawai') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-secondary-500 hover:text-secondary-700 hover:border-secondary-300 focus:outline-none transition duration-150 ease-in-out group">
                            <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold mr-2 border border-primary-200 group-hover:bg-primary-600 group-hover:text-white transition-all">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block">{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-secondary-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-circle mr-2 w-5 text-center text-secondary-400"></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-danger-600 hover:bg-danger-50 hover:text-danger-700">
                                <i class="fas fa-sign-out-alt mr-2 w-5 text-center"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-secondary-400 hover:text-secondary-500 hover:bg-secondary-100 focus:outline-none focus:bg-secondary-100 focus:text-secondary-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-secondary-100 shadow-inner">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <div class="pt-2 pb-1 border-t border-secondary-100 mt-2">
                <div class="px-4 text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-2">Operasional</div>
                <x-responsive-nav-link :href="route('jamaah.index')" :active="request()->routeIs('jamaah.*')">
                    {{ __('Data Jamaah') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('embarkasi.index')" :active="request()->routeIs('embarkasi.*')">
                    {{ __('Jadwal Keberangkatan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('passport.index')" :active="request()->routeIs('passport.*')">
                    {{ __('Manajemen Paspor') }}
                </x-responsive-nav-link>
            </div>

            <div class="pt-2 pb-1 border-t border-secondary-100 mt-2">
                <div class="px-4 text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-2">Keuangan</div>
                <x-responsive-nav-link :href="route('finance.index')" :active="request()->routeIs('finance.*')">
                    {{ __('Buku Kas & Transaksi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('price-list.index')" :active="request()->routeIs('price-list.*')">
                    {{ __('Daftar Harga Paket') }}
                </x-responsive-nav-link>
            </div>

            <div class="pt-2 pb-1 border-t border-secondary-100 mt-2">
                <div class="px-4 text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-2">Logistik & SDM</div>
                <x-responsive-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">
                    {{ __('Stok Barang') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">
                    {{ __('Data Pegawai') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-secondary-100 bg-secondary-50">
            <div class="px-4 flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-lg border border-primary-200">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="ml-3">
                    <div class="font-bold text-base text-secondary-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-secondary-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-lg">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-danger-600 hover:bg-danger-50 hover:text-danger-700 rounded-lg">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>