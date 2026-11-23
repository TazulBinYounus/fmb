@extends('layout')

@section('title', $page?->seo_title ?: ($page?->tr('title') ?: __('Contact Us')))
@if ($page?->seo_description)
  @section('description', $page->seo_description)
@endif

@section('content')

@php
  $phone = setting('phone');
  $email = setting('email');
  $wa = setting('whatsapp');
  $mapQuery = setting('map_query');
@endphp

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Contact') }}</li>
          </ol>
          <h4 class="breadcrumb_title">{{ $page?->tr('title') ?: __('Contact Us') }}</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="our-contact pb0 bgc-f7">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-xl-8">
        <div class="form_grid">
          <h4 class="mb5">{{ __('Send Us an Enquiry') }}</h4>
          @if ($page?->tr('content'))
            <div class="bd-richtext">{!! $page->tr('content') !!}</div>
          @endif

          @include('partials.form-alerts')

          <form class="contact_form" id="contact_form" action="{{ route('contact.send') }}" method="post">
            @csrf
            <input type="text" name="website" class="bd-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input name="name" class="form-control" required type="text" maxlength="100" value="{{ old('name') }}" placeholder="{{ __('Your Name') }} *">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input name="company" class="form-control" type="text" maxlength="150" value="{{ old('company') }}" placeholder="{{ __('Company / Brand') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input name="email" class="form-control" required type="email" maxlength="150" value="{{ old('email') }}" placeholder="{{ __('Email') }} *">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input name="phone" class="form-control" required type="tel" maxlength="20" value="{{ old('phone') }}" placeholder="{{ __('Phone / WhatsApp (e.g. 01712345678)') }} *">
                </div>
              </div>
              <div class="col-sm-12">
                @php $type = old('type', request('type', 'garments')); @endphp
                <div class="form-group">
                  <select name="type" class="form-control" aria-label="{{ __('Enquiry type') }}">
                    <option value="garments" @selected($type === 'garments')>{{ __('Garments sourcing / buying') }}</option>
                    <option value="property" @selected($type === 'property')>{{ __('Flat / property (FMB Developments)') }}</option>
                    <option value="other" @selected($type === 'other')>{{ __('Other') }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <input name="subject" class="form-control" required type="text" maxlength="150" value="{{ old('subject') }}" placeholder="{{ __('Subject') }} *">
                </div>
                <div class="form-group">
                  <textarea name="message" class="form-control" rows="8" required maxlength="3000" placeholder="{{ __('Your Message') }} *">{{ old('message') }}</textarea>
                </div>
                <div class="form-group mb0">
                  <button type="submit" class="btn btn-lg btn-thm">{{ __('Send Message') }}</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-5 col-xl-4">
        <div class="contact_localtion">
          <h4>{{ __('Contact Us') }}</h4>
          <p>{{ setting('footer_about', '', true) }}</p>
          <div class="content_list">
            <h5>{{ __('Address') }}</h5>
            <p>{{ setting('address_line1', '', true) }}@if (setting('address_line2'))<br>{{ setting('address_line2', '', true) }}@endif</p>
          </div>
          @if ($phone)
          <div class="content_list">
            <h5>{{ __('Phone') }}</h5>
            <p><a href="tel:{{ $phone }}">{{ setting('phone_display', $phone) }}</a></p>
          </div>
          @endif
          @if ($wa)
          <div class="content_list">
            <h5>WhatsApp</h5>
            <p><a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i> {{ setting('phone_display', '+'.$wa) }}</a></p>
          </div>
          @endif
          @if ($email)
          <div class="content_list">
            <h5>{{ __('Email') }}</h5>
            <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
          </div>
          @endif
          @if (setting('real_estate_phone') || setting('real_estate_email'))
          <div class="content_list">
            <h5>{{ __('Real Estate (FMB Developments Ltd)') }}</h5>
            <p>
              @if (setting('real_estate_phone'))<a href="tel:{{ setting('real_estate_phone') }}">{{ setting('real_estate_phone_display', setting('real_estate_phone')) }}</a><br>@endif
              @if (setting('real_estate_email'))<a href="mailto:{{ setting('real_estate_email') }}">{{ setting('real_estate_email') }}</a>@endif
            </p>
          </div>
          @endif
          @if (setting('office_hours'))
          <div class="content_list">
            <h5>{{ __('Office Hours') }}</h5>
            <p>{{ setting('office_hours', '', true) }}<br><small>{{ __('Bangladesh Standard Time (GMT+6)') }}</small></p>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

@if ($mapQuery)
<section class="bd-map pt0 pb0">
  <iframe
    title="{{ __('FMB Group location on Google Maps') }}"
    src="https://maps.google.com/maps?q={{ rawurlencode($mapQuery) }}&z=15&output=embed"
    loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
</section>
@endif

@endsection
