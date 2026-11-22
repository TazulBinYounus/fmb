{{-- Shared product gallery. Expects: $heading, $folder, $count --}}
@extends('layout')

@section('title', $heading)

@section('content')

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item">{{ __('Our Collection') }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $heading }}</li>
          </ol>
          <h4 class="breadcrumb_title">{{ $heading }}</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section mb30">
  <div class="container">
    <div class="row">
      @for ($i = 1; $i <= $count; $i++)
        <div class="col-6 col-md-3 col-lg-2 mb-4">
          <div class="gallery_item">
            <img class="img-fluid img-circle-rounded" loading="lazy"
              src="{{ asset('assets/images/' . $folder . '/' . $i . '.jpg') }}"
              alt="{{ $heading }} {{ $i }}">
          </div>
        </div>
      @endfor
    </div>
    <div class="text-center mt30">
      <p>{{ __('Interested in these styles? We can develop them to your specification.') }}</p>
      <a href="{{ url('/contact') }}" class="btn btn-lg btn-thm">{{ __('Request a Quote') }}</a>
    </div>
  </div>
</section>

@endsection
