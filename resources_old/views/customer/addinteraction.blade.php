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
          <h1>Add Interaction</h1>
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
              @isset($users)
              @php $i = 1; @endphp
              @foreach($users as $user)
              @php $uid = $user->id; @endphp
              <form action="{{ url('update-notes') }}" id="interactionForm" method="post">
                @csrf
                <input type="hidden" name="bid" value="{{ $user->bid }}">
                <input type="hidden" name="cid" value="{{ $user->id }}">
                <div class="modal-body">
                  <div class="col-sm-12">
                    <!-- select -->
                    <div class="form-group">
                      <label for="exampleInputText1">Service</label>
                      <input type="text" name="name" value="{{ $user->sname }}" disabled class="form-control" id="name" placeholder="Enter Name">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label for="exampleInputText1">Start Time</label>
                        <input type="text" name="name" value="{{ $user->sstart_date }}" disabled class="form-control" id="name" placeholder="Enter Name">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label for="exampleInputText1">End Time Time</label>
                        <input type="text" name="name" value="{{ $user->send_date }}" disabled class="form-control" id="name" placeholder="Enter Name">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- select -->
                    <div class="form-group">
                      <label>Select</label>
                      <select class="form-control select2 " name="_action" id="_action" required>
                        <option value="">Select</option>
                        @foreach(status() as $key=>$val)
                        @if($val!='pending')
                        <option value="{{$val}}">{{$key}}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- select -->
                    <div class="form-group">
                      <label>Internal Notes</label>
                      <textarea class="form-control" rows="3" name="internal_note" disabled id="internal_note" requried="" placeholder="Enter ...">{{$user->internal_note}}</textarea>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- select -->
                    <div class="form-group">
                      <label>Notes</label>
                      <textarea required class="form-control" rows="3" name="notes" id="_notes" requried="" placeholder="Enter ...">{{$user->notes}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            </form>
            @php $i++; @endphp
            @endforeach
            @endisset


            <section class="content">
              <div class="container-fluid">

                <!-- Timelime example  -->
                <div class="row">
                  <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
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