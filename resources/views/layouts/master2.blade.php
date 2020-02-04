
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  <link rel="stylesheet" href="/css/app.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- 
  <script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
  -->
</head>


<!---vue permss-->
<script>
  @auth
    window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
  @else
    window.Permissions = [];
  @endauth
</script>
<script>
    @auth
      window.Roles = {!! json_encode(Auth::user()->allRoles, true) !!};
    @else
      window.Roles = [];
    @endauth
  </script>
<!---vue permss-->


<!-- <body class="hold-transition sidebar-mini layout-fixed"> -->
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper" id="app">

  <!-- Navbar -->
  @include('_partials.4-top-navbar')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
 @include('_partials.3-left-sidebar')
  <!-- Main Sidebar Container -->
<!--------------------------------------------------------- router-view----------------------------->
  <div class="content-wrapper">
    <div class="content">      
      <div class="container-fluid">           
      <router-view></router-view> 
      <!-- @yield('content') -->
      <!-- <vue-progress-bar></vue-progress-bar>         -->
      </div><!-- /.container-fluid -->
    </div>         
  </div>
<!------------------------------------------------------ /.content-wrapper -->


  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
 

 <!---->
<script src="/js/app.js"></script> 

<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!--
 <script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
-->


<!-- 
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/chart.js/Chart.min.js"></script>
-->


<!-- 
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/sparklines/sparkline.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
-->

<!--
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
-->


<!--
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/adminlte.js"></script>


-->


<!--
<script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/pages/dashboard.js"></script>	
<script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/demo.js"></script>
-->





</body>
</html>

