@php
  $phone = '+8801612149719';
  $phoneDisplay = '+880 1612-149719';
  $whatsapp = 'https://wa.me/8801612149719?text=' . rawurlencode(__('Hello FMB Group, I would like to know more about your products.'));
  $email = 'info@fmbgroupbd.com';
  $locale = app()->getLocale();
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="{{ $locale }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('description', __('FMB Group, Dhaka: garments buying house for knit, woven, sweater and home textile, and FMB Developments Ltd for apartments and real estate in Dhaka.'))">
  <meta name="keywords" content="FMB Group, FMB Developments Ltd, flat sale Dhaka, apartment Bashundhara Riverview, real estate developer Dhaka, garments buying house Bangladesh, buying house Dhaka, knit garments Bangladesh, woven garments, sweater manufacturer Bangladesh, home textile Bangladesh, apparel sourcing Bangladesh, RMG export, FMB Group">
  <meta name="geo.region" content="BD-13">
  <meta name="geo.placename" content="Dhaka">
  <!-- Open Graph (Facebook / WhatsApp / LinkedIn link previews) -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="FMB Group">
  <meta property="og:title" content="@yield('title', __('Home')) | FMB Group">
  <meta property="og:description" content="{{ __('Garments sourcing and real estate development in Dhaka, Bangladesh.') }}">
  <meta property="og:image" content="{{ asset('assets/images/home/15.webp') }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:locale" content="{{ $locale === 'bn' ? 'bn_BD' : 'en_US' }}">

  <!-- Fonts: Hind Siliguri renders Bangla text cleanly -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bd.css') }}">

  <title>@yield('title', __('Home')) | FMB Group</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/fmb-favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/fmb-favicon.png') }}">

  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "Organization",
    "name": "FMB Group",
    "description": "Garments buying house and real estate developer (FMB Developments Ltd) in Dhaka, Bangladesh",
    "url": "{{ url('/') }}",
    "email": "{{ $email }}",
    "telephone": "{{ $phone }}",
    "logo": "{{ asset('assets/images/fmb-logo.png') }}",
    "sameAs": ["https://www.facebook.com/fmbdevelopmentsltd"],
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "174, East Dholipar, Jatrabari",
      "addressLocality": "Dhaka",
      "postalCode": "1204",
      "addressCountry": "BD"
    }
  }
  </script>
</head>

<body class="lang-{{ $locale }}">
  <div class="wrapper">
    <div class="preloader"></div>

    <!-- Top bar -->
    <div class="bd-topbar dn-smd">
      <div class="container d-flex justify-content-between align-items-center">
        <div>
          <a href="tel:{{ $phone }}"><i class="fa fa-phone"></i> {{ $phoneDisplay }}</a>
          <a href="mailto:{{ $email }}"><i class="fa fa-envelope"></i> {{ $email }}</a>
          <span><i class="fa fa-clock-o"></i> {{ __('Sat – Thu, 9:00 AM – 6:00 PM (BST)') }}</span>
        </div>
        <div class="bd-lang">
          <a href="{{ route('lang.switch', 'en') }}" class="{{ $locale === 'en' ? 'active' : '' }}">English</a>
          <span>|</span>
          <a href="{{ route('lang.switch', 'bn') }}" class="{{ $locale === 'bn' ? 'active' : '' }}">বাংলা</a>
        </div>
      </div>
    </div>

    <!-- Main Header Nav -->
    <header class="header-nav menu_style_home_one style2 home10 navbar-scrolltofixed stricky main-menu">
      <div class="container p0">
        <nav>
          <div class="menu-toggle">
            <button type="button" id="menu-btn">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <a href="{{ url('/') }}" class="navbar_brand float-left dn-smd">
            <img class="bd-logo" src="{{ asset('assets/images/fmb-logo.png') }}" alt="FMB Group">
          </a>
          <ul id="respMenu" class="ace-responsive-menu text-right" data-menu-style="horizontal">
            <li class="last"><a href="{{ url('/') }}"><span class="title">{{ __('Home') }}</span></a></li>
            <li>
              <a href="#"><span class="title">{{ __('Garments') }}</span></a>
              <ul>
                <li>
                  <a href="#"><span class="title">{{ __('KNIT') }}</span></a>
                  <ul>
                    <li><a href="{{ url('/collection/men-knit') }}">{{ __('MEN') }}</a></li>
                    <li><a href="{{ url('/collection/women-knit') }}">{{ __('WOMEN') }}</a></li>
                    <li><a href="{{ url('/collection/kid-knit') }}">{{ __('KIDS') }}</a></li>
                  </ul>
                </li>
                <li><a href="{{ url('/contact') }}"><span class="title">{{ __('WOVEN') }}</span></a></li>
                <li><a href="{{ url('/contact') }}"><span class="title">{{ __('SWEATER') }}</span></a></li>
                <li><a href="{{ url('/collection/home-tex') }}">{{ __('HOME TEXTILE') }}</a></li>
                <li><a href="{{ url('/garments/services') }}">{{ __('Sourcing Services') }}</a></li>
              </ul>
            </li>
            <li class="last"><a href="{{ url('/development') }}"><span class="title">{{ __('Real Estate') }}</span></a></li>
            <li class="last"><a href="{{ url('/our-management') }}"><span class="title">{{ __('Our Management') }}</span></a></li>
            <li class="last"><a href="{{ url('/contact') }}"><span class="title">{{ __('Contact') }}</span></a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Main Header Nav For Mobile -->
    <div id="page" class="stylehome1 h0">
      <div class="mobile-menu">
        <div class="header stylehome1">
          <div class="d-flex justify-content-between">
            <a class="mobile-menu-trigger" href="#menu"><img src="{{ asset('assets/images/dark-nav-icon.svg') }}" alt="{{ __('Menu') }}"></a>
            <a class="nav_logo_img" href="{{ url('/') }}"><img class="bd-logo" src="{{ asset('assets/images/fmb-logo.png') }}" alt="FMB Group"></a>
            <a class="mobile-menu-reg-link" href="tel:{{ $phone }}" aria-label="{{ __('Call us') }}"><span class="fa fa-phone"></span></a>
          </div>
        </div>
      </div>
      <nav id="menu" class="stylehome1">
        <ul>
          <li><a href="{{ url('/') }}"><span class="title">{{ __('Home') }}</span></a></li>
          <li>
            <a href="#"><span class="title">{{ __('Garments') }}</span></a>
            <ul>
              <li>
                <a href="#"><span class="title">{{ __('KNIT') }}</span></a>
                <ul>
                  <li><a href="{{ url('/collection/men-knit') }}">{{ __('MEN') }}</a></li>
                  <li><a href="{{ url('/collection/women-knit') }}">{{ __('WOMEN') }}</a></li>
                  <li><a href="{{ url('/collection/kid-knit') }}">{{ __('KIDS') }}</a></li>
                </ul>
              </li>
              <li><a href="{{ url('/contact') }}">{{ __('WOVEN') }}</a></li>
              <li><a href="{{ url('/contact') }}">{{ __('SWEATER') }}</a></li>
              <li><a href="{{ url('/collection/home-tex') }}">{{ __('HOME TEXTILE') }}</a></li>
              <li><a href="{{ url('/garments/services') }}">{{ __('Sourcing Services') }}</a></li>
            </ul>
          </li>
          <li><a href="{{ url('/development') }}"><span class="title">{{ __('Real Estate') }}</span></a></li>
          <li><a href="{{ url('/our-management') }}"><span class="title">{{ __('Our Management') }}</span></a></li>
          <li><a href="{{ url('/contact') }}"><span class="title">{{ __('Contact') }}</span></a></li>
          <li>
            @if ($locale === 'bn')
              <a href="{{ route('lang.switch', 'en') }}"><span class="title">English</span></a>
            @else
              <a href="{{ route('lang.switch', 'bn') }}"><span class="title">বাংলা</span></a>
            @endif
          </li>
        </ul>
      </nav>
    </div>

    <div>
      @yield('content')
    </div>

    <!-- Our Footer -->
    <section class="footer_one home6 bgc-f7">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 pr0 pl0">
            <div class="footer_about_widget home6">
              <img class="bd-footer-logo" src="{{ asset('assets/images/fmb-logo.png') }}" alt="FMB Group">
              <p>{{ __('FMB Group is a Dhaka-based business group in garments buying & sourcing and, through FMB Developments Ltd, real estate development.') }}</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_qlink_widget home6">
              <h4>{{ __('Quick Links') }}</h4>
              <ul class="list-unstyled">
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ url('/collection/men-knit') }}">{{ __('Our Collection') }}</a></li>
                <li><a href="{{ url('/garments/services') }}">{{ __('Sourcing Services') }}</a></li>
                <li><a href="{{ url('/development') }}">{{ __('FMB Developments (Real Estate)') }}</a></li>
                <li><a href="{{ url('/our-management') }}">{{ __('Our Management') }}</a></li>
                <li><a href="{{ url('/contact') }}">{{ __('Contact') }}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_contact_widget home6">
              <h4>{{ __('Contact Us') }}</h4>
              <ul class="list-unstyled">
                <li><a href="mailto:{{ $email }}">{{ $email }}</a></li>
                <li><a href="tel:{{ $phone }}">{{ $phoneDisplay }}</a></li>
                <li><a href="{{ $whatsapp }}" target="_blank" rel="noopener">WhatsApp: {{ $phoneDisplay }}</a></li>
                <li><a href="tel:+8801312149719">{{ __('Real estate') }}: 01312-149719</a></li>
                <li><a href="mailto:fmb@fmbgroupbd.com">fmb@fmbgroupbd.com</a></li>
                <li>{{ __('174, East Dholipar, Jatrabari') }}</li>
                <li>{{ __('Dhaka 1204, Bangladesh') }}</li>
                <li>{{ __('Sat – Thu, 9:00 AM – 6:00 PM (BST)') }}</li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_social_widget home6">
              <h4>{{ __('Follow us') }}</h4>
              {{-- TODO: replace # with the real LinkedIn page URL --}}
              <ul class="mb30">
                <li class="list-inline-item"><a href="https://www.facebook.com/fmbdevelopmentsltd" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa fa-facebook"></i></a></li>
                <li class="list-inline-item"><a href="#" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                <li class="list-inline-item"><a href="{{ $whatsapp }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa fa-whatsapp"></i></a></li>
              </ul>
              <h4>{{ __('Language') }}</h4>
              <p class="bd-lang">
                <a href="{{ route('lang.switch', 'en') }}" class="{{ $locale === 'en' ? 'active' : '' }}">English</a>
                <span>|</span>
                <a href="{{ route('lang.switch', 'bn') }}" class="{{ $locale === 'bn' ? 'active' : '' }}">বাংলা</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="footer_middle_area pt20 pb20">
      <div class="container text-center">
        <p class="mb0">© {{ now()->year }} FMB Group. {{ __('All rights reserved.') }}</p>
      </div>
    </section>

    <!-- Floating WhatsApp button (the most common way Bangladeshi clients reach a business) -->
    <a class="bd-whatsapp-float" href="{{ $whatsapp }}" target="_blank" rel="noopener" aria-label="{{ __('Chat on WhatsApp') }}">
      <i class="fa fa-whatsapp"></i>
    </a>

    <a class="scrollToHome" href="#"><i class="flaticon-arrows"></i></a>
  </div>
  <!-- Wrapper End -->
  <script type="text/javascript" src="{{ asset('assets/js/jquery-3.3.1.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery-migrate-3.0.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery.mmenu.all.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/ace-responsive-menu.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/isotop.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/snackbar.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/simplebar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/parallax.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/scrollto.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery-scrolltofixed-min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery.counterup.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/wow.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/progressbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/slider.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/timepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
