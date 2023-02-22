@props([
  'disabled' => false,
  'icon' => 'vendors/@coreui/icons/sprites/free.svg#cil-user',
  'id' => null,
  'name' => null,
  'placeholder' => '',
  'required' => false,
  'type' => 'text',
])

<div class="input-group mb-3"><span class="input-group-text">
  <svg class="icon">
    <use xlink:href="{{ asset($icon) }}"></use>
  </svg></span>
  <input {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!} id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}">
</div>