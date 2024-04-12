<button {{ $attributes->merge(['type' => 'button', 'class' => 'items-center px-4 transition ease-in-out nav-link']) }}>
    {{ $slot }}
</button>
