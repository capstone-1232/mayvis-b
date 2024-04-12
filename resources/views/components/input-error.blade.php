@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-danger py-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
