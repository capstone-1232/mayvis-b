@props(['disabled' => false, 'field' => '', 'value' => ''])

<input {{ $disabled ? 'disabled' : '' }} value="{{ $value }}" {!! $attributes->merge(['class' => 'w-100 rounded-pill py-2 ps-3 border']) !!}>
@error($field)
    <div class="text-red-600 text-sm"> {{ $message }}</div>
@enderror