<button {{ $attributes->merge(['type' => 'button', 'class' => 'text-white bg-blue-700 hover:bg-blue-800 rounded-lg w-full text-center transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
