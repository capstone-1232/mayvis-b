<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-center rounded-pill transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
