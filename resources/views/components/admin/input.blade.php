@props(['name', 'label' => null, 'value' => null, 'type' => 'text', 'required' => false, 'help' => null, 'bn' => false, 'placeholder' => null])
@php
  $key = str_replace(['[', ']'], ['.', ''], $name);
  $id = 'f_'.str_replace(['[', ']', '.'], '_', $name);
  $current = old($key, $value);
@endphp
<div class="form-group {{ $bn ? 'adm-bn' : '' }}">
  @if ($label)<label for="{{ $id }}" class="{{ $required ? 'adm-required' : '' }}">{{ $label }}</label>@endif
  <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ $type === 'password' ? '' : $current }}"
    {{ $attributes->merge(['class' => 'form-control'.($errors->has($key) ? ' is-invalid' : '')]) }}
    @if ($required) required @endif @if ($placeholder) placeholder="{{ $placeholder }}" @endif>
  @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
  @if ($help)<small class="form-text text-muted">{{ $help }}</small>@endif
</div>
