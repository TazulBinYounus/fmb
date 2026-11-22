@extends('layout')

@section('title', __('FMB Developments Ltd – Real Estate'))
@section('description', __('FMB Developments Ltd, a concern of FMB Group, builds and sells apartments in Dhaka. Upcoming project in Bashundhara Riverview Residential Area. Call 01312-149719.'))

@section('content')

@php
  $devPhone = '+8801312149719';
  $devPhoneDisplay = '01312-149719';
  $devEmail = 'fmb@fmbgroupbd.com';
@endphp

<!-- Hero -->
<section class="bd-dev-hero" style="background-image: linear-gradient(90deg, rgba(17,24,39,.85) 0%, rgba(17,24,39,.45) 60%, rgba(17,24,39,.15) 100%), url({{ asset('assets/images/background/5.jpg') }});">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Real Estate') }}</li>
        </ol>
        <img src="{{ asset('assets/images/fmb-logo-white.png') }}" alt="FMB" class="bd-dev-hero-logo">
        <h1>FMB Developments Ltd</h1>
        <p class="lead">{{ __('Your trusted partner for premium building & property development solutions in Dhaka.') }}</p>
        <a href="tel:{{ $devPhone }}" class="btn btn-lg btn-thm mt10"><i class="fa fa-phone"></i> {{ $devPhoneDisplay }}</a>
        <a href="{{ url('/contact') }}?type=property" class="btn btn-lg btn-outline-light mt10 ml10">{{ __('Book a Site Visit') }}</a>
      </div>
    </div>
  </div>
</section>

<!-- About -->
<section class="pt60 pb30">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h2>{{ __('About FMB Developments') }}</h2>
        <p>{{ __('FMB Developments Ltd is the real estate concern of FMB Group, headquartered in Jatrabari, Dhaka. We develop residential buildings and apartments for families who want a safe, well-built home in a good neighbourhood.') }}</p>
        <p>{{ __('From land selection and design approval to construction and handover, we manage every step and keep buyers informed throughout.') }}</p>
      </div>
      <div class="col-lg-6">
        <img class="img-fluid bd-rounded" src="{{ asset('assets/images/property/2.jpg') }}" alt="{{ __('Apartment interior (illustrative)') }}">
      </div>
    </div>
  </div>
</section>

<!-- Services -->
<section class="bgc-f7 pb30">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center mb30">
        <h2>{{ __('What We Do') }}</h2>
      </div>
    </div>
    <div class="row">
      @foreach ([
        ['fa-building', 'Apartment Projects', 'Residential apartment buildings in Dhaka with practical layouts for families.'],
        ['fa-handshake-o', 'Joint Venture with Landowners', 'Own land in Dhaka? We develop it with you on a fair joint-venture sharing basis.'],
        ['fa-cubes', 'Construction & Engineering', 'Building construction supervised by experienced engineers with quality materials.'],
        ['fa-key', 'Flat Sales & Handover', 'Clear documentation, flexible payment schedules and support through registration and handover.'],
      ] as [$icon, $title, $text])
      <div class="col-md-6 col-lg-3">
        <div class="bd-feature">
          <i class="fa {{ $icon }}"></i>
          <h4>{{ __($title) }}</h4>
          <p>{{ __($text) }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Projects -->
<section class="pt60 pb30">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center mb30">
        <h2>{{ __('Our Projects') }}</h2>
        <p>{{ __('Contact us for floor plans, sizes, prices and booking.') }}</p>
      </div>
    </div>
    {{-- TODO: replace the illustrative photo and add real project facts (land size, storeys, flat sizes, handover date) --}}
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="bd-project">
          <div class="bd-project-img" style="background-image:url({{ asset('assets/images/background/5.jpg') }})">
            <span class="bd-badge">{{ __('Upcoming') }}</span>
          </div>
          <div class="p25">
            <h4>{{ __('FMB Project – Bashundhara Riverview') }}</h4>
            <p><i class="fa fa-map-marker text-thm mr5"></i> {{ __('Bashundhara Riverview Residential Area, Dhaka') }}</p>
            <p>{{ __('Residential apartments for sale. Register your interest now to get details first.') }}</p>
            <a href="tel:{{ $devPhone }}" class="btn btn-thm"><i class="fa fa-phone"></i> {{ __('Call for details') }}</a>
            <a href="{{ url('/contact') }}?type=property" class="btn btn-outline-secondary ml5">{{ __('Register interest') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="bgc-f7 pt50 pb50">
  <div class="container text-center">
    <h2>{{ __('Looking for a flat in Dhaka?') }}</h2>
    <p class="mb30">{{ __('Talk to our sales team or visit our office in Jatrabari.') }}</p>
    <a href="tel:{{ $devPhone }}" class="btn btn-lg btn-thm"><i class="fa fa-phone"></i> {{ $devPhoneDisplay }}</a>
    <a href="mailto:{{ $devEmail }}" class="btn btn-lg btn-outline-secondary ml10"><i class="fa fa-envelope"></i> {{ $devEmail }}</a>
    <a href="https://www.facebook.com/fmbdevelopmentsltd" target="_blank" rel="noopener" class="btn btn-lg btn-primary ml10"><i class="fa fa-facebook"></i> {{ __('Follow on Facebook') }}</a>
  </div>
</section>

@endsection
