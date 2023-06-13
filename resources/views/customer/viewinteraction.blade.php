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
                    <h1>View Interaction</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-success float-right" href="{{ url()->previous() }}" role="button">Back</a>
                </div>
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



                            <section class="content">
                                <div class="container-fluid">

                                    <!-- Timelime example  -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- The time line -->
                                            <div class="timeline">
                                                @if(sizeof($interaction)>0)
                                                @foreach($interaction as $inter)
                                                @php $time = date('d M, Y',strtotime($inter->created_at));@endphp
                                                <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span class="bg-red"> {{$time }}</span>
                                                </div>
                                                <!-- /.timeline-label -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-envelope bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header"><a href="#">{{$inter->status}}</a></h3>
                                                        <div class="timeline-body">
                                                            {{$inter->remarks}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                                @endforeach
                                                @else
                                                No Interaction Found.
                                                @endif
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                                <!-- /.timeline -->

                            </section>




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