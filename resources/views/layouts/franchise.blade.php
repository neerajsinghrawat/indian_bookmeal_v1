 <?php $model = new App\Models\Setting;
       $setting = get_data($model); ?>
       <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo (!empty($setting->site_title))? $setting->site_title:'';?> | Franchise</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('css/franchise/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/franchise/bootstrap.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!--   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->



  <!-- 
  <link rel="stylesheet" href="{{ asset('css/franchise/dataTables.bootstrap.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('js/franchise/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/franchise/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('css/franchise/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('css/franchise/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('css/franchise/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('css/franchise/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
 <!--  <link rel="stylesheet" href="{{ asset('css/franchise/bootstrap-daterangepicker/daterangepicker.css') }}"> -->
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('js/franchise/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<script src="{{ asset('js/franchise/jquery.min2.1.3.js') }}"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="sidebar-mini skin-purple fixed" base-url="">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Franchise</b>Manager</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
     
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ ucwords(Auth::user()->name) }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                <p>
                  {{ ucwords(Auth::user()->name) }}
                </p>
              </li>
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('franchise.logout') }}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
          
      <form id="logout-form" action="{{ 'App\Models\Franchise' == Auth::getProvider()->getModel() ? route('franchise.logout') : route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
         </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ ucwords(Auth::user()->name) }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
  
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="{{ URL::to('franchise/') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>          
          </a>
          
        </li>
       

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Left side column. contains the logo and sidebar -->



 @yield('content')

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<!-- jQuery UI 1.11.4 
<script src="{{ asset('js/franchise/jquery-ui.min.js') }}"></script>-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/franchise/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('js/franchise/raphael.min.js') }}"></script>
<script src="{{ asset('js/franchise/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('js/franchise/jquery.sparkline.min.js') }}"></script>


<script src="{{ asset('js/franchise/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('js/franchise/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('js/franchise/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('js/franchise/plugins/chartjs/Chart.min.js') }}"></script>

<script src="{{ asset('js/franchise/jquery.knob.min.js') }}"></script>


<script src="{{ asset('js/franchise/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/franchise/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<!-- daterangepicker -->
<!-- <script src="{{ asset('js/franchise/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('js/franchise/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script> -->
<!-- datepicker -->
<!-- <script src="{{ asset('js/franchise/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> -->
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('js/franchise/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('js/franchise/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('js/franchise/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/franchiselte.min.js') }}"></script>
<script src="{{ asset('js/franchiselte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('js/franchise/pages/dashboard.js') }}"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/franchise/demo.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<!-- <script src="{{ asset('js/franchise/common.function.js') }}"></script> -->

<script>
  $(function () {

    $('#example1').DataTable();
    $('#example2').DataTable({

      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    CKEDITOR.replace('editor2')
    //bootstrap WYSIHTML5 - text editor
   // $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
