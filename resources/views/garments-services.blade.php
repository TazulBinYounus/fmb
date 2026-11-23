@extends('layout')

@section('title', __('Garments Sourcing Services'))

@section('content')

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item">{{ __('Garments') }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Services') }}</li>
          </ol>
          <h4 class="breadcrumb_title">{{ __('Product Development & Services') }}</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="bgc-f7 pb30">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center mb40">
        <h2>{{ __('From tech pack to shipment') }}</h2>
        <p>{{ __('As your sourcing office in Bangladesh, we manage the full order cycle so you deal with one accountable partner instead of many factories.') }}</p>
      </div>
    </div>
    <div class="row">
      @foreach ([
        ['fa-pencil-square-o', 'Product Development & Sampling', 'Proto, fit, size-set and PP samples developed from your tech pack, with fabric, colour (lab dip) and trims approvals tracked for you.'],
        ['fa-industry', 'Factory Sourcing', 'We match each style to a suitable factory by product type, capacity, minimum order quantity and compliance status.'],
        ['fa-calculator', 'Costing & Negotiation', 'Transparent FOB costing for fabric, CM, trims, washing and printing, negotiated directly with the factory.'],
        ['fa-tasks', 'Production Follow-up', 'Time & Action (T&A) calendar, weekly status updates and early warning on any delay.'],
        ['fa-search', 'Quality Control', 'Fabric inspection, in-line inspection and final random inspection (AQL) by our own QC team before shipment.'],
        ['fa-shield', 'Compliance Support', 'We work with factories that hold the social and safety audits your brand requires and follow BGMEA / BKMEA guidelines.'],
        ['fa-ship', 'Shipping & Documents', 'Booking with forwarders, shipment by sea from Chattogram or by air from Dhaka, and on-time dispatch of export documents.'],
        ['fa-comments', 'Clear Communication', 'English-speaking merchandisers available on email, WhatsApp and phone, working Saturday to Thursday (Bangladesh time, GMT+6).'],
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

<section class="pt50 pb50">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="mb30">{{ __('How an order works') }}</h2>
        <ol class="bd-steps">
          <li><strong>{{ __('Enquiry') }}</strong> — {{ __('Send your tech pack, sample or reference photo with target quantity and price.') }}</li>
          <li><strong>{{ __('Costing & sampling') }}</strong> — {{ __('We quote, develop samples and get your approvals.') }}</li>
          <li><strong>{{ __('Order confirmation') }}</strong> — {{ __('Purchase order, L/C or TT terms and the T&A calendar are agreed.') }}</li>
          <li><strong>{{ __('Production & QC') }}</strong> — {{ __('Bulk production with in-line and final inspections.') }}</li>
          <li><strong>{{ __('Shipment') }}</strong> — {{ __('Goods are shipped and documents are sent to you or your bank.') }}</li>
        </ol>
      </div>
      <div class="col-lg-6">
        <h2 class="mb30">{{ __('Trade terms') }}</h2>
        <ul class="list-unstyled">
          <li class="mb10"><i class="fa fa-check text-thm mr10"></i>{{ __('Price terms: FOB Chattogram, CFR or CIF on request') }}</li>
          <li class="mb10"><i class="fa fa-check text-thm mr10"></i>{{ __('Payment: Letter of Credit (L/C) at sight or TT') }}</li>
          <li class="mb10"><i class="fa fa-check text-thm mr10"></i>{{ __('Quotations in USD or EUR') }}</li>
          <li class="mb10"><i class="fa fa-check text-thm mr10"></i>{{ __('Minimum order quantity depends on product and fabric; ask us for details') }}</li>
          <li class="mb10"><i class="fa fa-check text-thm mr10"></i>{{ __('Duty-free access to the EU (EBA), UK, Canada, Japan and Australia for eligible products') }}</li>
        </ul>
        <a href="{{ url('/contact') }}" class="btn btn-lg btn-thm mt20">{{ __('Request a Quote') }}</a>
      </div>
    </div>
  </div>
</section>

@include('partials.faqs', ['faqs' => $faqs, 'id' => 'garments-faq', 'class' => 'bgc-f7 pt50 pb50'])

@endsection
