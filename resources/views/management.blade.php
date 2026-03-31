@extends('layout')

@section('title', 'Our Management')

@section('content')

<!-- Inner Page Breadcrumb -->

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Management</li>
          </ol>
          <h4 class="breadcrumb_title">Our Management</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Leadership Intro -->

<section class="bgc-f7 pt40 pb10">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 text-center">
        <h2>Leadership & Management</h2>
        <p>
          At FMB Group, our leadership team brings extensive experience in garments sourcing, 
          production management, quality control, and international trade. Their strategic 
          vision and industry knowledge help us maintain strong partnerships with buyers 
          and manufacturers worldwide while ensuring quality, reliability, and timely delivery.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Management Section -->

<section class="our-team bgc-f7 pb70">
  <div class="container">


<div class="row justify-content-center">

  <!-- Managing Director -->
  <div class="col-md-6 col-lg-5">
    <div class="team_member text-center">
      <div class="thumb">
        <img 
          class="img-fluid w-100" 
          src="/assets/images/management/firoz.jpg" 
          alt="MD Firoz Alam"
          onerror="this.onerror=null;this.src='/assets/images/management/default-user.jpg';"
        >
      </div>

      <div class="details p20">
        <h4>MD. FIROZ ALAM</h4>
        <p class="text-thm pb10"><strong>Managing Director</strong></p>

        <p>
          MD. Firoz Alam is the Managing Director of FMB Group and plays a key role in 
          shaping the company’s strategic direction. With deep experience in the garments 
          and textile industry, he oversees business development, buyer relationships, 
          and international sourcing operations.
        </p>

        <ul class="list-unstyled mt15">
          <li>✔ Strategic business leadership</li>
          <li>✔ International buyer relationship management</li>
          <li>✔ Production and sourcing oversight</li>
          <li>✔ Export market development</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Chairman -->
  <div class="col-md-6 col-lg-5">
    <div class="team_member text-center">
      <div class="thumb">
        <img 
          class="img-fluid w-100" 
          src="/assets/images/management/mamun.jpg" 
          alt="MD Al Mamun"
          onerror="this.onerror=null;this.src='/assets/images/management/default-user.jpg';"
        >
      </div>

      <div class="details p20">
        <h4>MD. AL MAMUN</h4>
        <p class="text-thm pb10"><strong>Chairman</strong></p>

        <p>
          As Chairman of FMB Group, MD. Al Mamun provides strategic leadership and 
          long-term vision for the organization. He focuses on sustainable growth, 
          strong governance, and building global partnerships within the apparel 
          manufacturing and sourcing industry.
        </p>

        <ul class="list-unstyled mt15">
          <li>✔ Corporate strategy and governance</li>
          <li>✔ Global partnership development</li>
          <li>✔ Sustainable business growth</li>
          <li>✔ Industry leadership</li>
        </ul>
      </div>
    </div>
  </div>

</div>


  </div>
</section>

@endsection
