@extends('layout')

@section('title', __('Our Management'))

@section('content')

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Management') }}</li>
          </ol>
          <h4 class="breadcrumb_title">{{ __('Our Management') }}</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="bgc-f7 pt40 pb10">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 text-center">
        <h2>{{ __('Leadership & Management') }}</h2>
        <p>{{ __('At FMB Group, our leadership team brings extensive experience in garments sourcing, production management, quality control, and international trade. Their strategic vision and industry knowledge help us maintain strong partnerships with buyers and manufacturers worldwide while ensuring quality, reliability, and timely delivery.') }}</p>
      </div>
    </div>
  </div>
</section>

@php
  $leaders = [
    [
      'photo' => 'firoz.jpg',
      'name' => __('MD. FIROZ ALAM'),
      'role' => __('Managing Director'),
      'bio' => __('MD. Firoz Alam is the Managing Director of FMB Group and plays a key role in shaping the company’s strategic direction. With deep experience in the garments and textile industry, he oversees business development, buyer relationships, and international sourcing operations.'),
      'points' => [__('Strategic business leadership'), __('International buyer relationship management'), __('Production and sourcing oversight'), __('Export market development')],
    ],
    [
      'photo' => 'mamun.jpg',
      'name' => __('MD. AL MAMUN'),
      'role' => __('Chairman'),
      'bio' => __('As Chairman of FMB Group, MD. Al Mamun provides strategic leadership and long-term vision for the organization. He focuses on sustainable growth, strong governance, and building global partnerships within the apparel manufacturing and sourcing industry.'),
      'points' => [__('Corporate strategy and governance'), __('Global partnership development'), __('Sustainable business growth'), __('Industry leadership')],
    ],
  ];
@endphp

<section class="our-team bgc-f7 pb70">
  <div class="container">
    <div class="row justify-content-center">
      @foreach ($leaders as $leader)
      <div class="col-md-6 col-lg-5">
        <div class="team_member text-center">
          <div class="thumb">
            <img class="img-fluid w-100"
              src="{{ asset('assets/images/management/' . $leader['photo']) }}"
              alt="{{ $leader['name'] }}"
              onerror="this.onerror=null;this.src='{{ asset('assets/images/management/default-user.jpg') }}';">
          </div>
          <div class="details p20">
            <h4>{{ $leader['name'] }}</h4>
            <p class="text-thm pb10"><strong>{{ $leader['role'] }}</strong></p>
            <p>{{ $leader['bio'] }}</p>
            <ul class="list-unstyled mt15">
              @foreach ($leader['points'] as $point)
                <li>✔ {{ $point }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
