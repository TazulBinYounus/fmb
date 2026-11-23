@extends('admin.layout')

@php $isNew = ! $faq->exists; @endphp
@section('title', $isNew ? 'New FAQ' : 'Edit FAQ')

@section('actions')
  <a href="{{ route('admin.faqs.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> All FAQs</a>
@endsection

@section('content')
<form method="post" action="{{ $isNew ? route('admin.faqs.store') : route('admin.faqs.update', $faq) }}">
  @csrf
  @unless ($isNew) @method('PUT') @endunless
  <div class="row">
    <div class="col-xl-8">
      <div class="adm-card"><div class="adm-card-body">
        <x-admin.input name="question" label="Question" :value="$faq->question" required />
        <x-admin.input name="question_bn" label="Question" :value="$faq->question_bn" bn />
        <x-admin.textarea name="answer" label="Answer" :value="$faq->answer" rows="5" required />
        <x-admin.textarea name="answer_bn" label="Answer" :value="$faq->answer_bn" rows="5" bn />
      </div></div>
    </div>
    <div class="col-xl-4">
      <div class="adm-card"><div class="adm-card-body">
        <x-admin.select name="category" label="Shown on" :options="['general' => 'General (homepage)', 'real_estate' => 'Real estate (homepage + Real Estate page)', 'landowner' => 'Landowners page', 'garments' => 'Garments services page']" :value="$faq->category" required />
        <x-admin.input name="sort_order" label="Display order" type="number" min="0" :value="$faq->sort_order ?? 0" />
        <x-admin.switch name="is_active" label="Show on website" :checked="$faq->is_active" />
        <button class="btn btn-accent btn-block" type="submit"><i class="fa fa-save"></i> Save</button>
      </div></div>
    </div>
  </div>
</form>
@endsection
