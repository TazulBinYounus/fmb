@props(['name', 'label' => null, 'options' => [], 'value' => null, 'required' => false, 'help' => null, 'placeholder' => null])
@php
  $key = str_replace(['[', ']'], ['.', ''], $name);
  $id = 'f_'.str_replace(['[', ']', '.'], '_', $name);
  $current = (string) old($key, $value);
@endphp
<div class="form-group">
  @if ($label)<label for="{{ $id }}" class="{{ $required ? 'adm-required' : '' }}">{{ $label }}</label>@endif
  <select name="{{ $name }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'form-control custom-select'.($errors->has($key) ? ' is-invalid' : '')]) }} @if ($required) required @endif>
    @if ($placeholder !== null)<option value="">{{ $placeholder }}</option>@endif
    @foreach ($options as $optValue => $optLabel)
      <option value="{{ $optValue }}" @selected($current === (string) $optValue)>{{ $optLabel }}</option>
    @endforeach
  </select>
  @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
  @if ($help)<small class="form-text text-muted">{{ $help }}</small>@endif
</div>
