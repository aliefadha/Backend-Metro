@props([
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'label' => null,
    'name' => null,
    'id' => null,
    'readonly' => false,
])
<div class="mb-3">
    <label>{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" placeholder="{{ $placeholder }}" value="{{ $value }}"
        name="{{ $name }}" id="{{ $id }}" {{ $readonly ? 'readonly' : '' }} />
</div>
