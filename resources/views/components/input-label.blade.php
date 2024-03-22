@props(['value'])

<label {{ $attributes->merge(['class' => 'fs-6 text-secondary']) }}>
    {{ $value ?? $slot }}
</label>