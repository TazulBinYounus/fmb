@extends('admin.layout')

@php $isNew = ! $testimonial->exists; @endphp
@section('title', $isNew ? 'New testimonial' : 'Edit testimonial')

@section('actions')
  <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> All testimonials</a>
@endsection

@section('content')
<form method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.testimonials.store') : route('admin.testimonials.update', $testimonial) }}">
  @csrf
  @unless ($isNew) @method('PUT') @endunless
  <div class="row">
    <div class="col-xl-8">
      <div class="adm-card"><div class="adm-card-body">
        <div class="row">
          <div class="col-md-6"><x-admin.input name="name" label="Name" :value="$testimonial->name" required /></div>
          <div class="col-md-6"><x-admin.input name="name_bn" label="Name" :value="$testimonial->name_bn" bn /></div>
          <div class="col-md-6"><x-admin.input name="designation" label="Designation" :value="$testimonial->designation" placeholder="e.g. Flat owner, Business owner" /></div>
          <div class="col-md-6"><x-admin.input name="designation_bn" label="Designation" :value="$testimonial->designation_bn" bn /></div>
          <div class="col-md-6"><x-admin.textarea name="quote" label="Quote" :value="$testimonial->quote" rows="5" required /></div>
          <div class="col-md-6"><x-admin.textarea name="quote_bn" label="Quote" :value="$testimonial->quote_bn" rows="5" bn /></div>
        </div>
      </div></div>
    </div>
    <div class="col-xl-4">
      <div class="adm-card"><div class="adm-card-body">
        <x-admin.select name="project_id" label="Project (optional)" :options="$projects" :value="$testimonial->project_id" placeholder="— None —" help="Linked testimonials also appear on that project’s page." />
        <x-admin.select name="rating" label="Rating (optional)" :options="[5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★']" :value="$testimonial->rating" placeholder="— No rating —" />
        <x-admin.image name="photo" label="Photo (optional)" :current="$testimonial->photo" removable help="Square photo works best." />
        <x-admin.input name="sort_order" label="Display order" type="number" min="0" :value="$testimonial->sort_order ?? 0" />
        <x-admin.switch name="is_active" label="Show on website" :checked="$testimonial->is_active" />
        <button class="btn btn-accent btn-block" type="submit"><i class="fa fa-save"></i> Save</button>
      </div></div>
    </div>
  </div>
</form>
@endsection
