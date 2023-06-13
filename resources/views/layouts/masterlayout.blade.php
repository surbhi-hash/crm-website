<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield("title") | CRM</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- jsGrid -->
  <link rel="stylesheet" href="{{asset('assets/plugins/jsgrid/jsgrid.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/jsgrid/jsgrid-theme.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
   <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
</head>

<body class=" sidebar-mini layout-fixed text-sm ">
  <div class="wrapper">

    <!-- Preloader 
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{% static 'dist/img/AdminLTELogo.png' %}" alt="AdminLTELogo" height="60" width="60">
  </div>-->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('clear') }}" class="nav-link">Clear Cache</a>
        </li>


      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>



        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>


        <li class="nav-item">

          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
              <i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}
            </a>
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ url('dashboard') }}" class="brand-link">
        <img src="{{asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CMS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('assets/dist/img/user1-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"> {{ Auth::user()->name }} <!-- : {{ Auth::user()->role }} --></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


            @if(Auth::user()->role=='1')
            <li class="nav-item ">
              <a href="{{ url('dashboard') }}" class="nav-link @php echo (request()->segment(1)=='dashboard')?'active':'' @endphp ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>



            <li class="nav-item">
              <a href="{{ url('interaction-list') }}" class="nav-link @php echo (request()->segment(1)=='interaction-list')?'active':'' @endphp">
                <i class="nav-icon fas fa-hands-helping"></i>
                <p>
                  Contact Management
                </p>
              </a>
            </li>
            
         

            <li class="nav-item @php echo (request()->segment(1)=='interaction')?'menu-open':'' @endphp">
              <a href="{{ url('customers-list') }}" class="nav-link ">
                <i class="nav-icon fas fa-microchip"></i>
                <p>
                  Interaction Tracking
                </p>
              </a>
            </li>



            <li class="nav-item d-none">
              <a href="{{ url('leads') }}" class="nav-link @php echo (request()->segment(1)=='leads')?'active':'' @endphp">
                <i class="nav-icon fas fa-file-export"></i>
                <p>
                  Lead Management
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ url('email') }}" class="nav-link @php echo (request()->segment(1)=='email')?'active':'' @endphp">
                <i class="nav-icon fas fa-envelope"></i>
                <p>
                  Email Integration
                </p>
              </a>
            </li>


            <li class="nav-item @php echo (request()->segment(1)=='upcoming-invoice')?'menu-is-opening menu-open':'' @endphp @php echo (request()->segment(1)=='create-invoice')?'menu-is-opening menu-open':'' @endphp ">
              <a href="#" class="nav-link @php echo (request()->segment(1)=='upcoming-invoice')?'active':'' @endphp @php echo (request()->segment(1)=='create-invoice')?'active':'' @endphp">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Invoice Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                  <a href="{{ url('upcoming-invoice') }}" class="nav-link @php echo (request()->segment(1)=='upcoming-invoice')?'active':'' @endphp">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Upcoming Invoice</p>
                  </a>
                </li>
                <!--<li class="nav-item">-->
                <!--<a href="{{ url('create-invoice') }}" class="nav-link @php echo (request()->segment(1)=='create-invoice')?'active':'' @endphp">-->
                <!--<i class="far fa-circle nav-icon"></i>-->
                <!--<p>Create Invoice</p>-->
                <!--</a>-->
                <!--</li>-->

              </ul>
            </li>

            <li class="nav-item">
              <a href="{{ url('users') }}" class="nav-link @php echo (request()->segment(1)=='users')?'active':'' @endphp">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>
                  Users
                </p>
              </a>
            </li>









            @elseif(Auth::user()->role=='2')

            <li class="nav-item @php echo (request()->segment(1)=='dashboard')?'menu-open':'' @endphp">
              <a href="{{ url('dashboard') }}" class="nav-link @php echo (request()->segment(1)=='dashboard')?'active':'' @endphp ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <li class="nav-item @php echo (request()->segment(1)=='interaction-list')?'menu-open':'' @endphp">
              <a href="{{ route('interaction') }}" class="nav-link @php echo (request()->segment(1)=='interaction-list')?'active':'' @endphp">
                <i class="nav-icon fas fa-hands-helping"></i>
                <p>
                  Contact Management
                </p>
              </a>
            </li>

            <li class="nav-item @php echo (request()->segment(1)=='interaction')?'menu-open':'' @endphp d-none">
              <a href="{{ route('customers') }}" class="nav-link @php echo (request()->segment(1)=='customers-list')?'active':'' @endphp">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Interaction Tracking
                </p>
              </a>
            </li>

            <li class="nav-item @php echo (request()->segment(1)=='leads-list')?'menu-open':'' @endphp">
              <a href="{{ route('leads.list') }}" class="nav-link @php echo (request()->segment(1)=='leads-list')?'active':'' @endphp">
                <i class="nav-icon fas fa-file-export"></i>
                <p>
                  Lead management({{leadCount()}})
                </p>
              </a>
            </li>
            <li class="nav-item @php echo (request()->segment(1)=='invoice')?'menu-open':'' @endphp">
              <a href="{{ route('invoice.list') }}" class="nav-link @php echo (request()->segment(1)=='invoice-list')?'active':'' @endphp">
                <i class="nav-icon fas fa-database"></i>
                <p>
                  Invoice management({{invoiceCount()}})
                </p>
              </a>
            </li>
            <li class="nav-item @php echo (request()->segment(1)=='billing-list')?'menu-open':'' @endphp">
              <a href="{{ route('billing.list') }}" class="nav-link @php echo (request()->segment(1)=='billing-list')?'active':'' @endphp">
                <i class="nav-icon fas fa-bookmark"></i>
                <p>
                  Billing management
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('report.list') }}" class="nav-link @php echo (request()->segment(1)=='report')?'active':'' @endphp">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Reporting
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('custom.invoice')}}" class="nav-link @php echo (request()->segment(1)=='custom-invoice')?'active':'' @endphp">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Custom Invoice
                </p>
              </a>
            </li>

            @endif
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>



    @section('bodycontent')
    @show



    <footer class="main-footer">
      <strong>Copyright &copy; 2021-@php echo date('Y');@endphp <a href="https://thinkersmedia.in/" target="_blank">Thinkers Media.</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    
    
    
    
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Select2 -->
  <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
  <!-- SweetAlert2 -->
  <script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <!-- Toastr -->
  <script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('assets/plugins/sparklines/sparkline.js')}}"></script>
  <!-- JQVMap -->
  <script src="{{asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- jsGrid -->
  <script src="{{asset('assets/plugins/jsgrid/demos/db.js')}}"></script>
  <script src="{{asset('assets/plugins/jsgrid/jsgrid.min.js')}}"></script>
  <!-- DataTables  & Plugins -->
  <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

  <!-- Bootstrap4 Duallistbox -->
  <script src="{{asset('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- jquery-validation -->
  <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery-validation/additional-methods.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
  
  
  <!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <script>
    $(function() {

      $(".add-moreR").click(function() {
        var html2 = $(".copy").html();
        //alert(html2);
        $("#addHTM").append(html2);
      });

      $("body").on("click", ".remove", function() {
        $(this).parents("#rowRemove").remove();
      });


      $('#compose-textarea').summernote();

      var start = moment().subtract(0, 'days');
      var end = moment();

      function cb(start, end) {
        // alert(start)
        //alert(end)
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#dateRange').val(start.format('YYYY-MM-DD') + '@' + end.format('YYYY-MM-DD'));
      }

      $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      }, cb);

      cb(start, end);

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["csv"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



      $('#quickForm').validate({
        rules: {

          name: {
            required: true
          },
          email: {
            required: true,
            email: true,
          },
          mobile: {
            minlength: 10,
            maxlength: 10,
            number: true
          },
          user_type: {
            required: true
          },
          password: {
            required: true,
            minlength: 5
          },
          conf_password: {
            required: true,
            minlength: 5,
            equalTo: "#password"
          }

        },
        messages: {
          email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
          },
          mobile: {
            required: "Please enter a mobile no",
            mobile: "Please enter a vaild mobile no"
          },

          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          },
          conf_password: "Please provide a same password"
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });




      @if(Session::has('message'))
      var type = "{{ Session::get('alert-type','info')}}";
      switch (type) {
        case 'info':
          toastr.info("{{ Session::get('message') }}");
          break;
        case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;
        case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;
        case 'error':
          toastr.error("{{ Session::get('message') }}");
          break;
      }
      @endif
    });
  </script>
</body>

</html>