@extends("layouts.masterlayout")
@section('title','Dashboard')
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
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">


          @isset($completed)
          @foreach($completed as $cm)


          @if($cm->status=="approved")
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$cm->total}}</h3>

                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a  class="small-box-footer">Completed </a>
            </div>
          </div>
          <!-- ./col -->
          @endif

           
           @if($cm->status=="pending")
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$cm->total}}</h3>

                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a class="small-box-footer">Pending</a>
            </div>
          </div>
           @endif


           @if($cm->status=="cancelled")
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box  bg-danger">
              <div class="inner">
                 <h3>{{$cm->total}}</h3>

                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a  class="small-box-footer">Cancelled </a>
            </div>
          </div>
          <!-- ./col -->
           @endif


           @if($cm->status=="rejected")
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                 <h3>{{$cm->total}}</h3>

                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a  class="small-box-footer">Rejected </a>
            </div>
          </div>
          <!-- ./col -->
           @endif

           @endforeach
          @endisset


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$customer}}</h3>

                <p></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a  class="small-box-footer">Customer </a>
            </div>
          </div>
          <!-- ./col -->
        


         
           
          <!-- ./col -->




        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection