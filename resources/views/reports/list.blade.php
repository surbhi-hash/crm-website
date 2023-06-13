@extends("layouts.masterlayout")
@section('title','Upcoming Invoice')
@section('bodycontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Report</h1>
        </div>
        <div class="col-sm-6">

        </div><!-- /.col -->
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('report.list')}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="col-md-4 float-left">
                  <!-- Date and time -->
                  <div class="form-group">
                    <label>Select Range:</label>
                    <input name="dateRange" type="hidden" id="dateRange" value="2022-12-26@2022-12-26">
                    <div class="input-group">
                      <button type="button" class="btn btn-default float-right" id="reportrange">
                        <i class="far fa-calendar-alt"></i> <span></span>
                        <i class="fas fa-caret-down"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.form group -->
                </div>
                <div class="col-md-2 float-left">
                  <div class="form-group">
                    <label></label>
                    <button type="submit" name="search" style="margin-top:30px;" class="btn btn-primary mt-30">Report</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>No of Service</th>
                    <th>Amount</th>
                    

                  </tr>
                </thead>
                <tbody>
                  @isset($users)
                  @php $i = 1;$total=0; @endphp
                  @foreach($users as $user)
                  @php  $total+=intval($user->totalAmount); @endphp
                  @endforeach
                  @endisset
                  <tr>
                    <td>{{ $i }}</td>
                    <td>{{ count($users) }}</td>
                    <td>{{ $total }}</td>
                  </tr>
                  
                  </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

<script>
  < script >
    $(function() {

      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["csv"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



      $('#interactionForm').validate({
        rules: {

          _action: {
            required: true
          },
          _notes: {
            required: true
          },

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

    });
</script>