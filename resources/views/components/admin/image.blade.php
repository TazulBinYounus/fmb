@props(['name', 'label', 'current' => null, 'required' => false, 'help' => 'JPG, PNG or WebP, max 5 MB. Large photos are resized automatically.', 'accept' => 'image/jpeg,image/png,image/webp', 'removable' => false])
@php
  $id = 'f_'.str_replace(['[', ']', '.'], '_', $name);
  $isPdf = str_contains($accept, 'pdf');
@endphp
<div class="form-group">
  <label for="{{ $id }}" class="{{ $required && ! $current ? 'adm-required' : '' }}">{{ $label }}</label>
  <div class="custom-file">
    <input type="file" class="custom-file-input {{ $errors->has($name) ? 'is-invalid' : '' }}" id="{{ $id }}" name="{{ $name }}" accept="{{ $accept }}"
      @if (! $isPdf) data-preview="#{{ $id }}_preview" @endif @if ($required && ! $current) required @endif>
    <label class="custom-file-label" for="{{ $id }}">{{ $current ? 'Replace file…' : 'Choose file' }}</label>
  </div>
  @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  @if ($help)<small class="form-text text-muted">{{ $help }}</small>@endif
  @if ($isPdf)
    @if ($current)<a class="d-inline-block mt-2" href="{{ media_url($current) }}" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o"></i> Current file</a>@endif
  @else
    <img id="{{ $id }}_preview" class="adm-preview {{ $current ? '' : 'd-none' }}" src="{{ $current ? media_url($current) : '' }}" alt="">
  @endif
  @if ($removable && $current)
    <div class="custom-control custom-checkbox mt-2">
      <input type="checkbox" class="custom-control-input" id="{{ $id }}_remove" name="remove_{{ $name }}" value="1">
      <label class="custom-control-label" for="{{ $id }}_remove">Remove current file</label>
    </div>
  @endif
</div>
