@extends('layouts.master')
@section('content')
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
  var days = Math.floor(distance / (8000 * 60 * 60 * 24));
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


@endsection