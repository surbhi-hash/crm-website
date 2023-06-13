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
                  <img src="https://www.pestcityusa.com/wp-content/uploads/2021/01/PestCityLogo.png" width="75" height="75" />

                  @php
                  $createdAt= date('m/d/Y', strtotime($rws->updated_at));
                  @endphp

                  <small class="float-right">Date: {{ $createdAt }}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong>Pest City USA.</strong><br>
                  18665 West 8 mile <br>
                  Detroit MI<br>
                  Phone: +1-248-7912209<br>
                  Email: info@pestcityusa.com
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
                <b>Payment Due:</b> {{$createdAt}}<br>
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
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>

                    @isset($extraService)

                    @foreach($extraService as $exs)
                    @php
                    $tot+= $exs->price;
                    @endphp
                    <tr>
                      <td>#</td>
                      <td>{{ $exs->service_name }}</td>
                      <td>${{ $exs->price  }}</td>
                      <td> <a href="{{route('extra-service-delete',$exs->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                      </td>
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
                @if(empty($rws->inVoice))
                <button type="button" class="btn btn btn-success " data-toggle="modal" data-target="#modal-xl">
                  Services & payment
                </button>
                @endif
              </div>

              @php
              $subtotal1= $rws->sprice+$tot;
              $subtotal1= $tot;
              $paidAmount= $subtotal1-$rws->pm_paid;
              @endphp
              <!-- /.col -->

              @if($rws->pm_type=='local')
              <div class="col-6">
                <p class="lead">Amount Due {{$createdAt}} (@if($rws->paymentType=='Cash') Cash @else Online @endif)</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>${{ $subtotal1 }}</td>
                      </tr>

                      @if($rws->paymentType!='Cash')
                      @php $collect='Amount to be Paid'; @endphp
                      @else
                      @php $collect='Collected Amount';@endphp
                      @endif



                      <tr>
                        <th>Advance:</th>
                        <td>${{ $rws->pm_paid }}</td>
                      </tr>
                      <tr>
                        <th>{{$collect}}:</th>
                        <td>${{ $paidAmount }}</td>
                      </tr>
                      @if($rws->paymentType!='Cash')
                      <tr>
                        <th>Transactions Fee (3.5%)</th>
                        <td>$@php $taxAmount = ($paidAmount*35)/1000; @endphp {{ $taxAmount }}</td>
                      </tr>
                      @else
                      @php $taxAmount = 0; @endphp
                      @endif
                      <tr>
                        <th>Total:</th>
                        <td>$@php $totalAmount = ($taxAmount)+($paidAmount);@endphp {{ $totalAmount; }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->

              @elseif($rws->pm_type=='paypal')

              <div class="col-6">
                <p class="lead">Amount Due {{$createdAt}} (@if($rws->paymentType=='Cash') Cash @else Online @endif)</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>${{ $subtotal }}</td>
                      </tr>

                      @if($rws->paymentType!='Cash')
                      @php $collect='Amount to be Paid'; @endphp
                      @else
                      @php $collect='Collected Amount';@endphp
                      @endif



                      <tr>
                        <th>Advance:</th>
                        <td>${{ $rws->pm_paid }}</td>
                      </tr>
                      <tr>
                        <th>{{$collect}}:</th>
                        <td>${{ $paidAmount }}</td>
                      </tr>
                      @if($rws->paymentType!='Cash')
                      <tr>
                        <th>Transactions Fee (3.5%)</th>
                        <td>$@php $taxAmount = ($subtotal*35)/1000; @endphp {{ $taxAmount }}</td>
                      </tr>
                      @else
                      @php $taxAmount = 0; @endphp
                      @endif
                      <tr>
                        <th>Total:</th>
                        <td>$@php $totalAmount = ($taxAmount+$rws->pm_paid)+($paidAmount);@endphp{{ $totalAmount; }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->

              @else

              dfdf

              @endif


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
              <input type="hidden" name="subtotal" value="{{ $subtotal }}" />
              <input type="hidden" name="taxAmount" value="{{ $taxAmount }}" />
              <input type="hidden" name="paidAmount" value="{{ $paidAmount }}" />
              <input type="hidden" name="totalAmount" value="{{ $totalAmount }}" />
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
                    <div class="col-md-12">

                      <div class="card card-primary card-outline">
                        <div class="card-header">
                          <h6 class="card-title bold"></h6>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-9">

                              <label for="exampleInputEmail1">Payment Type</label>
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><input type="radio" name="paymentType" id="payment1" value="Online" checked></span>
                                    </div>
                                    <input type="text" class="form-control" disabled placeholder="Online">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><input type="radio" name="paymentType" id="payment2" value="Cash"></span>
                                    </div>
                                    <input type="text" class="form-control" disabled placeholder="Cash">
                                  </div>
                                </div>
                              </div>
                            </div>


                            <div class="col-sm-3 d-none ">
                              <div class="form-group">
                                <label for="exampleInputText1">Collected Amount:</label>
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
              </div>
          </div>
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>


    @endsection