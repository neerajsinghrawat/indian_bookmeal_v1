 <?php $model = new App\Models\Setting;
       $setting = get_data($model); ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">        
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <title><?php echo (!empty($setting->site_title))? $setting->site_title:'';?> | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
    <meta content="" name="description" />
  <meta content="" name="author" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php echo (!empty($setting->google_analytic))? $setting->google_analytic:'';?>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/admin_development.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!--   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->



  <!-- 
  <link rel="stylesheet" href="{{ asset('css/admin/dataTables.bootstrap.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('js/admin/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/admin/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. --><!-- 
  <link rel="stylesheet" href="{{ asset('css/admin/skins/_all-skins.min.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('css/admin/alt/AdminLTE-without-plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('css/franchise/skins/_all-skins.css') }}">

  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('css/admin/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('css/admin/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('css/admin/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
 <!--  <link rel="stylesheet" href="{{ asset('css/admin/bootstrap-daterangepicker/daterangepicker.css') }}"> -->
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<script src="{{ asset('js/admin/jquery.min2.1.3.js') }}"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini" base-url="">
 
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo URL::to('/'); ?>/admin" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ ucwords($setting->site_title) }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
             
			<li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo count($activeComplaintDataArr); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo count($activeComplaintDataArr); ?> complaints</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
        <?php
        //echo '<pre>activeComplaintArr'; print_r($activeComplaintDataArr); die;
          if(!empty($activeComplaintDataArr) && count($activeComplaintDataArr) >0){ 
            foreach($activeComplaintDataArr as $key => $active_complaint){ 
            
        ?>
                  <li><!-- start message -->
                    <a href="<?php echo URL::to('/'); ?>/admin/users/view/<?php echo $active_complaint['user_id']; ?>">
                      <div class="pull-left">
                        ORDER ID:  <?php echo $key ?>
                      </div>
            <br/>
                      <h4>
                         <?php echo $active_complaint['problem'];?>
            
                        <small><i class="fa fa-clock-o"></i> <?php echo $active_complaint['created_at']; ?></small>
                      </h4>
            <?php /*foreach($active_complaint as $complaint){  ?>
                      <p><?php echo $complaint['problem']; ?></p>
            <?php } */ ?>
                    </a>
                  </li>
          <?php } } ?>
         
         </ul>
              </li>
              <!-- <li class="footer"><a href="#">See All Messages</a></li> -->
            </ul>
          </li>

          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo count($preorderDataArr); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo count($preorderDataArr); ?> Pre-order</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php
                    
                      if(!empty($preorderDataArr) && count($preorderDataArr) >0){ 
                        foreach($preorderDataArr as $key => $preordernum){ 
                        
                    ?>
                  <li>
                    <a href="{{ URL::to('admin/orders/'.$preordernum['order_number']) }}">
                       <b>{{ $preordernum['order_number'] }}</b> <p class="pull-right">{{ $preordernum['date'] }}</p>
                    </a>
                  </li>
                  <?php } } ?>
                </ul>
              </li><!-- 
              <li class="footer"><a href="#">View all</a></li> -->
            </ul>
          </li>
           
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}}
                </p>
              </li>
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
          
      <form id="logout-form" action="{{ 'App\Admin' == Auth::getProvider()->getModel() ? route('admin.logout') : route('logout') }}" method="POST" style="display: none;">
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
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
  
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->

    <?php 
      $controller_name = '';
       $request = Request();
      $prifix = $request->route()->getPrefix();
     
      if($_SERVER['SERVER_NAME'] == "localhost"){
        $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        if(!empty($request_uri)){
        
         $controller_name = str_replace(array('bookmeal',$prifix,'/'), '', $request_uri);
         
        }
      }else{
        $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        if(!empty($request_uri)){
        
         $controller_name = str_replace(array($_SERVER['HTTP_HOST'],$prifix,'/'), '', $request_uri);
         
        }
      }


    ?>

      <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ (!empty($controller_name))?:'active' }}" >
          <a href="{{ URL::to('admin/') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>          
          </a>
        </li>

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'groups'))?'active':'' }}">
          <a href="{{ URL::to('admin/groups') }}"><i class="fa fa-group" aria-hidden="true"></i>Group</a>
        </li>

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'users'))?'active':'' }}">
          <a href="{{ URL::to('admin/users') }}"><i class="fa fa-user" aria-hidden="true"></i>User</a>
        </li>

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'categories'))?'active':'' }}">
          <a href="{{ URL::to('admin/categories') }}"><i class="fa fa-list-alt" aria-hidden="true"></i>Category</a>
        </li>

        <!-- <li class="{{ ((!empty($controller_name)) && ($controller_name == 'products'))?'active':'' }}">
          <a href="{{ URL::to('admin/products') }}"><i class="fa fa-cubes"></i> Products</a>
        </li>
 -->        <li class="treeview menu">
          <a href="#">
            <i class="fa fa-cubes"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ((!empty($controller_name)) && ($controller_name == 'products'))?'active':'' }}"><a href="{{ URL::to('admin/products') }}"><i class="fa fa-circle-o"></i> All Products</a></li>
            <li class="{{ ((!empty($controller_name)) && ($controller_name == 'productFeatures'))?'active':'' }}"><a href="{{ URL::to('admin/productFeatures') }}"><i class="fa fa-circle-o"></i> Product Attributes</a></li>
          </ul>
        </li>


        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'sliders'))?'active':'' }}">
          <a href="{{ URL::to('admin/sliders') }}"> <i class="fa fa-picture-o" aria-hidden="true"></i>Slider Manager</a>
        </li>

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'paymentGetways'))?'active':'' }}">
          <a href="{{ URL::to('admin/paymentGetways/edit') }}"> <i class="fa fa-picture-o" aria-hidden="true"></i>Payment Getway Manager</a>
        </li>  
        

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'pages'))?'active':'' }}">
          <a href="{{ URL::to('admin/pages') }}"> <i class="fa fa-file-text" aria-hidden="true"></i>Pages</a>
        </li>        

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'book_table'))?'active':'' }}">
          <a href="{{ URL::to('admin/book_table') }}"><i class="fa fa-square-o" aria-hidden="true"></i>Table Reservations</a>
        </li>
        
        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'orders'))?'active':'' }}">
          <a href="{{ URL::to('admin/orders') }}"><i class="fa fa-bars" aria-hidden="true"></i>Orders</a>
        </li>
        <!--  <li>
          <a href="{{ URL::to('admin/features') }}"><i class="fa fa-bars" aria-hidden="true"></i>

 Feature</a>
        </li>
        <li>
          <a href="{{ URL::to('admin/featureGroups') }}"><i class="fa fa-bars" aria-hidden="true"></i> Feature Group</a>
        </li> -->
        <!-- <li class="{{ ((!empty($controller_name)) && ($controller_name == 'franchises'))?'active':'' }}">
          <a href="{{ URL::to('admin/franchises') }}"><i class="fa fa-building-o" aria-hidden="true"></i>Franchise</a>
        </li> -->

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'postcodes'))?'active':'' }}">
          <a href="{{ URL::to('admin/postcodes') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>Post Codes</a>
        </li>  

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'couponcodes'))?'active':'' }}">
          <a href="{{ URL::to('admin/couponcodes') }}"><i class="fa fa-ticket" aria-hidden="true"></i>Coupon Codes</a>
        </li>  

 

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'popups'))?'active':'' }}">
          <a href="{{ URL::to('admin/popups') }}"> <i class="fa fa-square-o" aria-hidden="true"></i>Popups Manager</a>
        </li> 
        

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'testimonials'))?'active':'' }}">
          <a href="{{ URL::to('admin/testimonials') }}"> <i class="fa fa-group" aria-hidden="true"></i>Testimonial Manager</a>
        </li>          

        <!-- <li class="{{ ((!empty($controller_name)) && ($controller_name == 'productFeatures'))?'active':'' }}">
          <a href="{{ URL::to('admin/productFeatures') }}"> <i class="fa fa-group" aria-hidden="true"></i>Product Features Manager</a>
        </li>  --> 

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'news_letters'))?'active':'' }}">
          <a href="{{ URL::to('admin/news_letters') }}"> <i class="fa fa-paper-plane-o" aria-hidden="true"></i>Newsletter Manager</a>
        </li> 

        
        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'contact_us'))?'active':'' }}">
          <a href="{{ URL::to('admin/contact_us') }}"><i class="fa fa-envelope" aria-hidden="true"></i>Contact us</a>
        </li>

        
        <!-- <li class="{{ ((!empty($controller_name)) && ($controller_name == 'openHours'))?'active':'' }}">
          <a href="{{ URL::to('admin/openHours') }}"><i class="fa fa-clock-o" aria-hidden="true"></i>Open Hours</a>
        </li> -->
        
        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'clients'))?'active':'' }}">
          <a href="{{ URL::to('admin/clients') }}"><i class="fa fa-group" aria-hidden="true"></i>Client</a>
        </li>    

        <!-- <li class="{{ ((!empty($controller_name)) && ($controller_name == 'blogs'))?'active':'' }}">
          <a href="{{ URL::to('admin/blogs') }}"><i class="fa fa-clone" aria-hidden="true"></i>Blogs</a>
        </li> -->

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'staffs'))?'active':'' }}">
          <a href="{{ URL::to('admin/staffs') }}"><i class="fa fa-users" aria-hidden="true"></i>Staffs</a>
        </li>

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'emailTemplates'))?'active':'' }}">
          <a href="{{ URL::to('admin/emailTemplates') }}"><i class="fa fa-envelope-o" aria-hidden="true"></i>Email Templates</a>
        </li>        

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'shippingTaxes'))?'active':'' }}">
          <a href="{{ URL::to('admin/shippingTaxes') }}"><i class="fa fa-envelope-o" aria-hidden="true"></i>Shipping & Taxes</a>
        </li>

        <li class="{{ ((!empty($controller_name)) && ($controller_name == 'settings'))?'active':'' }}">
          <a href="{{ URL::to('admin/settings') }}"><i class="fa fa-gears" aria-hidden="true"></i>Setting</a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Left side column. contains the logo and sidebar -->

<div class="content-wrapper">         
 @include('partials._messages')
           
 @yield('content')
</div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<!-- jQuery UI 1.11.4 
<script src="{{ asset('js/admin/jquery-ui.min.js') }}"></script>-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<link rel="stylesheet" href="{{ asset('js/admin/selectize/dist/css/selectize.default.css') }}">
<script src="{{ asset('js/admin/selectize/dist/js/standalone/selectize.js') }}"></script>
<script src="{{ asset('js/admin/selectize/examples/js/index.js') }}"></script>



<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('js/admin/raphael.min.js') }}"></script>
<script src="{{ asset('js/admin/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('js/admin/jquery.sparkline.min.js') }}"></script>


<script src="{{ asset('js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('js/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('js/admin/plugins/chartjs/Chart.min.js') }}"></script>

<script src="{{ asset('js/admin/jquery.knob.min.js') }}"></script>


<script src="{{ asset('js/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<!-- daterangepicker -->
<!-- <script src="{{ asset('js/admin/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('js/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script> -->
<!-- datepicker -->
<!-- <script src="{{ asset('js/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> -->
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('js/admin/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('js/admin/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/admin/adminlte.min.js') }}"></script>
<script src="{{ asset('js/admin/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('js/admin/pages/dashboard.js') }}"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/admin/demo.js') }}"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->

<!-- <script src="{{ asset('js/admin/common.function.js') }}"></script> -->

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

<script type="text/javascript">
setTimeout(function() {
    $('.Messages').fadeOut('fast');
}, 3000); 
</script>
</body>
</html>
