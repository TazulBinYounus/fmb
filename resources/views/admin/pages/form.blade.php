@extends('admin.layout')

@php $isNew = ! $page->exists; @endphp
@section('title', $isNew ? 'New page' : 'Edit page: '.$page->title)

@section('actions')
  <a href="{{ route('admin.pages.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> All pages</a>
  @unless ($isNew)<a href="{{ $page->publicUrl() }}" target="_blank" rel="noopener" class="btn btn-light btn-sm"><i class="fa fa-external-link"></i> View</a>@endunless
@endsection

@section('content')
<form method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.pages.store') : route('admin.pages.update', $page) }}">
  @csrf
  @unless ($isNew) @method('PUT') @endunless
  <div class="row">
    <div class="col-xl-9">
      <div class="adm-card"><div class="adm-card-body">
        <div class="row">
          <div class="col-md-6"><x-admin.input name="title" label="Title" :value="$page->title" required /></div>
          <div class="col-md-6"><x-admin.input name="title_bn" label="Title" :value="$page->title_bn" bn /></div>
          <div class="col-md-6">
            @if ($page->isSystem())
              <div class="form-group"><label>Address</label><input class="form-control" value="/{{ $page->slug }}" disabled><small class="form-text text-muted">Built-in page; the address cannot change.</small></div>
            @else
              <x-admin.input name="slug" label="URL slug" :value="$page->slug" data-slug-source="#f_title" help="The page will be at /page/your-slug." />
            @endif
          </div>
        </div>
        @if ($page->slug === 'contact')
          <div class="alert alert-info small">This text appears above the contact form. Phone numbers, email and address are edited under <a href="{{ route('admin.settings.edit') }}#contact">Settings → Contact</a>.</div>
        @endif
        <x-admin.textarea name="content" label="Content" :value="$page->content" editor />
        <x-admin.textarea name="content_bn" label="Content" :value="$page->content_bn" editor bn />
      </div></div>

      <div class="adm-card">
        <div class="adm-card-header"><h2>SEO</h2></div>
        <div class="adm-card-body">
          <x-admin.input name="seo_title" label="SEO title" :value="$page->seo_title" help="Leave empty to use the page title." />
          <x-admin.textarea name="seo_description" label="Meta description" :value="$page->seo_description" rows="2" maxlength="300" />
          <x-admin.input name="seo_keywords" label="Keywords" :value="$page->seo_keywords" />
          <x-admin.image name="og_image" label="Social sharing image" :current="$page->og_image" help="1200×630 recommended. Defaults to the site sharing image." removable />
        </div>
      </div>
    </div>
    <div class="col-xl-3">
      <div class="adm-card"><div class="adm-card-body">
        <x-admin.switch name="is_published" label="Published" :checked="$page->is_published" />
        <x-admin.image name="banner_image" label="Header image" :current="$page->banner_image" help="Optional wide photo behind the page title." removable />
        <button class="btn btn-accent btn-block" type="submit"><i class="fa fa-save"></i> {{ $isNew ? 'Create page' : 'Save page' }}</button>
      </div></div>
    </div>
  </div>
</form>
@endsection
