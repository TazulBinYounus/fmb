@extends('layout')

@section('title', $page->seo_title ?: $page->tr('title'))
@section('description', $page->seo_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($page->tr('content'))), 160))
@section('keywords', $page->seo_keywords ?? '')
@if ($page->og_image ?: $page->banner_image)
  @section('og_image', media_url($page->og_image ?: $page->banner_image))
@endif

@section('content')

<section class="inner_page_breadcrumb" @if ($page->banner_image) style="background-image: linear-gradient(rgba(17,24,39,.55), rgba(17,24,39,.55)), url('{{ media_url($page->banner_image) }}'); background-size: cover; background-position: center;" @endif>
  <div class="container">
    <div class="row">
      <div class="col-xl-8">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $page->tr('title') }}</li>
          </ol>
          <h1 class="breadcrumb_title">{{ $page->tr('title') }}</h1>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt50 pb50">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="bd-richtext">{!! $page->tr('content') !!}</div>
      </div>
    </div>
  </div>
</section>

@endsection
