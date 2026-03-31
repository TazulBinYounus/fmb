@extends('layout')

@section('title', 'Home Page')

@section('content')



<div class="home10-mainslider">
    <div class="container-fluid p0">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-banner-wrapper home10">
                    <div class="banner-style-one owl-theme owl-carousel">
                        <div class="slide slide-one" style="background-image: url({{asset('assets')}}/images/home/15.webp);height: 620px;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">FMB GROUP</h3>
                                        <p>Premium Collection</p>
                                        <div class="btn"><a href="#" class="banner-btn">Learn More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide slide-one" style="background-image: url({{asset('assets')}}/images/home/14.webp);height: 620px;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">FMB GROUP</h3>
                                        <p>Most Trending Brands</p>
                                        <div class="btn"><a href="#" class="banner-btn">Learn More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide slide-one" style="background-image: url({{asset('assets')}}/images/home/11.webp);height: 620px;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">FMB GROUP</h3>
                                        <p>New Arrivals</p>
                                        <div class="btn"><a href="#" class="banner-btn">Learn More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-btn-block banner-carousel-btn">
                        <span class="carousel-btn left-btn"><i class="flaticon-left-arrow-1 left"></i></span>
                        <span class="carousel-btn right-btn"><i class="flaticon-right-arrow right"></i></span>
                    </div><!-- /.carousel-btn-block banner-carousel-btn -->
                </div><!-- /.main-banner-wrapper -->
            </div>
        </div>
    </div>
</div>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2 class="mt0">Who we are</h2>
                    <p>Delivering top-quality products at competitive prices</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xl-7">
                <div class="about_content">
                    <p class="large">FMB Group, located in Dhaka, Bangladesh</p>

                    <p>FMB Group, based in Dhaka, Bangladesh, is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items. We collaborate with trusted factories to ensure that every product meets our standards of quality and style. From initial production planning to regular communication and updates with our clients, we handle all stages of the process, including in-line inspections, shipping schedule management, and final dispatch of documents.
                    </p>
                    <p> With a dedicated team of experienced professionals, FMB Group is committed to delivering top-quality products at competitive prices. We believe that building long-term success requires trust, reliability, and consistently meeting client expectations.</p>

                    <ul class="ab_counting">
                        <li class="list-inline-item">
                            <div class="about_counting">
                                <div class="icon"><span class="flaticon-user"></span></div>
                                <div class="details">
                                    <h3>80,123</h3>
                                    <p>Customers to date</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="about_counting">
                                <div class="icon"><span class="flaticon-home"></span></div>
                                <div class="details">
                                    <h3>$74 Billion</h3>
                                    <p>In home sales</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="about_counting">
                                <div class="icon"><span class="flaticon-transfer"></span></div>
                                <div class="details">
                                    <h3>$468 Million</h3>
                                    <p>In Savings</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xl-5">
                <div class="about_thumb">
                    <img class="img-fluid w100" src="{{asset('assets')}}/images/about/1.jpg" alt="1.jpg">
                    <a class="popup-iframe popup-youtube color-white" href="https://www.youtube.com/watch?v=R7xbhKIiw4Y"><i class="flaticon-play"></i></a>
                </div>
            </div>
        </div>


    </div>
</section>


<!-- Feature Properties -->
<section id="feature-property" class="feature-property bgc-f7">
    <div class="container dn db-992">
        <div class="row featured_row">
            <div class="col-lg-12">
                <div class="home1-advnc-search home2 mt20">
                    <ul class="h1ads_1st_list mb0">
                        <li class="list-inline-item">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Enter keyword...">
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="search_option_two home2">
                                <div class="candidate_revew_select">
                                    <select class="selectpicker w100 show-tick">
                                        <option>Property Type</option>
                                        <option>Apartment</option>
                                        <option>Bungalow</option>
                                        <option>Condo</option>
                                        <option>House</option>
                                        <option>Land</option>
                                        <option>Single Family</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputEmail" placeholder="Location">
                                <label for="exampleInputEmail"><span class="flaticon-maps-and-flags"></span></label>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="small_dropdown2 home10">
                                <div id="prncgs2" class="btn dd_btn">
                                    <span>Price</span>
                                    <label for="exampleInputEmail4"><span class="fa fa-angle-down"></span></label>
                                </div>
                                <div class="dd_content2">
                                    <div class="pricing_acontent">
                                        <span id="slider-range-value1"></span>
                                        <span id="slider-range-value2"></span>
                                        <div id="slider"></div>
                                        <!-- <input type="text" class="amount" placeholder="$52,239"> 
											<input type="text" class="amount2" placeholder="$985,14">
											<div class="slider-range"></div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="custome_fields_520 list-inline-item">
                            <div class="navbered">
                                <div class="mega-dropdown">
                                    <span id="show_advbtn" class="dropbtn">Advanced <i class="flaticon-more pl10 flr-520"></i></span>
                                    <div class="dropdown-content home2">
                                        <div class="row p15 pb0">
                                            <div class="col-lg-12">
                                                <h4 class="text-thm3">Amenities</h4>
                                            </div>
                                            <div class="col-xxs-6 col-sm col-lg col-xl">
                                                <ul class="ui_kit_checkbox selectable-list">
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                            <label class="custom-control-label" for="customCheck1">Air Conditioning</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                            <label class="custom-control-label" for="customCheck2">Lawn</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                            <label class="custom-control-label" for="customCheck3">Swimming Pool</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xxs-6 col-sm col-lg col-xl">
                                                <ul class="ui_kit_checkbox selectable-list">
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                            <label class="custom-control-label" for="customCheck4">Barbeque</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                            <label class="custom-control-label" for="customCheck5">Microwave</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                            <label class="custom-control-label" for="customCheck6">TV Cable</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xxs-6 col-sm col-lg col-xl">
                                                <ul class="ui_kit_checkbox selectable-list">
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck7">
                                                            <label class="custom-control-label" for="customCheck7">Dryer</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck8">
                                                            <label class="custom-control-label" for="customCheck8">Outdoor Shower</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck9">
                                                            <label class="custom-control-label" for="customCheck9">Washer</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xxs-6 col-sm col-lg col-xl">
                                                <ul class="ui_kit_checkbox selectable-list">
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck10">
                                                            <label class="custom-control-label" for="customCheck10">Gym</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck11">
                                                            <label class="custom-control-label" for="customCheck11">Refrigerator</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck12">
                                                            <label class="custom-control-label" for="customCheck12">WiFi</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xxs-6 col-sm col-lg col-xl">
                                                <ul class="ui_kit_checkbox selectable-list">
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck13">
                                                            <label class="custom-control-label" for="customCheck13">Laundry</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck14">
                                                            <label class="custom-control-label" for="customCheck14">Sauna</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck15">
                                                            <label class="custom-control-label" for="customCheck15">Window Coverings</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row p15 pt0">
                                            <div class="col-lg-11 col-xl-10 pl0 pr0">
                                                <ul class="apeartment_area_list mb0">
                                                    <li class="list-inline-item">
                                                        <div class="candidate_revew_select">
                                                            <select class="selectpicker w100 show-tick">
                                                                <option>Bathrooms</option>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                                <option>6</option>
                                                                <option>7</option>
                                                                <option>8</option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <div class="candidate_revew_select">
                                                            <select class="selectpicker w100 show-tick">
                                                                <option>Bedrooms</option>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                                <option>6</option>
                                                                <option>7</option>
                                                                <option>8</option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <div class="candidate_revew_select">
                                                            <select class="selectpicker w100 show-tick">
                                                                <option>Year built</option>
                                                                <option>2013</option>
                                                                <option>2014</option>
                                                                <option>2015</option>
                                                                <option>2016</option>
                                                                <option>2017</option>
                                                                <option>2018</option>
                                                                <option>2019</option>
                                                                <option>2020</option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <div class="candidate_revew_select">
                                                            <select class="selectpicker w100 show-tick">
                                                                <option>Built-up Area</option>
                                                                <option>Adana</option>
                                                                <option>Ankara</option>
                                                                <option>Antalya</option>
                                                                <option>Bursa</option>
                                                                <option>Bodrum</option>
                                                                <option>Gaziantep</option>
                                                                <option>İstanbul</option>
                                                                <option>İzmir</option>
                                                                <option>Konya</option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-1 col-xl-2">
                                                <div class="mega_dropdown_content_closer">
                                                    <h5 class="text-thm text-right mt15"><span id="hide_advbtn" class="curp">Hide</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="search_option_button">
                                <button type="submit" class="btn btn-thm">Search</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container ovh">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center mb40">
                    <h2>Featured Properties</h2>
                    <p>Handpicked properties by our team.</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="feature_property_slider">
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp1.jpg" alt="fp1.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                        <li class="list-inline-item"><a href="#">Featured</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp2.jpg" alt="fp2.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp3.jpg" alt="fp3.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Sale</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp1.jpg" alt="fp1.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                        <li class="list-inline-item"><a href="#">Featured</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp2.jpg" alt="fp2.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp3.jpg" alt="fp3.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Sale</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp1.jpg" alt="fp1.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                        <li class="list-inline-item"><a href="#">Featured</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp2.jpg" alt="fp2.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp3.jpg" alt="fp3.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Sale</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp1.jpg" alt="fp1.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                        <li class="list-inline-item"><a href="#">Featured</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp2.jpg" alt="fp2.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Rent</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <!-- <a class="fp_price" href="#">$13,000<small>/mo</small></a> -->
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="feat_property">
                            <div class="thumb">
                                <img class="img-whp" src="{{asset('assets')}}/images/property/fp3.jpg" alt="fp3.jpg">
                                <div class="thmb_cntnt">
                                    <ul class="tag mb0">
                                        <li class="list-inline-item"><a href="#">For Sale</a></li>
                                    </ul>
                                    <ul class="icon mb0">
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-transfer-1"></span></a></li>
                                        <li class="list-inline-item"><a href="#"><span class="flaticon-heart"></span></a></li>
                                    </ul>
                                    <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                </div>
                            </div>
                            <div class="details">
                                <div class="tc_content">
                                    <p class="text-thm">Apartment</p>
                                    <h4>Renovated Apartment</h4>
                                    <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los Angeles, CA 90015</p>
                                    <ul class="prop_details mb0">
                                        <li class="list-inline-item"><a href="#">Beds: 4</a></li>
                                        <li class="list-inline-item"><a href="#">Baths: 2</a></li>
                                        <li class="list-inline-item"><a href="#">Sq Ft: 5280</a></li>
                                    </ul>
                                </div>
                                <div class="fp_footer">
                                    <ul class="fp_meta float-left mb0">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets')}}/images/property/pposter1.png" alt="pposter1.png"></a></li>
                                        <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                    </ul>
                                    <div class="fp_pdate float-right">4 years ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Why Chose Us -->
<section id="why-chose" class="whychose_us bgc-f7 pb30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2>Why Choose Us</h2>
                    <p>We provide full service at every step.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="why_chose_us home10">
                    <div class="icon">
                        <span class="flaticon-high-five"></span>
                    </div>
                    <div class="details">
                        <h4>Trusted By Thousands</h4>
                        <p>Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="why_chose_us home10">
                    <div class="icon">
                        <span class="flaticon-home-1"></span>
                    </div>
                    <div class="details">
                        <h4>Wide Renge Of Properties</h4>
                        <p>Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4">
                <div class="why_chose_us home10">
                    <div class="icon">
                        <span class="flaticon-profit"></span>
                    </div>
                    <div class="details">
                        <h4>Financing Made Easy</h4>
                        <p>Aliquam dictum elit vitae mauris facilisis at dictum urna dignissim donec vel lectus vel felis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Our Partners -->
<section id="our-partners" class="our-partners">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h2>Our Partners</h2>
                    <p>We only work with the best companies around the globe</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg">
                <div class="our_partner">
                    <img class="img-fluid" src="{{asset('assets')}}/images/partners/1.png" alt="1.png">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg">
                <div class="our_partner">
                    <img class="img-fluid" src="{{asset('assets')}}/images/partners/2.png" alt="2.png">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg">
                <div class="our_partner">
                    <img class="img-fluid" src="{{asset('assets')}}/images/partners/3.png" alt="3.png">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg">
                <div class="our_partner">
                    <img class="img-fluid" src="{{asset('assets')}}/images/partners/4.png" alt="4.png">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg">
                <div class="our_partner">
                    <img class="img-fluid" src="{{asset('assets')}}/images/partners/5.png" alt="5.png">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection