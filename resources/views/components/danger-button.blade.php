<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-pill uppercase transition ease-in-out duration-150 px-4']) }}>
    {{ $slot }}
</button>