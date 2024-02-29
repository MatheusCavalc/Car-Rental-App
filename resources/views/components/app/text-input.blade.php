@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-lg block p-2.5',
]) !!}>
