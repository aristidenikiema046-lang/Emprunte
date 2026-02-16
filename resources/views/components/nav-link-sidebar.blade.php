@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-6 py-3 bg-blue-600 text-white transition duration-150 ease-in-out'
            : 'flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>