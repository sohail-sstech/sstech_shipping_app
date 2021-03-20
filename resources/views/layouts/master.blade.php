<head>
	<title>SSTECHSHIPPING APP</title> 
<!--<base href="{{URL::asset('/')}}" target="_top">-->
	<base href="{{secure_asset('/')}}" target="_top">

  <!-- Fontfaces CSS-->
  <link rel="shortcut icon" href="{{ secure_asset('images/mobile_logo.png') }}">
  <link rel="stylesheet" href="{{ secure_asset('css/font-face.css')}}" media="all"/>
  <link href="{{ secure_asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ secure_asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ secure_asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
  <!-- Bootstrap CSS-->
  <link href="{{ secure_asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">	
  <!-- Vendor CSS-->
  <link href="{{ secure_asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ secure_asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
  <link href="{{ secure_asset('vendor/wow/animate.css" rel="stylesheet')}}" media="all">
  <link href="{{ secure_asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
  <!--<link href="{{ secure_asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">-->
  <link href="{{ secure_asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
  <!--<link href="{{ secure_asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">-->
  
 <!-- Main CSS-->
  <link href="{{ secure_asset('css/theme.css') }}" rel="stylesheet" media="all">
  
  <!-- datatable -->
  <!--<link href="{{ secure_asset('css/dataTables.bootstrap.css') }}" rel="stylesheet" media="all">
  <link href="{{ secure_asset('css/dataTables.responsive.css') }}" rel="stylesheet" media="all">-->
  <link href="{{ secure_asset('css/daterangepicker.css') }}" rel="stylesheet" media="all">
<link href="{{ secure_asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" media="all">
  <!--<script type="text/javascript" src="{{{ URL::asset('js/jquery.2.1.1.min.js')}}}"></script>
  <script src="{{{ URL::asset('js/bootstrap.min.js')}}}"></script>
  <script src="{{{ URL::asset('js/theme.min.js')}}}"></script>-->
</head>
<body class="animsition1">
<div class="page-wrapper">
  @include('partials.header')
  @include('partials.sidebar')
  <div class="page-container">
  <div class="main-content">
    <div class="section__content section__content--p30">
      <!--<div class="breadcrumbs" id="breadcrumbs"></div>-->
      @yield('content') 
    </div>
  </div>
  </div>
 @include('partials.footer')
</div>
</body>