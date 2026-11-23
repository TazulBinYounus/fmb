@extends('layout')

@section('title', $project->seoTitle())
@section('description', $project->seo_description ?: \Illuminate\Support\Str::limit(strip_tags($project->tr('summary') ?: $project->tr('description')), 160))
@section('keywords', $project->seo_keywords ?? '')
@section('og_image', media_url($project->og_image ?: $project->cover_image, 'assets/images/background/5.jpg'))

@section('content')

@php
  $devPhone = setting('real_estate_phone', setting('phone'));
  $devPhoneDisplay = setting('real_estate_phone_display', $devPhone);
  $specs = $project->specRows();
  $amenities = $project->amenityNames();
  $video = $project->videoEmbedUrl();
  $map = $project->mapEmbedUrl();
  $description = $project->tr('description');
  $payment = $project->tr('payment_info');
  $sections = array_filter([
    'overview' => ($description || $payment || $project->priceRange()) ? __('Overview') : null,
    'glance' => __('At a Glance'),
    'units' => $project->units->isNotEmpty() ? __('Units & Prices') : null,
    'floor-plans' => $project->floorPlans->isNotEmpty() ? __('Floor Plans') : null,
    'amenities' => $amenities ? __('Features & Amenities') : null,
    'gallery' => $project->gallery->isNotEmpty() ? __('Gallery') : null,
    'video' => $video ? __('Video') : null,
    'location' => $map ? __('Location') : null,
    'visit' => __('Book a Site Visit'),
  ]);
@endphp

<!-- Hero -->
<section class="bd-dev-hero" style="background-image: linear-gradient(90deg, rgba(17,24,39,.85) 0%, rgba(17,24,39,.4) 70%), url('{{ $project->coverUrl() }}');">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('Our Projects') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $project->tr('name') }}</li>
    </ol>
    <span class="bd-badge bd-status-{{ $project->status }}">{{ $project->statusLabel() }}</span>
    <h1>{{ $project->tr('name') }}</h1>
    @if ($project->tr('location'))<p class="lead"><i class="fa fa-map-marker"></i> {{ $project->tr('location') }}</p>@endif
    @if ($project->priceRange())<p class="lead font-weight-bold">{{ $project->priceRange() }}</p>@endif
    @if ($devPhone)<a href="tel:{{ $devPhone }}" class="btn btn-lg btn-thm mt10"><i class="fa fa-phone"></i> {{ $devPhoneDisplay }}</a>@endif
    <a href="#visit" class="btn btn-lg btn-outline-light mt10 ml10">{{ __('Book a Site Visit') }}</a>
    @if ($project->brochure)<a href="{{ media_url($project->brochure) }}" target="_blank" rel="noopener" class="btn btn-lg btn-outline-light mt10 ml10"><i class="fa fa-file-pdf-o"></i> {{ __('Download Brochure') }}</a>@endif
  </div>
</section>

<!-- Section links -->
<nav class="bd-subnav" aria-label="{{ __('Project sections') }}">
  <div class="container">
    @foreach ($sections as $id => $label)
      <a href="#{{ $id }}">{{ $label }}</a>
    @endforeach
  </div>
</nav>

@if (isset($sections['overview']))
<section id="overview" class="pt50 pb20">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h2 class="mb20">{{ __('Overview') }}</h2>
        @if ($project->tr('summary'))<p class="lead">{{ $project->tr('summary') }}</p>@endif
        @if ($description)<div class="bd-richtext">{!! $description !!}</div>@endif
      </div>
      @if ($payment || $project->priceRange() || $project->handover_date)
      <div class="col-lg-4">
        <div class="bd-callout mb30">
          <h4>{{ __('Price & Payment') }}</h4>
          @if ($project->priceRange())<p class="h5 text-white">{{ $project->priceRange() }}</p>@endif
          @if ($project->handover_date)<p>{{ __('Expected handover') }}: <strong class="text-white">{{ $project->handover_date->translatedFormat('F Y') }}</strong></p>@endif
          @if ($payment)
            <ul class="pl20 mb0">
              @foreach (preg_split('/\R/', $payment) as $line)
                @if (trim($line) !== '')<li>{{ trim($line) }}</li>@endif
              @endforeach
            </ul>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</section>
@endif

<!-- At a glance -->
<section id="glance" class="pt50 pb30">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <h2 class="mb20">{{ __('At a Glance') }}</h2>
        <table class="table bd-glance">
          <tbody>
            <tr><th>{{ __('Project') }}</th><td>{{ $project->tr('name') }}</td></tr>
            <tr><th>{{ __('Type') }}</th><td>{{ $project->typeLabel() }}</td></tr>
            <tr><th>{{ __('Status') }}</th><td>{{ $project->statusLabel() }}</td></tr>
            @if ($project->tr('location'))<tr><th>{{ __('Location') }}</th><td>{{ $project->tr('location') }}</td></tr>@endif
            @if ($project->address)<tr><th>{{ __('Address') }}</th><td>{{ $project->address }}</td></tr>@endif
            @foreach ($specs as [$label, $value])
              <tr><th>{{ $label }}</th><td>@if (filled($value)){{ $value }}@else<span class="text-muted">{{ __('To be announced') }}</span>@endif</td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="col-lg-5">
        <div class="bd-callout">
          <h4>{{ __('Interested in this project?') }}</h4>
          <p>{{ __('Register early to get floor plans, prices and the payment schedule from our sales team.') }}</p>
          @if ($devPhone)<a href="tel:{{ $devPhone }}" class="btn btn-thm btn-block mb10"><i class="fa fa-phone"></i> {{ __('Call') }} {{ $devPhoneDisplay }}</a>@endif
          @if (setting('whatsapp'))
            <a href="https://wa.me/{{ setting('whatsapp') }}?text={{ rawurlencode(__('I am interested in :project', ['project' => $project->tr('name')])) }}" target="_blank" rel="noopener" class="btn btn-success btn-block mb10"><i class="fa fa-whatsapp"></i> WhatsApp</a>
          @endif
          @if (setting('messenger_url'))<a href="{{ setting('messenger_url') }}" target="_blank" rel="noopener" class="btn btn-primary btn-block"><i class="fa fa-comment"></i> Messenger</a>@endif
        </div>
      </div>
    </div>
  </div>
</section>

@if ($project->units->isNotEmpty())
<section id="units" class="bgc-f7 pt50 pb30">
  <div class="container">
    <h2 class="mb20">{{ __('Units & Prices') }}</h2>
    <div class="table-responsive">
      <table class="table bd-glance bg-white">
        <thead><tr><th>{{ __('Unit') }}</th><th>{{ __('Size') }}</th><th>{{ __('Bedrooms') }}</th><th>{{ __('Bathrooms') }}</th><th>{{ __('Balconies') }}</th><th>{{ __('Price') }}</th><th>{{ __('Availability') }}</th><th></th></tr></thead>
        <tbody>
          @foreach ($project->units as $unit)
            <tr>
              <td><strong>{{ $unit->name }}</strong></td>
              <td>{{ $unit->size_sqft ? number_format($unit->size_sqft).' '.__('sft') : '—' }}</td>
              <td>{{ $unit->bedrooms ?? '—' }}</td>
              <td>{{ $unit->bathrooms ?? '—' }}</td>
              <td>{{ $unit->balconies ?? '—' }}</td>
              <td>{{ $unit->price ? bdt($unit->price) : __('On request') }}</td>
              <td><span class="bd-avail bd-avail-{{ $unit->availability }}">{{ __(\App\Models\ProjectUnit::AVAILABILITY[$unit->availability] ?? $unit->availability) }}</span></td>
              <td>@if ($unit->floor_plan)<a href="{{ media_url($unit->floor_plan) }}" target="_blank" rel="noopener">{{ __('Floor plan') }}</a>@endif</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endif

@if ($project->floorPlans->isNotEmpty())
<section id="floor-plans" class="pt50 pb30">
  <div class="container">
    <h2 class="mb30">{{ __('Floor Plans') }}</h2>
    <div class="row">
      @foreach ($project->floorPlans as $plan)
        <div class="col-md-6 mb30">
          <a href="{{ $plan->url() }}" target="_blank" rel="noopener" class="d-block bd-plan">
            <img class="img-fluid bd-rounded" loading="lazy" src="{{ $plan->url() }}" alt="{{ $plan->tr('caption') ?: __('Floor plan') }}">
          </a>
          @if ($plan->tr('caption'))<p class="text-center mt10 mb0">{{ $plan->tr('caption') }}</p>@endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if ($amenities)
<section id="amenities" class="bgc-f7 pt50 pb30">
  <div class="container">
    <h2 class="mb30">{{ __('Features & Amenities') }}</h2>
    <div class="row">
      @foreach ($amenities as $amenity)
        <div class="col-6 col-md-4 col-lg-3 mb20"><i class="fa fa-check-circle text-thm mr10"></i>{{ $amenity }}</div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if ($project->gallery->isNotEmpty())
<section id="gallery" class="pt50 pb30">
  <div class="container">
    <h2 class="mb30">{{ __('Gallery') }}</h2>
    <div class="row">
      @foreach ($project->gallery as $img)
        <div class="col-6 col-md-4 mb30">
          <a href="{{ $img->url() }}" target="_blank" rel="noopener">
            <img class="img-fluid bd-rounded bd-gallery-img" loading="lazy" src="{{ $img->url() }}" alt="{{ $img->tr('caption') ?: $project->tr('name') }}">
          </a>
          @if ($img->tr('caption'))<p class="small text-center mt5 mb0">{{ $img->tr('caption') }}</p>@endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if ($video)
<section id="video" class="bgc-f7 pt50 pb50">
  <div class="container">
    <h2 class="mb30">{{ __('Video') }}</h2>
    <div class="embed-responsive embed-responsive-16by9 bd-rounded">
      <iframe class="embed-responsive-item" src="{{ $video }}" title="{{ $project->tr('name') }}" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen" allowfullscreen></iframe>
    </div>
  </div>
</section>
@endif

@if ($map)
<section id="location" class="pt50 pb30">
  <div class="container">
    <h2 class="mb20">{{ __('Location') }}</h2>
    <p><i class="fa fa-map-marker text-thm"></i> {{ $project->address ?: $project->tr('location') }}</p>
    <div class="bd-map bd-rounded overflow-hidden">
      <iframe title="{{ __('Project location on Google Maps') }}" src="{{ $map }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
  </div>
</section>
@endif

@include('partials.testimonials', ['testimonials' => $project->testimonials, 'class' => 'bgc-f7 pt50 pb30'])

<!-- Site visit -->
<section id="visit" class="pt50 pb50">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="form_grid">
          <h2 class="mb5">{{ __('Book a Site Visit') }}</h2>
          <p>{{ __('Leave your name and phone number. Our team will call you to fix a convenient time.') }}</p>
          @include('partials.form-alerts')
          <form action="{{ route('contact.send') }}#visit" method="post">
            @csrf
            <input type="hidden" name="type" value="site_visit">
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input type="text" name="website" class="bd-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="row">
              <div class="col-md-6 form-group"><input name="name" class="form-control" required maxlength="100" value="{{ old('name') }}" placeholder="{{ __('Your Name') }} *" aria-label="{{ __('Your Name') }}"></div>
              <div class="col-md-6 form-group"><input name="phone" type="tel" class="form-control" required maxlength="20" value="{{ old('phone') }}" placeholder="{{ __('Phone / WhatsApp (e.g. 01712345678)') }} *" aria-label="{{ __('Phone') }}"></div>
              <div class="col-md-6 form-group"><input name="email" type="email" class="form-control" maxlength="150" value="{{ old('email') }}" placeholder="{{ __('Email (optional)') }}" aria-label="{{ __('Email') }}"></div>
              <div class="col-md-6 form-group">
                <label class="sr-only" for="preferred_date">{{ __('Preferred visit date') }}</label>
                <input id="preferred_date" name="preferred_date" type="date" class="form-control" min="{{ now()->toDateString() }}" value="{{ old('preferred_date') }}" title="{{ __('Preferred visit date') }}">
              </div>
              <div class="col-12 form-group"><textarea name="message" class="form-control" rows="3" maxlength="3000" placeholder="{{ __('Flat size or budget you are looking for (optional)') }}" aria-label="{{ __('Message') }}">{{ old('message') }}</textarea></div>
              <div class="col-12"><button type="submit" class="btn btn-lg btn-thm">{{ __('Request Site Visit') }}</button></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@if ($related->isNotEmpty())
<section class="bgc-f7 pt50 pb30">
  <div class="container">
    <h2 class="text-center mb30">{{ __('More Projects') }}</h2>
    <div class="row justify-content-center">
      @foreach ($related as $other)
        <div class="col-md-6 col-lg-4">@include('partials.project-card', ['project' => $other])</div>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection
