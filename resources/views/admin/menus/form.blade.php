@extends('admin.layout')

@php $isNew = ! $item->exists; @endphp
@section('title', $isNew ? 'New menu item' : 'Edit menu item')

@section('actions')
  <a href="{{ route('admin.menus.index', ['location' => $item->location]) }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Back to menu</a>
@endsection

@section('content')
<form method="post" action="{{ $isNew ? route('admin.menus.store') : route('admin.menus.update', $item) }}">
  @csrf
  @unless ($isNew) @method('PUT') @endunless
  <input type="hidden" name="location" value="{{ $item->location }}">
  <div class="row">
    <div class="col-xl-8">
      <div class="adm-card"><div class="adm-card-body">
        <div class="row">
          <div class="col-md-6"><x-admin.input name="label" label="Label" :value="$item->label" required /></div>
          <div class="col-md-6"><x-admin.input name="label_bn" label="Label" :value="$item->label_bn" bn /></div>
        </div>
        <x-admin.input name="url" label="Link" :value="$item->url" required placeholder="/contact" help="A page on this site (/about, /development/projects), # for a heading that only opens a sub-menu, or a full https:// address." />
        @if ($item->location === 'header')
          <x-admin.select name="parent_id" label="Parent item" :options="$parents" :value="$item->parent_id" placeholder="— Top level —" />
        @endif
      </div></div>
    </div>
    <div class="col-xl-4">
      <div class="adm-card"><div class="adm-card-body">
        <p class="small text-muted mb-3">Menu: <strong>{{ \App\Models\MenuItem::LOCATIONS[$item->location] }}</strong></p>
        <x-admin.input name="sort_order" label="Display order" type="number" min="0" :value="$item->sort_order ?? 0" />
        <x-admin.switch name="open_in_new_tab" label="Open in a new tab" :checked="$item->open_in_new_tab" />
        <x-admin.switch name="is_active" label="Show in menu" :checked="$item->is_active" />
        <button class="btn btn-accent btn-block" type="submit"><i class="fa fa-save"></i> Save</button>
      </div></div>
    </div>
  </div>
</form>
@endsection
