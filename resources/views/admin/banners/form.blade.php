@extends('admin.layout')

@php $isNew = ! $banner->exists; @endphp
@section('title', $isNew ? 'New banner' : 'Edit banner')

@section('actions')
  <a href="{{ route('admin.banners.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> All banners</a>
@endsection

@section('content')
<form method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.banners.store') : route('admin.banners.update', $banner) }}">
  @csrf
  @unless ($isNew) @method('PUT') @endunless
  <div class="row">
    <div class="col-xl-8">
      <div class="adm-card"><div class="adm-card-body">
        <div class="row">
          <div class="col-md-6"><x-admin.input name="title" label="Title" :value="$banner->title" required help="Large heading, e.g. FMB DEVELOPMENTS" /></div>
          <div class="col-md-6"><x-admin.input name="title_bn" label="Title" :value="$banner->title_bn" bn /></div>
          <div class="col-md-6"><x-admin.input name="subtitle" label="Subtitle" :value="$banner->subtitle" /></div>
          <div class="col-md-6"><x-admin.input name="subtitle_bn" label="Subtitle" :value="$banner->subtitle_bn" bn /></div>
          <div class="col-md-4"><x-admin.input name="button_text" label="Button text" :value="$banner->button_text" placeholder="e.g. View Projects" /></div>
          <div class="col-md-4"><x-admin.input name="button_text_bn" label="Button text" :value="$banner->button_text_bn" bn /></div>
          <div class="col-md-4"><x-admin.input name="button_link" label="Button link" :value="$banner->button_link" placeholder="/development" help="A page on this site (/contact) or a full https:// link." /></div>
        </div>
      </div></div>
    </div>
    <div class="col-xl-4">
      <div class="adm-card"><div class="adm-card-body">
        <x-admin.image name="image" label="Background image" :current="$banner->image" :required="$isNew" help="Landscape photo, at least 1920×800. JPG/PNG/WebP, max 5 MB." />
        <x-admin.select name="image_position" label="Image focus" :options="\App\Models\Banner::POSITIONS" :value="$banner->image_position" required help="Which part of the photo stays visible on narrow screens." />
        <x-admin.input name="sort_order" label="Display order" type="number" min="0" :value="$banner->sort_order ?? 0" />
        <x-admin.switch name="is_active" label="Show on homepage" :checked="$banner->is_active" />
        <button class="btn btn-accent btn-block" type="submit"><i class="fa fa-save"></i> {{ $isNew ? 'Add banner' : 'Save banner' }}</button>
      </div></div>
    </div>
  </div>
</form>
@endsection
