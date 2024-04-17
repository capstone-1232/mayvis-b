@props([
    'disabled' => false,
    'name',
    'placeholder' => 'YYYY-MM-DD',
    'value' => ''
])
<input type="date"
       name="{{ $name }}"
       placeholder="{{ $placeholder }}"
       class="w-100 rounded-pill shadow-sm py-2 px-3 border"
       autocomplete="off"
       :value="old($name, $value)"
       @if($disabled) disabled @endif
>
@error($name)
       <div class="text-danger fs-6">{{ $message }}</div>
@enderror
