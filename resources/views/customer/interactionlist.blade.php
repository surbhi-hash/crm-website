@extends("layouts.masterlayout")
@section('title','Interaction List')
@section('bodycontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Interaction List</h1>
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
        <div class="col-12">
          <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Service Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Technician</th>
                    <th>Invoice</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  @isset($users)
                  @php $i = 1; @endphp
                  @foreach($users as $user)
                  @php $uid = $user->id; @endphp
                  <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->street_number }},<br>{{ $user->additional_address }},<br>{{ $user->street }},<br>{{ $user->city }},<br>{{ $user->state }}-{{ $user->postcode }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->sname }}</td>
                    <td>{{ $user->sstart_date }}</td>
                    <td>{{ $user->send_date }}</td>
                    <td>{{ $user->staffname }}</td>
                    <td>
                    </td>
                    <td><a class="btn btn-default userinfo" href="{{ route('customers')}}/{{$uid}}">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                  @php $i++; @endphp
                  @endforeach
                  @endisset
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