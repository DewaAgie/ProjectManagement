<!DOCTYPE html>
<html lang="en" style="background: {{Auth::User()->dark_mode==1?'#383f48':'#fff'}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baseurl" content="{{url('/')}}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('template/assets/images/favicon.png')}}">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{url('template/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('template/assets/plugins/wizard/steps.css')}}" type="text/css">
    <!-- morris CSS -->
    <link href="{{url('template/assets/plugins/morrisjs/morris.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href='{{url("template/".(Auth::User()->dark_mode == 1?'dark-mode':'normal-mode')."/css/style.css")}}' class="themes-mode-css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{url('template/'.(Auth::User()->dark_mode == 1?"dark-mode":"normal-mode").'/css/colors/'.(Auth::User()->dark_mode == 1?'default-dark':'megna-dark').'.css')}}" class="themes-mode-css" id="theme" rel="stylesheet">
    <link href="{{url('template/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('template/assets/plugins/fancybox/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{url('template/assets/plugins/select2/dist/css/select2.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('template/assets/plugins/jquery-loading-master/src/loading.css')}}" type="text/css">
    <!-- Date picker plugins css -->
    <link href="{{url('template/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('template/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
    <!-- Drag and Drop Image -->
    <link rel="stylesheet" href="{{url('/template/assets/plugins/drag-drop-image/dist/image-uploader.min.css')}}">

    <link rel="stylesheet" href="{{url('/css/style.css')}}">
</head>
<style type="text/css">
    .loading-overlay {
        z-index: 999!important;
    }
    .message-notification .slimScrollDiv{
        height: 290px!important;
    }
    .message-notification .message-center{
        height: 290px!important;
    }
    .notifApp{
        display: none;
    }
    .bootstrap-tagsinput {
        width: 100% !important;
   }
   .bootstrap-tagsinput .label{
        display: inline-block!important;
   }
   .pac-container {
      z-index: 99999;
    }
</style>
<script>
    var roleUser  = "{{Auth::User()->role}}";
    var link      = "{{url('/')}}";
</script>
<body class="fix-header fix-sidebar card-no-border">
  <input type="hidden" name="url" id="url">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
          <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#!">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{url('template/assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{url('template/assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                          <!-- dark Logo text -->
                          <img src="{{url('/template/assets/images/logo-app-text.png')}}" alt="homepage" class="dark-logo" />
                          <!-- Light Logo text -->    
                          <img src="{{url('/template/assets/images/logo-app-light-text.png')}}" class="light-logo" alt="homepage" />
                        </span> 
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown" style="display:none;">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
                              <div class="notify notifAll" style="display: none;"> 
                                <span class="heartbit"></span> <span class="point"></span> 
                              </div>                                
                            </a>
                            <div class="dropdown-menu mailbox scale-up-left message-notification">
                              <ul>
                                <li>
                                    <div class="drop-title">Notifications</div>
                                </li>
                                <li>
                                  <div class="message-center">
                                    <!-- Message -->
                                    <a href="{{url('/pelanggan?list=2')}}">
                                        <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                        <div class="mail-contnet" style="padding-left:10px;">
                                            <h6><span class="span_notif">0</span> Proses Survey Pemasangan</h6>
                                        </div>
                                        <div class="notify notifApp"> 
                                          <span class="heartbit"></span> <span class="point"></span> 
                                        </div>  
                                    </a>
                                    <!-- Message -->
                                    <a href="{{url('/pelanggan?list=3')}}">
                                        <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                        <div class="mail-contnet" style="padding-left:10px;">
                                            <h6>
                                                <span class="span_notif">0</span> Proses Verifikasi
                                            </h6>
                                         </div>
                                         <div class="notify notifApp"> 
                                          <span class="heartbit"></span> <span class="point"></span> 
                                        </div>  
                                    </a>
                                    <!-- Message -->
                                    <a href="{{url('/pelanggan?list=4')}}">
                                        <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                        <div class="mail-contnet" style="padding-left:10px;">
                                            <h6><span class="span_notif">0</span> Proses Instalasi</h6>
                                        </div>
                                        <div class="notify notifApp"> 
                                          <span class="heartbit"></span> <span class="point"></span> 
                                        </div>  
                                    </a>
                                     <!-- Message -->
                                    <a href="{{url('/pelanggan?list=8')}}">
                                        <div class="btn btn-danger btn-circle"><i class="fa fa-location-arrow"></i></div>
                                        <div class="mail-contnet" style="padding-left:10px;">
                                            <h6><span class="span_notif">0</span> Survey hari ini</h6>
                                        </div>
                                        <div class="notify notifApp"> 
                                          <span class="heartbit"></span> <span class="point"></span> 
                                        </div>  
                                    </a>
                                    <!-- Message -->
                                    <a href="{{url('/pelanggan?list=9')}}">
                                        <div class="btn btn-primary btn-circle">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-cog" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-user-cog fa-w-20"><path fill="currentColor" d="M610.5 373.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 400.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm201.2 226.5c-2.3-1.2-4.6-2.6-6.8-3.9l-7.9 4.6c-6 3.4-12.8 5.3-19.6 5.3-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-5.5-17.7 1.9-36.4 17.9-45.7l7.9-4.6c-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-16-9.2-23.4-28-17.9-45.7.9-2.9 2.2-5.8 3.2-8.7-3.8-.3-7.5-1.2-11.4-1.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c10.1 0 19.5-3.2 27.2-8.5-1.2-3.8-2-7.7-2-11.8v-9.2z" class=""></path></svg>
                                        </div>
                                        <div class="mail-contnet" style="padding-left:10px;">
                                            <h6><span class="span_notif">0</span> Instalasi hari ini</h6>
                                        </div>
                                        <div class="notify notifApp"> 
                                          <span class="heartbit"></span> <span class="point"></span> 
                                        </div>  
                                    </a>                                                 
                                    <a href="{{url('/pelanggan?list=10')}}">
                                        <div class="btn btn-primary btn-circle"><i class="fa fa-check"></i></div>
                                        <div class="mail-contnet" style="padding-left:10px;">
                                            <h6><span class="span_notif">0</span> Aktivasi hari ini</h6>
                                        </div>
                                        <div class="notify notifApp"> 
                                          <span class="heartbit"></span> <span class="point"></span> 
                                        </div>  
                                    </a>                                                 
                                  </div>
                                </li>
                               {{--  <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li> --}}
                              </ul>
                            </div>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        {{-- <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li> --}}
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="    border-radius: 50%;background-repeat: no-repeat;background-size: cover;background-position: center;background-image: url('{{Auth::User()->foto != null && Auth::User()->foto!=""?url('/uploadgambar/'.Auth::User()->foto):url('/img/user-icon.png')}}');width: 50px;height: 50px;">                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                          <table>
                                            <tr>
                                              <td style="width: 70px;background-size: cover;background-repeat: no-repeat;background-position: center;background-image: url('{{Auth::User()->foto != null && Auth::User()->foto!=""?url('/uploadgambar/'.Auth::User()->foto):url('/img/user-icon.png')}}')">
                                                <div class="u-img">
                                                    
                                                </div>                                                
                                              </td>
                                              <td>
                                                <div class="u-text">
                                                  <h4 class="mail-desc">{{Auth::User()->name}}</h4>
                                                  <p class="text-muted">{{Auth::User()->email}}</p>
                                                  <a href="{{url('/users/form?id='.Auth::User()->id)}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                                </div>                                                
                                              </td>
                                            </tr>
                                          </table>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li class="chooseThemeDark" style="display: {{Auth::User()->dark_mode == 1?'none':''}}"><a href="#" onclick="gantiTema(1)"><i class="ti-brush"></i> Dark Themes</a></li>
                                    <li class="chooseThemeLight" style="display: {{Auth::User()->dark_mode == 0?'none':''}}"><a href="#" onclick="gantiTema(0)"><i class="ti-brush"></i> Light Themes</a></li>
                                   {{--  <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                    <li role="separator" class="divider"></li> --}}
                                    <li><a href="{{ route('logout') }}" 
                                          onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                @include('layouts.sidebar')
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
           @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2021 copyright by Dewa Agix </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{url('template/assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{url('template/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{url('template/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script class="themes-mode-script" src="{{url('template/'.(Auth::User()->dark_mode == 1?"dark-mode":"normal-mode").'/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script class="themes-mode-script" src="{{url('template/'.(Auth::User()->dark_mode == 1?"dark-mode":"normal-mode").'/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script class="themes-mode-script" src="{{url('template/'.(Auth::User()->dark_mode == 1?"dark-mode":"normal-mode").'/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{url('template/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script class="themes-mode-script" src="{{url('template/'.(Auth::User()->dark_mode == 1?"dark-mode":"normal-mode").'/js/custom.js')}}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="{{url('template/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--morris JavaScript -->
    <script src="{{url('template/assets/plugins/raphael/raphael-min.js')}}"></script>
    <script src="{{url('template/assets/plugins/morrisjs/morris.min.js')}}"></script>
    <script src="{{url('template/assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <script src="{{url('template/'.(Auth::User()->dark_mode == 1?"dark-mode":"normal-mode").'/js/validation.js')}}"></script>
    <!-- Sweet-Alert  -->
    <script src="{{url('template/assets/plugins/swal/sweetalert2.all.min.js')}}"></script>
    <script src="{{url('template/assets/plugins/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{url('template/assets/plugins/fancybox/jquery.fancybox.pack.js')}}"></script>
    <script src="{{url('template/assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{url('template/assets/plugins/jquery-loading-master/src/loading.js')}}"></script>
    <script src="{{url('template/assets/plugins/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{url('template/assets/plugins/wizard/jquery.validate.min.js')}}"></script>
    {{-- <script src="{{url('template/assets/plugins/jquery-locationpicker-plugin-master/dist/locationpicker.jquery.js')}}"></script> --}}
    <script src="{{url('template/assets/plugins/moment/moment.js')}}"></script>
    <script src="{{url('template/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{url('template/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{url('template//assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <!-- Drag and Drop Image -->
    <script src="{{url('/template/assets/plugins/drag-drop-image/dist/image-uploader.js')}}"></script>
</body>
<script type="text/javascript">
  var link = "{{url('/')}}";
  $.Loading.setDefaults({ theme: '{{Auth::User()->dark_mode == 1?'dark':'light'}}'});
  $(document).ready(function(){
    $('.fancybox').fancybox();
    $('.select2').select2();
    // setNotification();
  });

  function setNotification(){
    var ada = 0;
    $.getJSON(link+'/hitungNotif', function(data){
        var index = 0;
        $('.span_notif').each(function(){
            $(this).html(data[index]);
            if(data[index] > 0){
                ada++;
                $('.notifApp').eq(index).show();
            }else{
                $('.notifApp').eq(index).hide();
            }
            index++;
        });
    }).done(function(){
      if(ada > 0){
        $('.notifAll').show();
      }
    });
  }  

  function gantiTema(tipe) {
    var tipe1 = "dark-mode";
    var tipe2 = "normal-mode";    
    localStorage["themes"] = "normal";
    if(tipe == 1){
      localStorage["themes"] = "dark";      
      tipe1 = "normal-mode";
      tipe2 = "dark-mode";
    }
    setTheme(tipe,tipe1,tipe2);
  }

  function setTheme(tipe,tipe1,tipe2){
    $('.preloader').show();
    $.getJSON(link+'/users/setThemeUser?dark='+tipe, function(data){      
      $('.themes-mode-script').each(function(){
        var newLink = $(this).attr('src').replace(tipe1,tipe2);
        $(this).attr("src",newLink);
      });
      $('.themes-mode-css').each(function(){
        var newLink = $(this).attr('href').replace(tipe1,tipe2);
        $(this).attr("href",newLink);
      });

      var href = $('#theme').attr('href');
      if(tipe == 1){
        $('.chooseThemeDark').hide();
        $('.chooseThemeLight').show();
        $('html').css("background","#383f48");
        $('#theme').attr('href',href.replace("megna-dark.css","default-dark.css"));
        $.Loading.setDefaults({ theme: 'dark'});
      }else{
        $('.chooseThemeDark').show();
        $('.chooseThemeLight').hide();
        $('html').css("background","#fff");
        $('#theme').attr('href',href.replace("default-dark.css","megna-dark.css"));
        $.Loading.setDefaults({ theme: 'light'});
      }
      setTimeout(function(){
        $('.preloader').hide();
      },1000);
    });    
  }

    function showGambarFancyBox(gambar) {
      $.fancybox([
        gambar,
      ],{
       'type': 'image'
     });
    }
    
</script>
@yield('javascript')
</html>