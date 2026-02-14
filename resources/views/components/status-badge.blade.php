@props(['status'])

@php
    $classes = match ($status) {
        'AKTIF' => 'bg-emerald-100 text-emerald-800',
        'TIDAK AKTIF' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span {{ $attributes->merge(['class' => 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' . $classes]) }}>
    {{ $status }}
</span>
