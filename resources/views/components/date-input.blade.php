@props([
    'disabled' => false,
    'name',
    'placeholder' => 'YYYY-MM-DD', // Default placeholder if none provided
    'value' => '' // Default value if none provided
])

<input type="date"
       name="{{ $name }}"
       placeholder="{{ $placeholder }}"
       class="w-100 rounded-pill shadow-sm py-2 px-3 border"
       autocomplete="off"
       :value="old($name, $value)" {{-- Use the old input value if available, otherwise use the provided $value --}}
       @if($disabled) disabled @endif {{-- Conditionally add the disabled attribute --}}
>

@error($name) {{-- Assuming $name is used as the field name for validation --}}
       <div class="text-red-600 text-sm">{{ $message }}</div>
@enderror
