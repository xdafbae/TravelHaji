{{--
    Halaman Travel Agency Dashboard
    -------------------------------
    DNT Theme
--}}

<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight">
                    Dianta Andalan Haramain
                </h2>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button class="px-4 py-2 bg-white border border-secondary-300 rounded-lg text-sm font-semibold text-secondary-700 hover:bg-secondary-50 focus:outline-none shadow-sm transition-all">
                    <i class="fas fa-plus mr-2 text-primary-500"></i> New Package
                </button>
                <button class="px-4 py-2 bg-primary-500 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-600 focus:outline-none shadow-md shadow-primary-500/30 transition-all">
                    <i class="fas fa-calendar-alt mr-2"></i> Book Now
                </button>
            </div>
        </div>

        <!-- Top Section: Stats & Financial Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Stacked Stats Cards -->
            <div class="space-y-6 lg:col-span-1">
                
                <!-- Total Value Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-semibold text-secondary-500">Total Value</p>
                            <h3 class="text-3xl font-bold text-secondary-900 mt-2">$2,345.00</h3>
                            <div class="mt-2 flex items-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-primary-100 text-primary-600">
                                    + 23.35%
                                </span>
                                <span class="ml-2 text-xs text-secondary-400 font-medium">From last month</span>
                            </div>
                        </div>
                        <div class="h-12 w-24">
                            <!-- Sparkline Placeholder -->
                            <canvas id="sparklineValue"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Booked Flights Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-semibold text-secondary-500">Booked Flights</p>
                            <h3 class="text-3xl font-bold text-secondary-900 mt-2">1,432</h3>
                            <div class="mt-2 flex items-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-success-50 text-success-600">
                                    + 3.98%
                                </span>
                                <span class="ml-2 text-xs text-secondary-400 font-medium">From last month</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center">
                            <i class="fas fa-cloud-sun-rain text-warning-500 text-3xl mb-1"></i>
                            <span class="text-xs text-secondary-500 font-bold">Rain Chances</span>
                            <span class="text-lg font-extrabold text-secondary-900">95%</span>
                        </div>
                    </div>
                </div>

                <!-- Commission Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-semibold text-secondary-500">Commission</p>
                            <h3 class="text-3xl font-bold text-secondary-900 mt-2">$3,339.00</h3>
                            <div class="mt-2 flex items-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-danger-50 text-danger-600">
                                    - 12.21%
                                </span>
                                <span class="ml-2 text-xs text-secondary-400 font-medium">From last month</span>
                            </div>
                        </div>
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <!-- Radial Progress Mock -->
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="24" cy="24" r="20" stroke="#e2e8f0" stroke-width="4" fill="transparent" />
                                <circle cx="24" cy="24" r="20" stroke="#3b82f6" stroke-width="4" fill="transparent" stroke-dasharray="125.6" stroke-dashoffset="30" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Financial Activities Chart -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100 lg:col-span-2 flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-secondary-900">Financial activities</h3>
                        <p class="text-sm text-secondary-500 font-medium">Yearly Balance</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select class="form-select block w-full pl-3 pr-10 py-1.5 text-sm border-secondary-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-md text-secondary-600 font-semibold">
                            <option>Hotel</option>
                            <option>Flight</option>
                        </select>
                        <button class="p-1.5 rounded-md hover:bg-secondary-100 text-secondary-400">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-6 mb-4 text-xs font-bold uppercase tracking-wider">
                    <div class="flex items-center"><span class="w-2 h-2 bg-primary-400 rounded-full mr-2"></span> <span class="text-secondary-500">Profit</span></div>
                    <div class="flex items-center"><span class="w-2 h-2 bg-success-400 rounded-full mr-2"></span> <span class="text-secondary-500">Revenue</span></div>
                    <div class="flex items-center"><span class="w-2 h-2 bg-primary-200 rounded-full mr-2"></span> <span class="text-secondary-500">Expenses</span></div>
                </div>

                <div class="relative flex-1 w-full min-h-[300px]">
                    <canvas id="financialChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Middle Section: Canceled, Visitors, Holidays -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Canceled Booking -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100">
                <h3 class="text-base font-bold text-secondary-900">Canceled Booking</h3>
                <h2 class="text-3xl font-bold text-secondary-900 mt-2">120.00</h2>
                <div class="mt-1 mb-6 flex items-center">
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-bold bg-danger-50 text-danger-600 border border-danger-100">
                        + 5.76%
                    </span>
                    <span class="ml-2 text-xs text-secondary-400 font-medium">From last month</span>
                </div>
                <div class="h-32 w-full">
                    <canvas id="canceledChart"></canvas>
                </div>
            </div>

            <!-- Visitors -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-secondary-900">Visitors</h3>
                        <p class="text-sm text-secondary-500">Users across countries</p>
                    </div>
                    <button class="text-secondary-400 hover:text-secondary-600"><i class="fas fa-ellipsis-h"></i></button>
                </div>
                
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-secondary-900">194 <span class="font-normal text-secondary-500">User per second</span></h4>
                    <div class="h-16 w-full mt-2">
                        <canvas id="visitorsSparkline"></canvas>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center w-1/3">
                            <img src="https://flagcdn.com/w20/in.png" alt="India" class="w-5 h-3.5 mr-3 rounded-sm shadow-sm">
                            <span class="font-bold text-secondary-700">India</span>
                        </div>
                        <div class="w-1/3 text-right font-bold text-secondary-700">92,896 <span class="text-secondary-400 font-normal">(41.6%)</span></div>
                        <div class="w-1/3 text-right text-xs font-bold text-primary-500 bg-primary-50 px-2 py-1 rounded">+ 15.21%</div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center w-1/3">
                            <img src="https://flagcdn.com/w20/cn.png" alt="China" class="w-5 h-3.5 mr-3 rounded-sm shadow-sm">
                            <span class="font-bold text-secondary-700">China</span>
                        </div>
                        <div class="w-1/3 text-right font-bold text-secondary-700">50,496 <span class="text-secondary-400 font-normal">(32.8%)</span></div>
                        <div class="w-1/3 text-right text-xs font-bold text-warning-600 bg-warning-50 px-2 py-1 rounded">+ 05.21%</div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center w-1/3">
                            <img src="https://flagcdn.com/w20/us.png" alt="USA" class="w-5 h-3.5 mr-3 rounded-sm shadow-sm">
                            <span class="font-bold text-secondary-700">USA</span>
                        </div>
                        <div class="w-1/3 text-right font-bold text-secondary-700">45,679 <span class="text-secondary-400 font-normal">(24.3%)</span></div>
                        <div class="w-1/3 text-right text-xs font-bold text-primary-500 bg-primary-50 px-2 py-1 rounded">+ 22.12%</div>
                    </div>
                </div>
            </div>

            <!-- Holidays -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-secondary-100 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-secondary-900">Holidays</h3>
                        <p class="text-sm text-secondary-500">Holidays next month</p>
                    </div>
                    <button class="text-xs font-bold px-3 py-1.5 bg-secondary-50 text-secondary-600 rounded-md hover:bg-secondary-100 border border-secondary-200 transition-colors">
                        Calendar <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                    </button>
                </div>
                
                <div class="flex justify-between text-xs font-bold text-secondary-400 mb-4 uppercase tracking-widest px-2">
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                
                <div class="grid grid-cols-7 gap-3 flex-1 items-center justify-items-center">
                    @for ($i = 0; $i < 28; $i++)
                        @php
                            $size = rand(1, 4); 
                            $color = ['bg-warning-200', 'bg-warning-300', 'bg-warning-400'][rand(0,2)];
                        @endphp
                        <div class="w-full h-10 flex items-center justify-center">
                            @if($size == 1)
                                <div class="w-1.5 h-1.5 rounded-full bg-warning-100"></div>
                            @elseif($size == 2)
                                <div class="w-3 h-3 rounded-full {{ $color }}"></div>
                            @elseif($size == 3)
                                <div class="w-8 h-8 rounded-full {{ $color }} shadow-sm flex items-center justify-center text-white text-xs font-bold opacity-80"></div>
                            @else
                                <!-- Empty -->
                            @endif
                        </div>
                    @endfor
                </div>
                
                <div class="mt-4 pt-4 border-t border-secondary-100 flex justify-between items-center">
                     <div class="flex items-center">
                        <span class="w-2 h-2 bg-success-500 rounded-full mr-2"></span>
                        <span class="text-xs font-bold text-secondary-600">Chat demo</span>
                     </div>
                </div>
            </div>

        </div>

        <!-- Bottom Section: Flights Table -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-secondary-100">
            <div class="p-6 border-b border-secondary-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="text-xl font-bold text-secondary-900">Flights</h3>
                
                <div class="flex flex-1 md:flex-none w-full md:w-auto space-x-2">
                    <div class="relative flex-1 md:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-secondary-400"></i>
                        </span>
                        <input type="text" class="w-full py-2 pl-10 pr-4 text-sm text-secondary-700 bg-white border border-secondary-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Search by Flight no.">
                    </div>
                    <button class="p-2 bg-secondary-50 border border-secondary-200 rounded-lg text-secondary-600 hover:bg-secondary-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
                
                <div class="hidden md:flex items-center text-sm text-secondary-500 font-medium">
                    <span>1 to 4 Items of 5</span>
                    <a href="#" class="ml-3 text-primary-600 font-bold hover:underline flex items-center">View all <i class="fas fa-chevron-right text-xs ml-1"></i></a>
                    <div class="ml-4 flex space-x-1">
                        <button class="p-1 rounded hover:bg-secondary-100"><i class="fas fa-chevron-left"></i></button>
                        <button class="p-1 rounded hover:bg-secondary-100"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-secondary-500 uppercase bg-white border-b border-secondary-100 font-bold tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 w-10">
                                <input type="checkbox" class="rounded border-secondary-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </th>
                            <th scope="col" class="px-6 py-4">Flights No.</th>
                            <th scope="col" class="px-6 py-4">Vendor</th>
                            <th scope="col" class="px-6 py-4">Weather</th>
                            <th scope="col" class="px-6 py-4">Route</th>
                            <th scope="col" class="px-6 py-4">Destination</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-100">
                        <!-- Row 1 -->
                        <tr class="bg-white hover:bg-secondary-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="rounded border-secondary-300 text-primary-600 shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-primary-600">#24349</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-transparent flex items-center justify-center mr-3">
                                         <i class="fas fa-fire text-warning-500 text-lg"></i>
                                    </div>
                                    <span class="font-bold text-secondary-900">Phoenix Firelines</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-secondary-600 font-medium">
                                    <i class="fas fa-temperature-low text-primary-400 mr-2"></i> 15°C
                                    <i class="fas fa-cloud-showers-heavy text-secondary-400 ml-3 mr-2"></i> Stormy
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center font-bold text-secondary-700">
                                    <img src="https://flagcdn.com/w20/us.png" class="w-5 h-3.5 mr-2 rounded-sm shadow-sm" alt="US"> LAX 
                                    <i class="fas fa-arrow-right mx-3 text-secondary-300 text-xs"></i> 
                                    YVR <img src="https://flagcdn.com/w20/ca.png" class="w-5 h-3.5 ml-2 rounded-sm shadow-sm" alt="CA">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative w-full max-w-xs">
                                    <div class="flex justify-between text-xs text-secondary-400 mb-1.5 font-semibold">
                                        <span>180 km, 00h:15m ago</span>
                                        <span>955 km, in 01h:25m</span>
                                    </div>
                                    <div class="w-full bg-secondary-200 rounded-full h-1 relative">
                                        <div class="bg-primary-500 h-1 rounded-full" style="width: 25%"></div>
                                        <div class="absolute top-1/2 left-1/4 transform -translate-y-1/2 -translate-x-1/2 bg-primary-600 p-0.5 rounded-full border-2 border-white">
                                            <i class="fas fa-plane text-white text-[6px] transform rotate-45"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 2 -->
                        <tr class="bg-white hover:bg-secondary-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="rounded border-secondary-300 text-primary-600 shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-primary-600">#23421</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-transparent flex items-center justify-center mr-3">
                                         <i class="fas fa-dove text-primary-700 text-lg"></i>
                                    </div>
                                    <span class="font-bold text-primary-700">Qatar Airways</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-secondary-600 font-medium">
                                    <i class="fas fa-temperature-high text-warning-500 mr-2"></i> 28°C
                                    <i class="fas fa-sun text-warning-400 ml-3 mr-2"></i> Sunny
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center font-bold text-secondary-700">
                                    <img src="https://flagcdn.com/w20/dk.png" class="w-5 h-3.5 mr-2 rounded-sm shadow-sm" alt="DK"> EBJ 
                                    <i class="fas fa-arrow-right mx-3 text-secondary-300 text-xs"></i> 
                                    CDG <img src="https://flagcdn.com/w20/kr.png" class="w-5 h-3.5 ml-2 rounded-sm shadow-sm" alt="KR">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative w-full max-w-xs">
                                    <div class="flex justify-between text-xs text-secondary-400 mb-1.5 font-semibold">
                                        <span>600 km, 02h:15m ago</span>
                                        <span>1,200 km, in 02h:25m</span>
                                    </div>
                                    <div class="w-full bg-secondary-200 rounded-full h-1 relative">
                                        <div class="bg-primary-500 h-1 rounded-full" style="width: 60%"></div>
                                        <div class="absolute top-1/2 left-[60%] transform -translate-y-1/2 -translate-x-1/2 bg-primary-600 p-0.5 rounded-full border-2 border-white">
                                            <i class="fas fa-plane text-white text-[6px] transform rotate-45"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="bg-white hover:bg-secondary-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="rounded border-secondary-300 text-primary-600 shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-primary-600">#23132</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-transparent flex items-center justify-center mr-3">
                                         <i class="fas fa-circle-notch text-danger-500 text-lg"></i>
                                    </div>
                                    <span class="font-bold text-secondary-900">Japan Airlines</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-secondary-600 font-medium">
                                    <i class="fas fa-temperature-low text-primary-400 mr-2"></i> 22°C
                                    <i class="fas fa-wind text-secondary-400 ml-3 mr-2"></i> Wind
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center font-bold text-secondary-700">
                                    <img src="https://flagcdn.com/w20/cn.png" class="w-5 h-3.5 mr-2 rounded-sm shadow-sm" alt="CN"> GOT 
                                    <i class="fas fa-arrow-right mx-3 text-secondary-300 text-xs"></i> 
                                    BCN <img src="https://flagcdn.com/w20/us.png" class="w-5 h-3.5 ml-2 rounded-sm shadow-sm" alt="US">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative w-full max-w-xs">
                                    <div class="flex justify-between text-xs text-secondary-400 mb-1.5 font-semibold">
                                        <span>500 km, 00h:56m ago</span>
                                        <span>3,455 km, in 03h:25m</span>
                                    </div>
                                    <div class="w-full bg-secondary-200 rounded-full h-1 relative">
                                        <div class="bg-primary-500 h-1 rounded-full" style="width: 15%"></div>
                                        <div class="absolute top-1/2 left-[15%] transform -translate-y-1/2 -translate-x-1/2 bg-primary-600 p-0.5 rounded-full border-2 border-white">
                                            <i class="fas fa-plane text-white text-[6px] transform rotate-45"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                         <!-- Row 4 -->
                         <tr class="bg-white hover:bg-secondary-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="rounded border-secondary-300 text-primary-600 shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-primary-600">#22267</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-transparent flex items-center justify-center mr-3">
                                         <i class="fas fa-plane text-danger-600 text-lg"></i>
                                    </div>
                                    <span class="font-bold text-primary-700">Emirate</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-secondary-600 font-medium">
                                    <i class="fas fa-temperature-low text-primary-400 mr-2"></i> 5°C
                                    <i class="fas fa-umbrella text-danger-400 ml-3 mr-2"></i> Heavy rain
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center font-bold text-secondary-700">
                                    <img src="https://flagcdn.com/w20/qa.png" class="w-5 h-3.5 mr-2 rounded-sm shadow-sm" alt="QA"> DIA 
                                    <i class="fas fa-arrow-right mx-3 text-secondary-300 text-xs"></i> 
                                    OSL <img src="https://flagcdn.com/w20/no.png" class="w-5 h-3.5 ml-2 rounded-sm shadow-sm" alt="NO">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative w-full max-w-xs">
                                    <div class="flex justify-between text-xs text-secondary-400 mb-1.5 font-semibold">
                                        <span>00 km, 00h:00m ago</span>
                                        <span>On time</span>
                                    </div>
                                    <div class="w-full bg-secondary-200 rounded-full h-1 relative">
                                        <div class="bg-primary-500 h-1 rounded-full" style="width: 5%"></div>
                                        <div class="absolute top-1/2 left-[5%] transform -translate-y-1/2 -translate-x-1/2 bg-primary-600 p-0.5 rounded-full border-2 border-white">
                                            <i class="fas fa-plane text-white text-[6px] transform rotate-45"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            Chart.defaults.font.family = "'Nunito', sans-serif";
            Chart.defaults.color = '#64748b'; // secondary-500

            // --- Sparkline for Total Value ---
            const ctxSpark = document.getElementById('sparklineValue').getContext('2d');
            new Chart(ctxSpark, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [{
                        data: [10, 25, 20, 40, 35],
                        borderColor: '#f59e0b', // Warning-500
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false, min: 0 }
                    }
                }
            });

            // --- Financial Activities Chart (Horizontal Bar) ---
            const ctxFinancial = document.getElementById('financialChart').getContext('2d');
            new Chart(ctxFinancial, {
                type: 'bar',
                data: {
                    labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [
                        {
                            label: 'Expenses',
                            data: [65, 59, 80, 81, 56, 55, 40],
                            backgroundColor: '#bfdbfe', // Primary-200
                            borderRadius: 4,
                            barPercentage: 0.5,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Revenue',
                            data: [85, 69, 90, 91, 76, 75, 60],
                            backgroundColor: '#4ade80', // Success-400
                            borderRadius: 4,
                            barPercentage: 0.5,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Profit',
                            data: [45, 39, 60, 61, 46, 35, 30],
                            backgroundColor: '#60a5fa', // Primary-400
                            borderRadius: 4,
                            barPercentage: 0.5,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    indexAxis: 'y', 
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { 
                            display: false,
                            grid: { display: false }
                        },
                        y: { 
                            grid: { 
                                display: true,
                                borderDash: [2, 4],
                                color: '#e2e8f0',
                                drawBorder: false
                            },
                            ticks: {
                                font: { weight: 'bold' }
                            }
                        }
                    }
                }
            });

            // --- Canceled Booking Chart (Vertical Bar) ---
            const ctxCanceled = document.getElementById('canceledChart').getContext('2d');
            new Chart(ctxCanceled, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        data: [12, 19, 8, 15, 10, 14, 9],
                        backgroundColor: '#60a5fa', // Primary-400
                        borderRadius: 4,
                        borderSkipped: false,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        },
                        y: { display: false }
                    }
                }
            });

            // --- Visitors Sparkline ---
            const ctxVisitors = document.getElementById('visitorsSparkline').getContext('2d');
            new Chart(ctxVisitors, {
                type: 'bar',
                data: {
                    labels: Array.from({length: 40}, (_, i) => i + 1),
                    datasets: [{
                        data: Array.from({length: 40}, () => Math.floor(Math.random() * 50) + 10),
                        backgroundColor: '#3b82f6', // Primary-500
                        borderRadius: 2,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    }
                }
            });

        });
    </script>
</x-app-layout>
