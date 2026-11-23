@php
  $locale = app()->getLocale();
  $siteName = setting('site_name', 'FMB Group');
  $phone = setting('phone');
  $phoneDisplay = setting('phone_display', $phone);
  $email = setting('email');
  $waNumber = setting('whatsapp');
  $whatsapp = $waNumber ? 'https://wa.me/'.$waNumber.'?text='.rawurlencode(__('Hello FMB Group, I would like to know more about your products.')) : null;
  $messenger = setting('messenger_url');
  $socials = array_filter([
    'facebook' => setting('facebook_url'), 'linkedin' => setting('linkedin_url'),
    'youtube-play' => setting('youtube_url'), 'instagram' => setting('instagram_url'),
  ]);
  $headerMenu = \App\Models\MenuItem::tree('header');
  $footerMenu = \App\Models\MenuItem::tree('footer');

  // Inline @section values arrive HTML-escaped; decode once so {{ }} below escapes exactly once.
  $section = fn ($name) => html_entity_decode(trim($__env->yieldContent($name)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $pageTitle = $section('title') ?: setting('seo_title', __('Home'), true);
  $metaDescription = $section('description') ?: setting('seo_description', '', true);
  $metaKeywords = $section('keywords') ?: setting('seo_keywords', '');
  $ogImage = $section('og_image') ?: media_url(setting('og_image'), 'assets/images/banner/banner-factory.jpg');
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="{{ $locale }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ $metaDescription }}">
  @if ($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
  <meta name="geo.region" content="BD-13">
  <meta name="geo.placename" content="Dhaka">
  <link rel="canonical" href="{{ url()->current() }}">
  <!-- Open Graph (Facebook / WhatsApp / LinkedIn link previews) -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ $siteName }}">
  <meta property="og:title" content="{{ $pageTitle }} | {{ $siteName }}">
  <meta property="og:description" content="{{ $metaDescription }}">
  <meta property="og:image" content="{{ $ogImage }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:locale" content="{{ $locale === 'bn' ? 'bn_BD' : 'en_US' }}">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Fonts: Hind Siliguri renders Bangla text cleanly -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bd.css') }}">

  <title>{{ $pageTitle }} | {{ $siteName }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/fmb-favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/fmb-favicon.png') }}">

  <script type="application/ld+json">
  {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $siteName,
    'description' => 'Garments buying house and real estate developer (FMB Developments Ltd) in Dhaka, Bangladesh',
    'url' => url('/'),
    'email' => $email,
    'telephone' => $phone,
    'logo' => asset('assets/images/fmb-logo.png'),
    'sameAs' => array_values($socials),
    'address' => ['@type' => 'PostalAddress', 'streetAddress' => setting('address_line1'), 'addressLocality' => 'Dhaka', 'addressCountry' => 'BD'],
  ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
  </script>
  @stack('head')
</head>

<body class="lang-{{ $locale }}">
  <div class="wrapper">
    <div class="preloader"></div>

    <!-- Top bar -->
    <div class="bd-topbar dn-smd">
      <div class="container d-flex justify-content-between align-items-center">
        <div>
          @if ($phone)<a href="tel:{{ $phone }}"><i class="fa fa-phone"></i> {{ $phoneDisplay }}</a>@endif
          @if ($email)<a href="mailto:{{ $email }}"><i class="fa fa-envelope"></i> {{ $email }}</a>@endif
          @if (setting('office_hours'))<span><i class="fa fa-clock-o"></i> {{ setting('office_hours', null, true) }}</span>@endif
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
            <img class="bd-logo" src="{{ asset('assets/images/fmb-logo.png') }}" alt="{{ $siteName }}">
          </a>
          <ul id="respMenu" class="ace-responsive-menu text-right" data-menu-style="horizontal">
            @include('partials.menu', ['items' => $headerMenu, 'level' => 0])
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
            <a class="nav_logo_img" href="{{ url('/') }}"><img class="bd-logo" src="{{ asset('assets/images/fmb-logo.png') }}" alt="{{ $siteName }}"></a>
            @if ($phone)<a class="mobile-menu-reg-link" href="tel:{{ $phone }}" aria-label="{{ __('Call us') }}"><span class="fa fa-phone"></span></a>@endif
          </div>
        </div>
      </div>
      <nav id="menu" class="stylehome1">
        <ul>
          @include('partials.menu', ['items' => $headerMenu, 'level' => 0])
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
              <img class="bd-footer-logo" src="{{ asset('assets/images/fmb-logo.png') }}" alt="{{ $siteName }}">
              <p>{{ setting('footer_about', '', true) }}</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_qlink_widget home6">
              <h4>{{ __('Quick Links') }}</h4>
              <ul class="list-unstyled">
                @foreach ($footerMenu as $item)
                  <li><a href="{{ $item->href() }}" @if ($item->open_in_new_tab) target="_blank" rel="noopener" @endif>{{ $item->tr('label') }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_contact_widget home6">
              <h4>{{ __('Contact Us') }}</h4>
              <ul class="list-unstyled">
                @if ($email)<li><a href="mailto:{{ $email }}">{{ $email }}</a></li>@endif
                @if ($phone)<li><a href="tel:{{ $phone }}">{{ $phoneDisplay }}</a></li>@endif
                @if ($whatsapp)<li><a href="{{ $whatsapp }}" target="_blank" rel="noopener">WhatsApp: {{ $phoneDisplay }}</a></li>@endif
                @if (setting('real_estate_phone'))<li><a href="tel:{{ setting('real_estate_phone') }}">{{ __('Real estate') }}: {{ setting('real_estate_phone_display', setting('real_estate_phone')) }}</a></li>@endif
                @if (setting('real_estate_email'))<li><a href="mailto:{{ setting('real_estate_email') }}">{{ setting('real_estate_email') }}</a></li>@endif
                <li>{{ setting('address_line1', '', true) }}</li>
                @if (setting('address_line2'))<li>{{ setting('address_line2', '', true) }}</li>@endif
                @if (setting('office_hours'))<li>{{ setting('office_hours', '', true) }}</li>@endif
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_social_widget home6">
              @if ($socials || $whatsapp)
                <h4>{{ __('Follow us') }}</h4>
                <ul class="mb30">
                  @foreach ($socials as $icon => $url)
                    <li class="list-inline-item"><a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst(explode('-', $icon)[0]) }}"><i class="fa fa-{{ $icon }}"></i></a></li>
                  @endforeach
                  @if ($whatsapp)<li class="list-inline-item"><a href="{{ $whatsapp }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa fa-whatsapp"></i></a></li>@endif
                </ul>
              @endif
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
        <p class="mb0">© {{ now()->year }} {{ $siteName }}. {{ __('All rights reserved.') }}</p>
      </div>
    </section>

    <!-- Floating contact buttons: Bangladeshi visitors mostly reach businesses via WhatsApp, Messenger or a call -->
    <div class="bd-float">
      @if ($phone)<a class="bd-float-btn bd-float-call" href="tel:{{ $phone }}" aria-label="{{ __('Call us') }}" title="{{ __('Call us') }}"><i class="fa fa-phone"></i></a>@endif
      @if ($messenger)<a class="bd-float-btn bd-float-messenger" href="{{ $messenger }}" target="_blank" rel="noopener" aria-label="Messenger" title="Messenger"><i class="fa fa-comment"></i></a>@endif
      @if ($whatsapp)<a class="bd-whatsapp-float" href="{{ $whatsapp }}" target="_blank" rel="noopener" aria-label="{{ __('Chat on WhatsApp') }}" title="WhatsApp"><i class="fa fa-whatsapp"></i></a>@endif
    </div>

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
  @stack('scripts')
</body>

</html>
