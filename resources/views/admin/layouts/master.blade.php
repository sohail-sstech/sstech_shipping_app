<head>
<!--<base href="{{URL::asset('/')}}" target="_top">-->
	<base href="{{asset('/')}}" target="_top">
 
  <!-- Fontfaces CSS-->
  <link rel="stylesheet" href="{{ asset('css/font-face.css')}}" media="all"/>
  <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
  <!-- Bootstrap CSS-->
  <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">	
  <!-- Vendor CSS-->
  <link href="{{ asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ asset('vendor/wow/animate.css" rel="stylesheet')}}" media="all">
  <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
  <!--<link href="{{ asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">-->
  <link href="{{ asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
  <!--<link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">-->
  
 <!-- Main CSS-->
  <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">
  
  <!-- datatable -->
  <!--<link href="{{ asset('css/dataTables.bootstrap.css') }}" rel="stylesheet" media="all">
  <link href="{{ asset('css/dataTables.responsive.css') }}" rel="stylesheet" media="all">-->
  <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet" media="all">
   
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('css/sstechshippingapp.css') }}" rel="stylesheet" media="all">

<!--<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" media="all">-->
  <!--<script type="text/javascript" src="{{{ URL::asset('js/jquery.2.1.1.min.js')}}}"></script>
  <script src="{{{ URL::asset('js/bootstrap.min.js')}}}"></script>
  <script src="{{{ URL::asset('js/theme.min.js')}}}"></script>-->
</head>
<body class="animsition">
<div class="page-wrapper">
  @include('admin.partials.header')
   <!--<div class="page-container">
	<div class="main-content">
    <div class="section__content section__content--p30">-->
      
        
      
      @yield('content') 
    <!--</div>
	</div>
  </div>-->
 @include('admin.partials.footer')
</div>
</body>