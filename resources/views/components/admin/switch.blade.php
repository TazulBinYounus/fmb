@props(['name', 'label', 'checked' => false, 'help' => null])
@php $id = 'f_'.str_replace(['[', ']', '.'], '_', $name); @endphp
<div class="form-group">
  <div class="custom-control custom-switch">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" class="custom-control-input" id="{{ $id }}" name="{{ $name }}" value="1" @checked(old($name, $checked))>
    <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
  </div>
  @if ($help)<small class="form-text text-muted">{{ $help }}</small>@endif
</div>
