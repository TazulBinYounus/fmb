@props(['name', 'label' => null, 'value' => null, 'rows' => 4, 'required' => false, 'help' => null, 'bn' => false, 'editor' => false])
@php
  $key = str_replace(['[', ']'], ['.', ''], $name);
  $id = 'f_'.str_replace(['[', ']', '.'], '_', $name);
@endphp
<div class="form-group {{ $bn ? 'adm-bn' : '' }}">
  @if ($label)<label for="{{ $id }}" class="{{ $required ? 'adm-required' : '' }}">{{ $label }}</label>@endif
  <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}" @if ($editor) data-editor @endif
    {{ $attributes->merge(['class' => 'form-control'.($errors->has($key) ? ' is-invalid' : '')]) }}
    @if ($required && ! $editor) required @endif>{{ old($key, $value) }}</textarea>
  @error($key)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  @if ($help)<small class="form-text text-muted">{{ $help }}</small>@endif
</div>
