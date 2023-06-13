@extends("layouts.masterlayout")
@section('title','Customer List')
@section('bodycontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Customer List</h1>
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
                    <th>Service Request</th>

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
                    <td>
                      <?php if (is_null(Auth::user()->userId)) { ?>
                        <a href="{{ url('interaction/show/')}}/{{ $user->bid }}"><button type="button" data-id="14" class="btn btn-default">
                            <i class="fas fa-eye"></i>
                          </button></i></a>
                      <?php } else { ?>

                        <a href="{{ url('interaction/view/')}}/{{ $user->bid }}"><button type="button" data-id="14" class="btn btn-default">
                            <i class="fas fa-eye"></i>
                          </button></i></a>

                      <?php } ?>


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
<script>
  $(function() {
    $('.select2').select2();
  });
</script>
@endsection