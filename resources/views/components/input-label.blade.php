@props(['value'])

<label {{ $attributes->merge(['class' => 'fs-6 text-dark fw-bold mb-1']) }}>
    {{ $value ?? $slot }}
</label>