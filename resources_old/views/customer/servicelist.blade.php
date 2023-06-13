@extends("layouts.masterlayout")
@section('title','Service List')
@section('bodycontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Service List</h1>
          </div>
          <div class="col-sm-6">
            <a class="btn btn-success float-right" href="{{ url()->previous() }}" role="button">Back</a>
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
                    <th>Service Name</th>
                    <th>Start Service</th>
                    <th>End Service</th>
                    <th>Technician</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                   @isset($users) 
                   @php $i = 1; @endphp
                   @foreach($users as $user)
                   @php $uid = $user->id; @endphp
                  <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $user->title }}</td>
                    <td>{{ $user->start_date }}</td>
                    <td>{{ $user->end_date }}</td>
                    <td>{{ $user->full_name }}</td>
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