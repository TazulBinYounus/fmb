<!DOCTYPE html>
<html dir="ltr" lang="en">


<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="advanced custom search, agency, agent, business, clean, corporate, directory, google maps, homes, idx agent, listing properties, membership packages, property, real broker, real estate, real estate agent, real estate agency, realtor">
  <meta name="description" content="FindHouse - Real Estate HTML Template">
  <meta name="CreativeLayers" content="ATFN">
  <!-- css file -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- Responsive stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <!-- Title -->
  <title>@yield('title', 'FMBGROUP Home')</title>
  <!-- Favicon -->
  <link href="{{ asset('assets/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
  <link href="{{ asset('assets/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" />
</head>

<body>
  <div class="wrapper">
    <div class="preloader"></div>

    <!-- Main Header Nav -->
    <header class="header-nav menu_style_home_one style2 home10 navbar-scrolltofixed stricky main-menu">
      <div class="container p0">
        <!-- Ace Responsive Menu -->
        <nav>
          <!-- Menu Toggle btn-->
          <div class="menu-toggle">

            <!-- <img class="nav_logo_img img-fluid" src="{{asset('assets')}}/images/header-logo.png" alt="header-logo.png"> -->
            <button type="button" id="menu-btn">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <a href="/" class="navbar_brand float-left dn-smd">
            <!-- <img class="logo1 img-fluid" src="{{asset('assets')}}/images/header-logo.png" alt="header-logo.png">
                        <img class="logo2 img-fluid" src="{{asset('assets')}}/images/header-logo.png" alt="header-logo.png"> -->

            <h2>FMBGROUP</h2>
          </a>
          <!-- Responsive Menu Structure-->
          <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
          <ul id="respMenu" class="ace-responsive-menu text-right" data-menu-style="horizontal">

            <li class="last">
              <a href="/"><span class="title">Home</span></a>
            </li>

            <li>
              <a href="#"><span class="title">Our Collection</span></a>
              <ul>
                <li>
                  <a href="#"><span class="title">KNIT</span></a>
                  <ul>
                    <li><a href="/collection/men-knit">MEN</a></li>
                    <li><a href="/collection/women-knit">WOMEN</a></li>
                    <li><a href="/collection/kid-knit">KID</a></li>
                  </ul>
                </li>

                <li>
                  <a href="#"><span class="title">WOVEN</span></a>
                  <ul>
                    <li><a href="#">MEN</a></li>
                    <li><a href="#">WOMEN</a></li>
                    <li><a href="#">KID</a></li>
                  </ul>
                </li>

                <li>
                  <a href="#"><span class="title">SWEATER</span></a>
                  <ul>
                    <li><a href="#">MEN</a></li>
                    <li><a href="#">WOMEN</a></li>
                    <li><a href="#">KID</a></li>
                  </ul>
                </li>

                <li>
                  <a href="/collection/home-tex">Home TEX</a>
                </li>

              </ul>
            </li>

            <li class="last">
              <a href="/development"><span class="title">Development</span></a>
            </li>





            <li class="last">
              <a href="/our-management"><span class="title">Our Management</span></a>
            </li>
            <li class="last">
              <a href="/contact"><span class="title">Contact</span></a>
            </li>


            <!-- <li class="list-inline-item add_listing home2 style10 float-right"><a href="#"><span class="flaticon-plus"></span><span class="dn-lg"> Create Listing</span></a></li>
                        <li class="list-inline-item list_s float-right">
                            <a href="#" class="btn flaticon-user" data-toggle="modal" data-target=".bd-example-modal-lg"> <span class="dn-lg">Login/Register</span></a>
                        </li> -->
          </ul>
        </nav>
      </div>
    </header>


    <!-- Main Header Nav For Mobile -->
    <div id="page" class="stylehome1 h0">
      <div class="mobile-menu">
        <div class="header stylehome1">
          <div class="d-flex justify-content-between">
            <a class="mobile-menu-trigger" href="#menu"><img src="{{asset('assets')}}/images/dark-nav-icon.svg" alt=""></a>
            <a class="nav_logo_img" href="/">
              <!-- <img class="img-fluid mt20" src="{{asset('assets')}}/images/header-logo2.png" alt="header-logo2.png"> -->
              <h2 class=" mt20">FMBGROUP</h2>
            </a>
            <a class="mobile-menu-reg-link" href="page-register.html"><span class="flaticon-user"></span></a>
          </div>
        </div>
      </div><!-- /.mobile-menu -->
      <nav id="menu" class="stylehome1">
        <ul>
          <li class="last">
            <a href="/"><span class="title">Home</span></a>
          </li>

          <!-- <li>
            <a href="#"><span>Our Collection</span></a>
            <ul>
              <li><a href="#">KNIT</a></li>
              <li><a href="#">WOVEN</a></li>
              <li><a href="#">SWEATER</a></li>
              <li><a href="#">Home TEX</a></li>
            </ul>
          </li> -->


          <li>
            <a href="#"><span class="title">Our Collection</span></a>
            <ul>
              <li>
                <a href="#"><span class="title">KNIT</span></a>
                <ul>
                  <li><a href="/collection/men-knit">MEN</a></li>
                  <li><a href="/collection/women-knit">WOMEN</a></li>
                  <li><a href="/collection/kid-knit">KID</a></li>
                </ul>
              </li>

              <li>
                <a href="#"><span class="title">WOVEN</span></a>
                <ul>
                  <li><a href="#">MEN</a></li>
                  <li><a href="#">WOMEN</a></li>
                  <li><a href="#">KID</a></li>
                </ul>
              </li>

              <li>
                <a href="#"><span class="title">SWEATER</span></a>
                <ul>
                  <li><a href="#">MEN</a></li>
                  <li><a href="#">WOMEN</a></li>
                  <li><a href="#">KID</a></li>
                </ul>
              </li>

              <li>
                <a href="/collection/home-tex">Home TEX</a>
              </li>

            </ul>
          </li>


          <li class="last">
            <a href="/development"><span class="title">Development</span></a>
          </li>





          <li class="/contact">
            <a href="page-contact.html"><span class="title">Contact</span></a>
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
              <h4>About </h4>
              <p>FMB Group, based in Dhaka, Bangladesh, is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items. </p>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_qlink_widget home6">
              <h4>Quick Links</h4>
              <ul class="list-unstyled">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Terms &amp; Conditions</a></li>
                <li><a href="#">User’s Guide</a></li>
                <li><a href="#">Support Center</a></li>
                <li><a href="#">Press Info</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_contact_widget home6">
              <h4>Contact Us</h4>
              <ul class="list-unstyled">
                <li><a href="#">info@fmbgroupbd.com</a></li>
                <li><a href="#">174, East Dholipar, Jatrabari</a></li>
                <li><a href="#">Dhaka 1204, Bangladesh</a></li>
                <li><a href="#">+88016 12149719</a></li>
                <li><a href="#">+88016 12149719</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="footer_social_widget home6">
              <h4>Follow us</h4>
              <ul class="mb30">
                <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-google"></i></a></li>
              </ul>
              <h4>Subscribe</h4>
              <form class="footer_mailchimp_form home6">
                <div class="form-row align-items-center">
                  <div class="col-auto">
                    <input type="email" class="form-control mb-2" id="inlineFormInput" placeholder="Your email">
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-angle-right"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>




    <a class="scrollToHome" href="#"><i class="flaticon-arrows"></i></a>
  </div>
  <!-- Wrapper End -->
  <script type="text/javascript" src="{{asset('assets')}}/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/jquery-migrate-3.0.0.min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/popper.min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/jquery.mmenu.all.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/ace-responsive-menu.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/isotop.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/snackbar.min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/simplebar.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/parallax.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/scrollto.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/jquery-scrolltofixed-min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/jquery.counterup.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/wow.min.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/progressbar.js"></script>
  <script type="text/javascript" src="{{asset('assets')}}/js/slider.js"></script>
  <!-- <script type="text/javascript" src="{{asset('assets')}}/js/pricing-slider.js"></script> -->
  <script type="text/javascript" src="{{asset('assets')}}/js/timepicker.js"></script>
  <!-- Custom script for all pages -->
  <script type="text/javascript" src="{{asset('assets')}}/js/script.js"></script>
</body>


</html>