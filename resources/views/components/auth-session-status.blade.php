@props(['status'])
@if ($status)
    <div {{ $attributes->merge(['class' => 'fw-medium text-success']) }}>
        {{ $status }}
    </div>
@endif
