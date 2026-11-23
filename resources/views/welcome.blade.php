@extends('layout')

{{-- Title, description and sharing image come from Admin → Homepage & settings → SEO. --}}

@section('content')

@if ($banners->isNotEmpty())
{{-- Slider sits in a centred, responsive .container (equal space left and right). --}}
<div class="home10-mainslider bd-hero">
    <div class="container">
                <div class="main-banner-wrapper home10">
                    <div class="banner-style-one owl-theme owl-carousel">
                        @foreach ($banners as $banner)
                        <div class="slide slide-one" style="background-image: url('{{ media_url($banner->image) }}');background-position: {{ $banner->image_position }};">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">{{ $banner->tr('title') }}</h3>
                                        @if ($banner->tr('subtitle'))<p>{{ $banner->tr('subtitle') }}</p>@endif
                                        @if ($banner->button_text && $banner->button_link)
                                          <div class="btn"><a href="{{ str_starts_with($banner->button_link, '/') ? url($banner->button_link) : $banner->button_link }}" class="banner-btn">{{ $banner->tr('button_text') }}</a></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if ($banners->count() > 1)
                    <div class="carousel-btn-block banner-carousel-btn">
                        <span class="carousel-btn left-btn"><i class="flaticon-left-arrow-1 left"></i></span>
                        <span class="carousel-btn right-btn"><i class="flaticon-right-arrow right"></i></span>
                    </div>
                    @endif
                </div>
    </div>
</div>
@push('scripts')
<script>
  // Owl Carousel measures its width once at start-up. Re-measure when everything (fonts, images,
  // scrollbar) has loaded so the slides line up from the first paint, not only after a scroll/resize.
  jQuery(window).on('load', function () {
    jQuery('.banner-style-one').trigger('refresh.owl.carousel');
  });
</script>
@endpush
@endif

<!-- Who we are -->
<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2 class="mt0">{{ setting('home_about_title', __('Who we are'), true) }}</h2>
                    @if (setting('home_about_subtitle'))<p>{{ setting('home_about_subtitle', '', true) }}</p>@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xl-7">
                <div class="about_content">
                    @if (setting('home_about_lead'))<p class="large">{{ setting('home_about_lead', '', true) }}</p>@endif
                    @foreach (preg_split('/\R{2,}/', (string) setting('home_about_text', '', true)) as $paragraph)
                        @if (trim($paragraph) !== '')<p>{!! nl2br(e(trim($paragraph))) !!}</p>@endif
                    @endforeach
                    <p>{{ __('The group also builds homes in Dhaka through its real estate concern, FMB Developments Ltd.') }} <a href="{{ route('development') }}" class="text-thm">{{ __('Learn more') }} →</a></p>

                    <ul class="ab_counting">
                        <li class="list-inline-item">
                            <div class="about_counting">
                                <div class="icon"><span class="fa fa-th-large"></span></div>
                                <div class="details">
                                    <h3>4</h3>
                                    <p>{{ __('Product lines: Knit, Woven, Sweater, Home Textile') }}</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="about_counting">
                                <div class="icon"><span class="fa fa-check-square-o"></span></div>
                                <div class="details">
                                    <h3>{{ __('In-line') }}</h3>
                                    <p>{{ __('and final inspection on every order') }}</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="about_counting">
                                <div class="icon"><span class="fa fa-ship"></span></div>
                                <div class="details">
                                    <h3>{{ __('FOB') }}</h3>
                                    <p>{{ __('Chattogram / Dhaka shipments') }}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xl-5">
                <div class="about_thumb">
                    <img class="img-fluid w100" style="height:420px;object-fit:cover;object-position:30% center;border-radius:8px" src="{{ media_url(setting('home_about_image'), 'assets/images/banner/banner-qc.jpg') }}" alt="{{ __('Fabric quality check at a Bangladeshi garment factory') }}">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our businesses -->
<section class="bgc-f7 pb30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2>{{ __('Our Businesses') }}</h2>
                    <p>{{ __('Two businesses, one commitment to quality') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a class="bd-business" href="{{ route('garments.services') }}">
                    <div class="bd-business-img" style="background-image:url({{ asset('assets/images/banner/banner-factory.jpg') }})"></div>
                    <div class="p25">
                        <span class="bd-tag">{{ __('Garments') }}</span>
                        <h4>{{ __('FMB Group – Garments Buying House') }}</h4>
                        <p>{{ __('Sourcing knit, woven, sweater and home textile products from trusted Bangladeshi factories for buyers worldwide.') }}</p>
                        <span class="text-thm">{{ __('Learn more') }} →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="bd-business" href="{{ route('development') }}">
                    <div class="bd-business-img" style="background-image:url({{ asset('assets/images/background/5.jpg') }})"></div>
                    <div class="p25">
                        <span class="bd-tag">{{ __('Real Estate') }}</span>
                        <h4>FMB Developments Ltd</h4>
                        <p>{{ __('Premium building and property development in Dhaka.') }}</p>
                        <span class="text-thm">{{ __('Learn more') }} →</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured projects (Admin → Projects → ★) -->
@if ($featuredProjects->isNotEmpty())
<section class="pt50 pb30">
    <div class="container">
        <div class="main-title text-center">
            <h2>{{ __('Featured Projects') }}</h2>
            <p>{{ __('Apartments by FMB Developments Ltd') }}</p>
        </div>
        <div class="row justify-content-center">
            @foreach ($featuredProjects as $project)
                <div class="col-md-6 col-lg-4">@include('partials.project-card', ['project' => $project])</div>
            @endforeach
        </div>
        <div class="text-center"><a href="{{ route('projects.index') }}" class="btn btn-lg btn-outline-secondary">{{ __('All Projects') }}</a></div>
    </div>
</section>
@endif

<!-- Product lines -->
<section class="{{ $featuredProjects->isNotEmpty() ? 'bgc-f7' : '' }} pb30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2>{{ __('What We Source') }}</h2>
                    <p>{{ __('Made in Bangladesh, the world\'s second-largest apparel exporter') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ([
                ['fa-male', 'Knitwear', 'T-shirts, polo shirts, hoodies, sweatshirts, joggers and babywear for men, women and kids.', '/collection/men-knit'],
                ['fa-scissors', 'Woven', 'Shirts, blouses, trousers, denim, cargo pants and outerwear.', '/contact'],
                ['fa-snowflake-o', 'Sweaters', 'Pullovers, cardigans and knitted tops in cotton, acrylic and blends.', '/contact'],
                ['fa-bed', 'Home Textile', 'Towels, bed linen, kitchen textiles and cushion covers.', '/collection/home-tex'],
            ] as [$icon, $title, $text, $link])
            <div class="col-md-6 col-lg-3">
                <a href="{{ url($link) }}" class="d-block text-dark">
                    <div class="bd-feature text-center">
                        <i class="fa {{ $icon }}"></i>
                        <h4>{{ __($title) }}</h4>
                        <p>{{ __($text) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section id="why-chose" class="whychose_us {{ $featuredProjects->isNotEmpty() ? '' : 'bgc-f7' }} pb30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2>{{ __('Why Choose Us') }}</h2>
                    <p>{{ __('We provide full service at every step.') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ([
                ['flaticon-high-five', 'Trusted Factory Network', 'We work with vetted knit, woven and sweater factories across Dhaka, Gazipur, Narayanganj and Chattogram, matched to each order\'s product and capacity.'],
                ['flaticon-home-1', 'Compliance & Quality', 'Factories are selected to meet buyer compliance requirements, and our QC team runs in-line and final inspections before shipment.'],
                ['flaticon-profit', 'Competitive Pricing', 'Local sourcing of yarn, fabric and trims plus direct factory negotiation keeps your FOB price competitive without cutting corners.'],
            ] as [$icon, $title, $text])
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="why_chose_us home10">
                    <div class="icon"><span class="{{ $icon }}"></span></div>
                    <div class="details">
                        <h4>{{ __($title) }}</h4>
                        <p>{{ __($text) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.testimonials', ['testimonials' => $testimonials])
@include('partials.faqs', ['faqs' => $faqs, 'id' => 'home-faq'])

<!-- Call to action -->
<section class="pt50 pb50 {{ $faqs->isNotEmpty() ? 'bgc-f7' : '' }}">
    <div class="container text-center">
        <h2>{{ setting('home_cta_title', __('Planning your next order?'), true) }}</h2>
        @if (setting('home_cta_text'))<p class="mb30">{{ setting('home_cta_text', '', true) }}</p>@endif
        <a href="{{ route('contact') }}" class="btn btn-lg btn-thm">{{ __('Request a Quote') }}</a>
        @if (setting('whatsapp'))
          <a href="https://wa.me/{{ setting('whatsapp') }}" target="_blank" rel="noopener" class="btn btn-lg btn-success ml10"><i class="fa fa-whatsapp"></i> {{ __('WhatsApp Us') }}</a>
        @endif
    </div>
</section>

@endsection
