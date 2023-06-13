@extends("layouts.masterlayout")
@section('title','Users List')
@section('bodycontent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->





  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- SELECT2 EXAMPLE -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          @if(count($errors) > 0)
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            @foreach( $errors->all() as $message )
            {{ $message }}<br />
            @endforeach
          </div>
          @endif







          <form id="quickForm" action="{{ url('users-store') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">User Id</label>
                  <input type="text" name="userId" value="" class="form-control" id="userId" placeholder="Enter User Id" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Your Name</label>
                  <input type="text" name="name" value="" class="form-control" id="name" placeholder="Enter Your Name" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number</label>
                  <input type="text" name="mobile" value="" class="form-control" id="mobile" placeholder="Enter Mobile Number" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email Id</label>
                  <input type="email" name="email" value="" class="form-control" id="email" placeholder="Enter Email Id">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>User Role</label>
                  <select name="role" id="user_type" class="form-control select2" style="width: 100%;" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin </option>
                    <option value="2">Technician</option>
                  </select>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" name="password" value="" class="form-control" id="password" placeholder="Password" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm Password</label>
                  <input type="password" name="conf_password" value="" id="conf_password" class="form-control" placeholder="Confirm Password" required>
                </div>

              </div>
              <div class="col-md-12">
                <button type="submit" name="signupSubmit" value="CREATE ACCOUNT" class="btn btn-primary float-right">Create User</button>
              </div>
            </div>
          </form>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->


    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection