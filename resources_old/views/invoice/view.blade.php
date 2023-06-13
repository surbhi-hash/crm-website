@extends("layouts.masterlayout")
@section('title','Invoice')
@section('bodycontent')
<div class="content-wrapper" style="min-height: 2646.44px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Invoice</h1>
        </div>


        <div class="col-sm-6">
          <a class="btn btn-success float-right" href="{{ url()->previous() }}" role="button">Back</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>




  @php $tot = $subtotal =0; @endphp
  @if(count($errors) > 0)
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
    @foreach( $errors->all() as $message )
    {{ $message }}<br />
    @endforeach
  </div>
  @endif



  @isset($invoiceData)
  @foreach ($invoiceData as $rws)

  @php

  if(empty($rws->paidAmount)){

  $paidAmount = "0.00";

  }else{

  $paidAmount = $rws->paidAmount;

  }

  @endphp

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">



          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> Thinkers Media, Inc.
                  <small class="float-right">Date: 2/10/2022</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong>Admin, Inc.</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (804) 123-5432<br>
                  Email: info@almasaeedstudio.com
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                To
                <address>
                  <strong>{{ $rws->full_name }}</strong><br>
                  {{ $rws->street_number }}<br>
                  {{ $rws->city }},{{ $rws->state }}-{{ $rws->postcode }}<br>
                  Phone: {{ $rws->phone }}<br>
                  Email: {{ $rws->email }}
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice #00{{ $rws->bid }}</b><br>
                <br>
                <b>Order ID:</b> {{ $rws->bid }}<br>
                <b>Payment Due:</b> 2/22/2014<br>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped" id="serviceAdd">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Service</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>#</td>
                      <td>{{ $rws->sname }}</td>
                      <td>${{ $rws->sprice }}</td>
                    </tr>
                    @isset($extraService)

                    @foreach($extraService as $exs)
                    @php
                    $tot+= $exs->price;
                    @endphp
                    <tr>
                      <td>#</td>
                      <td>{{ $exs->service_name }}</td>
                      <td>${{ $exs->price  }}</td>
                    </tr>
                    @endforeach
                    @endisset
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead">Payment Methods:</p>
                <img src="{{asset('assets/dist/img/credit/visa.png')}}" alt="Visa">
                <img src="{{asset('assets/dist/img/credit/mastercard.png')}}" alt="Mastercard">
                <img src="{{asset('assets/dist/img/credit/american-express.png')}}" alt="American Express">
                <img src="{{asset('assets/dist/img/credit/paypal2.png')}}" alt="Paypal">

                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                </p>
                <button type="button" class="btn btn btn-success " data-toggle="modal" data-target="#modal-xl">
                  Add More Service
                </button>
              </div>

              @php
              $subtotal= $rws->sprice+$tot;
              @endphp
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>${{ $subtotal }}</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$@php $taxAmount = ($subtotal*93)/1000; @endphp {{ $taxAmount }}</td>
                      </tr>
                      <tr>
                        <th>Advance Amount:</th>
                        <td>-${{ $paidAmount }}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$@php $totalAmount = ($subtotal+$taxAmount)-($paidAmount);@endphp {{ $totalAmount; }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->


            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->


            @if(empty($rws->inVoice))

            <!-- <form id="quickForm" action="{{ url('invoice-store') }}" method="post">
              @csrf
              <input type="hidden" name="nid" value="{{ $rws->bid }}">
              <div class="row no-print">

                <div class="col-4 float-right">
                  <p class="lead">Collected Amount:</p>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="paidAmount" requried class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">.00</span>
                    </div>
                  </div>

                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>

            </form> -->

            @endif


            @if(empty($rws->inVoice))
            <form action="{{ url('invoice-generate') }}" method="post">
              @csrf
              <input type="hidden" name="nid" value="{{ $rws->bid }}">
              <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate Invoice
              </button>
            </form>
            @else
            <a target="_blank" href="{{ url('invoice/') }}/{{$rws->inVoice}}.pdf" class="btn btn-primary float-right" style="margin-right: 5px;">
              <i class="fas fa-download"></i> Download Invoice
            </a>

            @endif
          </div>
        </div>

      </div>
      <!-- /.invoice -->
    </div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endforeach
@endisset
</div>


<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Extra Service</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary" style="display:none">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <div class="card-body">

                <div class="row copy">
                  <div class="row" id="rowRemove">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Service Name</label>
                        <select required class="form-control select2" name="service[]" id="service" style="width: 100%;">
                          <option value="">Please select</option>
                          @foreach(servicesList() as $sr)
                          <option value="{{$sr}}">{{$sr}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Price</label>
                        <input required type="number" name="price[]" id="price" class="form-control" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea required class="form-control" name="desc[]" id="desc" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group-btn">
                        <button class="btn btn-danger remove" style="margin-top: 30px;" type="button"><i class="fas fa-minus-circle"></i></button>
                      </div>
                    </div>

                  </div>



                </div>
              </div>
            </div>
            <form name="serviceAdd" method="post" action="{{route('service.add')}}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="bid" value="{{ $rws->bid }}" />
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  <button type="button" class="btn btn-success  add-moreR">Add Service</button>
                  <div id="addHTM">
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Upload File</label>
                        <input type="file" name="docs_upload" id="docs_upload" class="form-control">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="col-4">
                        <p class="lead">Collected Amount:</p>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="number" name="paidAmount" requried class="form-control">
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
          </div>
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>


    @endsection