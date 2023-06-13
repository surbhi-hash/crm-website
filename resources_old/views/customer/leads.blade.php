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
          <h1>Leads Management</h1>
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
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Service Name</th>
                    <th>Technician</th>
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
                    <td>{{ $user->street_number }},<br>{{ $user->additional_address }},<br>{{ $user->street }},<br>{{ $user->city }},<br>{{ $user->state }}-{{ $user->postcode }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->sname }}</td>
                    <td>{{ $user->staffname }}</td>
                    <td>

                      <button type="button" data-id="14" class="btn btn-default" data-toggle="modal" data-target="#modal-{{ $i }}">
                        <i class="fas fa-eye"></i>
                      </button>

                      <div class="modal fade" id="modal-{{ $i }}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Action</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{ url('update-notes') }}" id="interactionForm" method="post">
                              @csrf
                              <input type="hidden" name="bid" value="{{ $user->bid }}">
                              <div class="modal-body">
                                <div class="col-sm-12">
                                  <!-- select -->
                                  <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="_action" id="_action" requried="">
                                      <option value="">Select</option>
                                      @foeach(status() as $key=>$val)
                                      <option value="{{$key}}">{{$val}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                  <!-- select -->
                                  <div class="form-group">
                                    <label>Notes</label>
                                    <textarea class="form-control" rows="3" name="notes" id="_notes" requried="" placeholder="Enter ..."></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                          </div>
                          </form>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->
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