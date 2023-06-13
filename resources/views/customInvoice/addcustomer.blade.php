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
          @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
 
   
  {{session('success')}} 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif






          <form id="quickForm" action="{{route('custom.invoice.store')}}" method="post">
          @csrf
            <div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Customer First Name <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="customer_fname" value="" class="form-control" id="name" placeholder="Enter customer name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Customer Last Name <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="customer_lname" value="" class="form-control" id="name" placeholder="Enter customer name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email Id <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="email" name="email" value="" class="form-control" id="email" placeholder="Enter Email Id" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="phone" value="" class="form-control" id="mobile" placeholder="Enter Mobile Number" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Address <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="street_number" value="" class="form-control" id="address" placeholder="Enter address" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">City <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="city" value="" class="form-control" id="address" placeholder="Enter city" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">State <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="state" value="" class="form-control" id="address" placeholder="Enter state" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Postcode <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="postcode" value="" class="form-control" id="address" placeholder="Enter postcode" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Source <span style="color:#FF0000;font-size:18px;" >*</span></label>
                  <input type="text" name="source" value="" class="form-control" id="address" placeholder="Please enter the source from where these customers came" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Notes </label>
                  <textarea  name="notes" value="" class="form-control" id="address" ></textarea>
                </div>
              </div>
              
             

             
              <div class="col-md-12">
                <button type="submit"  class="btn btn-primary float-right">Create customer</button>
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