@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
