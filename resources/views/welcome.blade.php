@extends('layout')

@section('title', __('Garments Sourcing & Real Estate in Dhaka, Bangladesh'))

@section('content')

@php
  $slides = [
    ['img' => 'home/15.webp', 'title' => 'FMB GROUP', 'text' => __('Knit, Woven & Sweater Sourcing from Bangladesh'), 'btn' => __('Request a Quote'), 'link' => '/contact'],
    ['img' => 'background/5.jpg', 'title' => 'FMB DEVELOPMENTS', 'text' => __('Premium Apartments in Dhaka'), 'btn' => __('View Projects'), 'link' => '/development'],
    ['img' => 'home/14.webp', 'title' => 'FMB GROUP', 'text' => __('Quality Checked at Every Stage'), 'btn' => __('Request a Quote'), 'link' => '/contact'],
  ];
@endphp

<div class="home10-mainslider">
    <div class="container-fluid p0">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-banner-wrapper home10">
                    <div class="banner-style-one owl-theme owl-carousel">
                        @foreach ($slides as $slide)
                        <div class="slide slide-one" style="background-image: url({{ asset('assets/images/' . $slide['img']) }});height: 620px;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">{{ $slide['title'] }}</h3>
                                        <p>{{ $slide['text'] }}</p>
                                        <div class="btn"><a href="{{ url($slide['link']) }}" class="banner-btn">{{ $slide['btn'] }}</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="carousel-btn-block banner-carousel-btn">
                        <span class="carousel-btn left-btn"><i class="flaticon-left-arrow-1 left"></i></span>
                        <span class="carousel-btn right-btn"><i class="flaticon-right-arrow right"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Who we are -->
<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2 class="mt0">{{ __('Who we are') }}</h2>
                    <p>{{ __('Delivering top-quality products at competitive prices') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xl-7">
                <div class="about_content">
                    <p class="large">{{ __('FMB Group, located in Dhaka, Bangladesh') }}</p>
                    <p>{{ __('FMB Group, based in Dhaka, Bangladesh, is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items. We collaborate with trusted factories to ensure that every product meets our standards of quality and style. From initial production planning to regular communication and updates with our clients, we handle all stages of the process, including in-line inspections, shipping schedule management, and final dispatch of documents.') }}</p>
                    <p>{{ __('With a dedicated team of experienced professionals, FMB Group is committed to delivering top-quality products at competitive prices. We believe that building long-term success requires trust, reliability, and consistently meeting client expectations.') }}</p>
                    <p>{{ __('The group also builds homes in Dhaka through its real estate concern, FMB Developments Ltd.') }} <a href="{{ url('/development') }}" class="text-thm">{{ __('Learn more') }} →</a></p>

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
                    <img class="img-fluid w100" style="height:420px;object-fit:cover;border-radius:8px" src="{{ asset('assets/images/home/15.webp') }}" alt="{{ __('Knit garments sourced by FMB Group') }}">
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
                <a class="bd-business" href="{{ url('/garments/services') }}">
                    <div class="bd-business-img" style="background-image:url({{ asset('assets/images/home/15.webp') }})"></div>
                    <div class="p25">
                        <span class="bd-tag">{{ __('Garments') }}</span>
                        <h4>{{ __('FMB Group – Garments Buying House') }}</h4>
                        <p>{{ __('Sourcing knit, woven, sweater and home textile products from trusted Bangladeshi factories for buyers worldwide.') }}</p>
                        <span class="text-thm">{{ __('Learn more') }} →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="bd-business" href="{{ url('/development') }}">
                    <div class="bd-business-img" style="background-image:url({{ asset('assets/images/background/5.jpg') }})"></div>
                    <div class="p25">
                        <span class="bd-tag">{{ __('Real Estate') }}</span>
                        <h4>FMB Developments Ltd</h4>
                        <p>{{ __('Premium building and property development in Dhaka, including our upcoming project in Bashundhara Riverview.') }}</p>
                        <span class="text-thm">{{ __('Learn more') }} →</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Product lines -->
<section class="pb30">
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
<section id="why-chose" class="whychose_us bgc-f7 pb30">
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

<!-- Call to action -->
<section class="pt50 pb50">
    <div class="container text-center">
        <h2>{{ __('Planning your next order?') }}</h2>
        <p class="mb30">{{ __('Send us your tech pack or sample and we will get back to you with a quotation.') }}</p>
        <a href="{{ url('/contact') }}" class="btn btn-lg btn-thm">{{ __('Request a Quote') }}</a>
        <a href="https://wa.me/8801612149719" target="_blank" rel="noopener" class="btn btn-lg btn-success ml10"><i class="fa fa-whatsapp"></i> {{ __('WhatsApp Us') }}</a>
    </div>
</section>

@endsection
