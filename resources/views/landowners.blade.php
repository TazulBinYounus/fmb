@extends('layout')

@section('title', __('Landowners – Develop Your Land with FMB Developments'))
@section('description', __('Own land in Dhaka? Develop it with FMB Developments Ltd on a joint-venture basis. Send your land details or call us.'))

@section('content')

<section class="bd-dev-hero" style="background-image: linear-gradient(90deg, rgba(17,24,39,.88) 0%, rgba(17,24,39,.45) 70%), url({{ asset('assets/images/background/5.jpg') }});">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('development') }}">{{ __('Real Estate') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Landowners') }}</li>
    </ol>
    <h1>{{ __('Have land in Dhaka?') }}</h1>
    <p class="lead">{{ __('Turn it into a modern building with FMB Developments Ltd. We handle design, approvals and construction; you share in the finished apartments.') }}</p>
    <a href="#proposal" class="btn btn-lg btn-thm mt10">{{ __('Send Land Details') }}</a>
    @if (setting('real_estate_phone'))<a href="tel:{{ setting('real_estate_phone') }}" class="btn btn-lg btn-outline-light mt10 ml10"><i class="fa fa-phone"></i> {{ setting('real_estate_phone_display', setting('real_estate_phone')) }}</a>@endif
  </div>
</section>

<section class="pt50 pb30">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="mb30">{{ __('How a joint venture works') }}</h2>
        <ol class="bd-steps">
          <li><strong>{{ __('Share your land details') }}</strong> — {{ __('Location, size in katha, road width and ownership papers.') }}</li>
          <li><strong>{{ __('Site survey & proposal') }}</strong> — {{ __('Our team visits the land and offers a sharing ratio and signing money proposal.') }}</li>
          <li><strong>{{ __('Agreement') }}</strong> — {{ __('A registered joint-venture agreement and power of attorney, with all terms in writing.') }}</li>
          <li><strong>{{ __('Design & approval') }}</strong> — {{ __('Architectural design and RAJUK plan approval handled by us.') }}</li>
          <li><strong>{{ __('Construction & handover') }}</strong> — {{ __('We build and hand over your share of apartments and parking.') }}</li>
        </ol>
      </div>
      <div class="col-lg-6">
        <h2 class="mb30">{{ __('What we look for') }}</h2>
        <ul class="list-unstyled">
          <li class="mb15"><i class="fa fa-check text-thm mr10"></i>{{ __('Land in residential areas of Dhaka') }}</li>
          <li class="mb15"><i class="fa fa-check text-thm mr10"></i>{{ __('Clear title with mutation (namjari) and up-to-date land tax (khajna)') }}</li>
          <li class="mb15"><i class="fa fa-check text-thm mr10"></i>{{ __('Good road access') }}</li>
        </ul>
        <p class="mt20">{{ __('Not sure if your land qualifies? Send the details anyway and we will advise you.') }}</p>
      </div>
    </div>
  </div>
</section>

<section id="proposal" class="bgc-f7 pt50 pb50">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="form_grid">
          <h2 class="mb5">{{ __('Send Land Details') }}</h2>
          <p>{{ __('Our land team will contact you after reviewing the details. Your information is kept confidential.') }}</p>
          @include('partials.form-alerts')
          <form action="{{ route('contact.send') }}#proposal" method="post">
            @csrf
            <input type="hidden" name="type" value="landowner">
            <input type="text" name="website" class="bd-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="row">
              <div class="col-md-6 form-group"><input name="name" class="form-control" required maxlength="100" value="{{ old('name') }}" placeholder="{{ __('Your Name') }} *"></div>
              <div class="col-md-6 form-group"><input name="phone" type="tel" class="form-control" required maxlength="20" value="{{ old('phone') }}" placeholder="{{ __('Phone / WhatsApp (e.g. 01712345678)') }} *"></div>
              <div class="col-md-12 form-group"><input name="land_location" class="form-control" required maxlength="200" value="{{ old('land_location') }}" placeholder="{{ __('Land location (area, road, plot no.)') }} *"></div>
              <div class="col-md-6 form-group"><input name="land_size" class="form-control" required maxlength="50" value="{{ old('land_size') }}" placeholder="{{ __('Land size (katha)') }} *"></div>
              <div class="col-md-6 form-group"><input name="road_width" class="form-control" maxlength="50" value="{{ old('road_width') }}" placeholder="{{ __('Front road width (feet)') }}"></div>
              <div class="col-md-12 form-group"><input name="email" type="email" class="form-control" maxlength="150" value="{{ old('email') }}" placeholder="{{ __('Email (optional)') }}"></div>
              <div class="col-12 form-group"><textarea name="message" class="form-control" rows="3" maxlength="3000" placeholder="{{ __('Anything else we should know (optional)') }}">{{ old('message') }}</textarea></div>
              <div class="col-12"><button type="submit" class="btn btn-lg btn-thm">{{ __('Send Land Details') }}</button></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@include('partials.faqs', ['faqs' => $faqs, 'id' => 'land-faq'])

@endsection
