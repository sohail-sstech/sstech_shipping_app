<style>
.bgimg {
  background-image: url('/images/comingsoon.jpg');
  height: 100%;
  background-position: center;
  background-size: cover;
  position: relative;
  color: white;
  font-family: "Courier New", Courier, monospace;
  font-size: 25px;
}

.topleft {
  position: absolute;
  top: 0;
  left: 16px;
}

.bottomleft {
  position: absolute;
  bottom: 0;
  left: 16px;
}

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: #fff !important;
}
.middle h1{
	color: #fff !important;
}

hr {
  margin-left:auto;	
  margin-right:auto;
  margin-top: 1rem;
  margin-bottom: 1rem;
  width: 40%;
  border:1px solid #EEEEEE!important;
}
</style>
<script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24 * 2));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
<!--<div class="container-fluid">-->
                
<div class="bgimg">
  <!--<div class="topleft">
    <p>Logo</p>
  </div>-->
  <div class="middle">
    <h1>COMING SOON</h1>
    <hr>
	<p id="demo" style="font-size:30px"></p>
    <!--<p>35 days left</p>-->
  </div>
  <!--<div class="bottomleft">
    <p>Some text</p>
  </div>-->
</div>
<!--</div>-->
 <!--<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>BlueSky</title>
      <link rel="stylesheet" href="{{ secure_asset('css/template/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{ secure_asset('css/template/style.css')}}">
      <link rel="stylesheet" href="{{ secure_asset('css/template/fontawesome.min.css')}}">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
   </head>
   <body>
      <div id="header" class="header">
         <nav class="navbar navbar-expand-lg navbar-light text-capitalize">
            <div class="container">
               <a class="navbar-brand" href="#"><img src="{{ secure_asset('images/template/logo.png')}}" alt="#" /></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#show-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="show-menu">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="#home">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#service">Service</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#hiw">How it's Works</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#wcs">What Clients Say</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                     </li>
                     <li class="nav-item .search-container">
                        <a class="nav-link search" href="#"><i class="fas fa-search"></i></a>
                        <form>
                           <input type="search" placeholder="Search">
                        </form>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
      </div>
      <div id="home" class="slider">
         <div id="main_slider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#main_slider" data-slide-to="0" class="active"></li>
               <li data-target="#main_slider" data-slide-to="1"></li>
               <li data-target="#main_slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <img class="d-block w-100" src="{{ secure_asset('images/template/slide1.jpg')}}" alt="slider_img">
                  <div class="ovarlay_slide_cont">
                     <h2>We love working</h2>
                     <h4>Maintenance service</h4>
                     <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years</p>
                     <a class="blue_bt" href="#">See Our Service</a>
                  </div>
               </div>
               <div class="carousel-item">
                  <img class="d-block w-100" src="{{ secure_asset('images/template/slide1.jpg')}}" alt="slider_img">
                  <div class="ovarlay_slide_cont">
                     <h2>We love working</h2>
                     <h4>Maintenance service</h4>
                     <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years</p>
                     <a class="blue_bt" href="#">See Our Service</a>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
            <img src="{{ secure_asset('images/template/left.png')}}" alt="#" />
            </a>
            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
            <img src="{{ secure_asset('images/template/right.png')}}" alt="#" />
            </a>
         </div>
      </div>
      <div id="about" class="about_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-5">
                  <h4>ABOUT BLUESKY</h4>
                  <h3 style="text-transform: none !important">We Build for Your Comfort</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
               </div>
               <div class="col-md-6 offset-md-1">
                  <div class="full text_align_center">
                     <img class="img-responsive" src="{{ secure_asset('images/template/about.png')}}" alt="#" />
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="hiw" class="hiw_section layout_padding" style="background: #1a2428;">
         <div class="container">
            <div class="row">
               <div class="col-md-7">
                  <h3 class="white_font">How it's Works</h3>
                  <p class="white_font">adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
               </div>
               <div class="col-md-5">
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/blog1.jpg')}}" alt="#" />
                  <h3 class="blog_head">Book Online</h3>
               </div>
               <div class="col-md-4">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/blog2.jpg')}}" alt="#" />
                  <h3 class="blog_head">Confirmation</h3>
               </div>
               <div class="col-md-4">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/blog3.jpg')}}" alt="#" />
                  <h3 class="blog_head">Work Status</h3>
               </div>
            </div>
         </div>
      </div>
      <div id="service" class="hiw_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-7">
                  <h3>OUR SERVICES</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
               </div>
               <div class="col-md-5">
               </div>
            </div>
            <div class="row">
               <div class="col-md-8 service_blog">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/s1.jpg')}}" alt="#" />
                  <h3 class="blog_head">Book Online</h3>
               </div>
               <div class="col-md-4 service_blog">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/s2.jpg')}}" alt="#" />
                  <h3 class="blog_head">Confirmation</h3>
               </div>
               <div class="col-md-4 service_blog">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/s3.jpg')}}" alt="#" />
                  <h3 class="blog_head">Work Status</h3>
               </div>
               <div class="col-md-4 service_blog">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/s4.jpg')}}" alt="#" />
                  <h3 class="blog_head">Work Status</h3>
               </div>
               <div class="col-md-4 service_blog">
                  <img class="margin_top_30 img-responsive" src="{{ secure_asset('images/template/s5.jpg')}}" alt="#" />
                  <h3 class="blog_head">Work Status</h3>
               </div>
            </div>
         </div>
      </div>
      <div id="contact" class="hiw_section layout_padding" style="background: #eeefef;">
         <div class="container">
            <div class="row">
               <div class="col-md-7">
                  <h3>Booking Online</h3>
               </div>
               <div class="col-md-5">
               </div>
            </div>
            <div class="row">
               <div class="col-md-7">
                  <div class="contact-form">
                     <form>
                        <input type="text" placeholder="Name" />
                        <input type="email" placeholder="Email" />
                        <input type="text" placeholder="Phone Number" />
                        <input type="text" placeholder="Type of Service">
                        <textarea placeholder="Message"></textarea>
                        <input type="submit" value="SEND">
                     </form>
                  </div>
               </div>
               <div class="col-md-5 text_align_center">
                  <img class="img-responsive" src="{{ secure_asset('images/template/man_cartoon.png')}}" alt="#" />
               </div>
            </div>
         </div>
      </div>
      <div id="wcs" class="hiw_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12 text_align_center">
                  <h3>Our Client Say</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
               </div>
               <div class="col-md-5">
               </div>
            </div>
            <div class="row">
               <div class="col-md-11">
                  <div class="full testimonial_blog">
                     <p>Jackrok</p>
                     <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscureContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="subcribe">
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-sm-6">
                  <h3>Newsletter</h3>
                  <p>dolor sit amet, consectetur adipiscing elit.<br>Ut elit tellus, luctus nec ullamcorper</p>
               </div>
               <div class="col-md-8 col-sm-6">
                  <form>
                     <input type="email" name="email" placeholder="Enter Your Email Address" />
                     <button>Subscribe</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <footer>
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-md-6 col-12">
                  <div class="footer_blog_section">
                     <img src="{{ secure_asset('images/template/logo.png')}}" alt="#" />
                     <p style="margin-top: 5px;">It is a long established fact that a reader will be distracted by the readable content..</p>
                  </div>
               </div>
               <div class="col-lg-2 col-md-6 col-12">
                  <div class="item">
                     <h4 class="text-uppercase">Navigation</h4>
                     <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Location</a></li>
                        <li><a href="#">Service</a></li>
                        <li><a href="#">Features</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6 col-12">
                  <div class="item">
                     <h4 class="text-uppercase">Contact Info</h4>
                     <p><strong>Corporate Office Address:</strong></p>
                     <p><img src="{{ secure_asset('images/template/phone_icon.png')}}" alt="#" /> 1234 River Street New York, NY 36524</p>
                     <p><strong>Customer Service:</strong></p>
                     <p><img src="{{ secure_asset('images/template/location.png')}}" alt="#" /> 987 654 3210</p>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 col-12">
                  <div class="item">
                     <h4 class="text-uppercase">Discover</h4>
                     <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">How It Works</a></li>
                        <li><a href="#">Subscribe</a></li>
                        <li><a href="#">Contact Us</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright text-center">
            <p>Copyright 2019  Design by <a href="https://html.design">Free Html Templates</a></p>
         </div>
      </footer>
      <script src="{{ secure_asset('js/template/jquery-3.3.1.min.js')}}"></script>
      <script src="{{ secure_asset('js/template/bootstrap.min.js')}}"></script>
      <script>
         $(function () {
             
             'use strict';
             
             var winH = $(window).height();
             
             $('header').height(winH);  
             
             $('header .container > div').css('top', (winH / 2) - ( $('header .container > div').height() / 2));
             
             $('.navbar ul li a.search').on('click', function (e) {
                 e.preventDefault();
             });
             $('.navbar a.search').on('click', function () {
                 $('.navbar form').fadeToggle();
             });
             
             $('.navbar ul.navbar-nav li a').on('click', function (e) {
                 
                 var getAttr = $(this).attr('href');
                 
                 e.preventDefault();
                 $('html').animate({scrollTop: $(getAttr).offset().top}, 1000);
             });
         })
      </script>
   </body>

  </html>-->
 
