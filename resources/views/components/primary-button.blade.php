<button {{ $attributes->merge(['type' => 'submit', 'class' => 'fw-bold text-white text-center rounded-pill transition ease-in-out duration-150 px-4']) }}>
    {{ $slot }}
</button>