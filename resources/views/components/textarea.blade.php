@props(['disabled' => false, 'field' => '', 'value' => ''])
<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded']) !!}>
{{ $value }}
</textarea>
@error($field)
    <div class="text-danger"> {{ $message }}</div>
@enderror   