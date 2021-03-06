<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Miss Silliman 2018</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="public/pages/ico/152.png" />
    <link rel="apple-touch-icon" href="public/pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="public/pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="public/pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="public/pages/ico/152.png">
    <!-- Google Fonts -->
    <link href="public/fonts/roboto.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="public/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="public/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Waves Effect Css -->
    <link href="public/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="public/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="public/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="public/css/themes/all-themes.css" rel="stylesheet" />

    <!-- Font Icons -->
    <link href="public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="public/plugins/ionicon/css/ionicons.min.css" rel="stylesheet" />
    <link href="public/css/material-design-iconic-font.min.css" rel="stylesheet">

    <!-- Custom Files -->
    <link href="public/css/helper.css" rel="stylesheet" type="text/css" />
    <link href="public/css/customStyles.css" rel="stylesheet" type="text/css" />
    <link href="public/css/imagething.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="public/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="public/css/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        @media screen {
      #printSection {
          display: none;
      }
    }

    @media print {
      body * {
        visibility:hidden;
      }
      #printSection, #printSection * {
        visibility:visible;
      }
      #printSection {
        position:absolute;
        left:0;
        top:0;
      }
    }
</style>



</head>

<body class="theme-red fixed-left">
    <!-- Page Loader -->
    <div id="wrapper">
      <div class="page-loader-wrapper">
          <div class="loader">
              <div class="preloader">
                  <div class="spinner-layer pl-red">
                      <div class="circle-clipper left">
                          <div class="circle"></div>
                      </div>
                      <div class="circle-clipper right">
                          <div class="circle"></div>
                      </div>
                  </div>
              </div>
              <p>Please wait...</p>
          </div>
      </div>
      <!-- #END# Page Loader -->
      <!-- Overlay For Sidebars -->
      <div class="overlay"></div>
      <!-- #END# Overlay For Sidebars -->
      <!-- Top Bar -->
      <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-links">
              <div class="navbar-header">
                  <a href="javascript:void(0);" class="bars"></a>
                  <a class="navbar-brand" href="{{url('/')}}">Miss Silliman 2018</a>
              </div>
            </div>
          </div>
      </nav>
      <!-- #Top Bar -->
      <section>
          <!-- Left Sidebar -->
          <aside id="leftsidebar" class="sidebar">
              <!-- User Info -->
              <div class="user-info">
                  <div class="info-container">
                      <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <strong>{{Auth::user()->fName}} {{Auth::user()->mName}} {{Auth::user()->lName}}</strong>
                      </div>
                      <div class="email">{{Auth::user()->event}}</div>
                  </div>
              </div>
              <!-- #User Info -->
            <div class="menu">
              <ul class="list">
                <li>
                  <a href="{{url('/welcome')}}">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                  </a>
                </li>
                @if(Auth::user()->userType == "organizer")
                <li>
                  <a href="{{url('/maintenance')}}">
                    <i class="material-icons">settings</i>
                    <span>Maintenance</span>
                  </a>
                </li>
                @endif
                <li>
                  <a href="{{url('/logout')}}">
                    <i class="material-icons">exit_to_app</i>
                    <span>Logout</span>
                  </a>
                </li>
              </ul>



                  <!-- end RJBS edit -->
            </div>
          <!-- #END# Left Sidebar -->
      </section>
