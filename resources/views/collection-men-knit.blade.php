@extends('layout')

@section('title', 'Products')

@section('content')




<!-- About Text Content -->
<section class="about-section mb30">
  <div class="container">
    <h2>Products - KNIT - Mens</h2>
    <hr>
    <br>
    <div class="row">
      @for ($i = 1; $i <= 15; $i++)
        <div class="col-sm-6 col-md-2 col-lg-2 mb-4 caret-red-100">
        <div class="gallery_item">
          <img
            class="img-fluid img-circle-rounded hover:scale-105 transition-transform duration-300"
            src="{{ asset('assets/images/knit-men/' . $i . '.jpg') }}" alt="knit-men-{{ $i }}">
        </div>
    </div>
    @endfor
  </div>
  </div>

</section>

@endsection