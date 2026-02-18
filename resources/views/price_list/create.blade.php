<x-app-layout>
        <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('price-list.index') }}" class="mr-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Item Price List') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('price-list.store') }}" method="POST">
                @csrf
                @include('price_list.partials.form')
            </form>
        </div>
    </div>
</x-app-layout>