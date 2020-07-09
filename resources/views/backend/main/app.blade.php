<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <meta name="description" content="Library HTML Template">
  <meta name="keywords" content="industry, html">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{URL::to('/')}}/favicon.ico" rel="shortcut icon"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::to('/')}}/backend/css/all.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/backend/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{URL::to('/')}}/backend/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/backend/css/toastr.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/backend/css/style.back.css">
  @yield('style')
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    @include('backend.main.header')
    @include('backend.main.sidebar')
    @yield('content')
    @include('backend.main.footer')
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <script src="{{URL::to('/')}}/backend/js/jquery.min.js"></script>
  <script src="{{URL::to('/')}}/backend/js/bootstrap.bundle.min.js"></script>
  <script src="{{URL::to('/')}}/backend/plugins/pace-progress/pace.min.js"></script>
  <script src="{{URL::to('/')}}/backend/js/adminlte.js"></script>

  <!-- sidebarcontrol -->
  <script src="{{URL::to('/')}}/backend/js/demo.js"></script>
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <script src="{{URL::to('/')}}/backend/js/toastr.min.js"></script>
  <script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
     case 'info':
     toastr.info("{{ Session::get('message') }}");
     break;

     case 'warning':
     toastr.warning("{{ Session::get('message') }}");
     break;

     case 'success':
     toastr.success("{{ Session::get('message') }}");
     break;

     case 'error':
     toastr.error("{{ Session::get('message') }}");
     break;
   }
   @endif
 </script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script>
   $('.delete-confirm').on('click', function (e) {
     event.preventDefault();
     const url = $(this).attr('href');
     swal({
       title: 'Are you sure?',
       text: 'This record and it`s details will be permanantly deleted!',
       icon: 'warning',
       buttons: ["Cancel", "Yes!"],
       dangerMode: true,
       closeOnClickOutside: false,
     }).then(function(value) {
       if (value) {
        swal("Done! Data has been deleted!", {
          icon: "success",
        });
        window.location.href = url;
      }
      else {
       swal("Your data  is safe!");
     }
    });
   });
 </script> 
@yield('javascript')
</body>
</html>


