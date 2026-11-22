@extends('layout')

@section('title', __('Contact Us'))

@section('content')

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Contact') }}</li>
          </ol>
          <h4 class="breadcrumb_title">{{ __('Contact Us') }}</h4>
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
          <p>{{ __('Tell us about the product, quantity and target price. Our merchandising team will get back to you soon (Saturday – Thursday).') }}</p>

          @if (session('contact_success'))
            <div class="alert alert-success">{{ __('Thank you! Your message has been sent. We will contact you soon.') }}</div>
          @endif
          @if (session('contact_error'))
            <div class="alert alert-danger">{{ __('Sorry, your message could not be sent. Please email or WhatsApp us directly.') }}</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

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
          <p>{{ __('FMB Group, based in Dhaka, Bangladesh, is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items.') }}</p>
          <div class="content_list">
            <h5>{{ __('Address') }}</h5>
            <p>{{ __('174, East Dholipar, Jatrabari') }}<br>{{ __('Dhaka 1204, Bangladesh') }}</p>
          </div>
          <div class="content_list">
            <h5>{{ __('Phone') }}</h5>
            <p><a href="tel:+8801612149719">+880 1612-149719</a></p>
          </div>
          <div class="content_list">
            <h5>WhatsApp</h5>
            <p><a href="https://wa.me/8801612149719" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i> +880 1612-149719</a></p>
          </div>
          <div class="content_list">
            <h5>{{ __('Email') }}</h5>
            <p><a href="mailto:info@fmbgroupbd.com">info@fmbgroupbd.com</a></p>
          </div>
          <div class="content_list">
            <h5>{{ __('Real Estate (FMB Developments Ltd)') }}</h5>
            <p><a href="tel:+8801312149719">01312-149719</a><br><a href="mailto:fmb@fmbgroupbd.com">fmb@fmbgroupbd.com</a></p>
          </div>
          <div class="content_list">
            <h5>{{ __('Office Hours') }}</h5>
            <p>{{ __('Saturday – Thursday: 9:00 AM – 6:00 PM') }}<br>{{ __('Friday & government holidays: closed') }}<br><small>{{ __('Bangladesh Standard Time (GMT+6)') }}</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="bd-map pt0 pb0">
  <iframe
    title="{{ __('FMB Group location on Google Maps') }}"
    src="https://maps.google.com/maps?q={{ rawurlencode('East Dholipar, Jatrabari, Dhaka 1204, Bangladesh') }}&z=15&output=embed"
    loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
</section>

@endsection
