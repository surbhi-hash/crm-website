<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <style>
    @font-face {
      font-family: SourceSansPro;
      src: url(SourceSansPro-Regular.ttf);
    }

    .clearfix:after {
      content: "";
      display: table;
      clear: both;
    }

    a {
      color: #0087C3;
      text-decoration: none;
    }

    body {
      position: relative;
      margin: 0 auto;
      color: #555555;
      background: #FFFFFF;
      font-family: Arial, sans-serif;
      font-size: 14px;
      font-family: SourceSansPro;
    }

    header {
      padding: 10px 0;
      margin-bottom: 20px;
      border-bottom: 1px solid #AAAAAA;
    }

    #logo {
      float: left;
      margin-top: 8px;
    }

    #logo img {
      height: 70px;
    }

    #company {
      float: right;
      text-align: right;
    }


    #details {
      margin-bottom: 50px;
    }

    #client {
      padding-left: 6px;
      border-left: 6px solid #0087C3;
      float: left;
    }

    #client .to {
      color: #777777;
    }

    h2.name {
      font-size: 1.4em;
      font-weight: normal;
      margin: 0;
    }

    #invoice {
      float: right;
      text-align: right;
    }

    #invoice h1 {
      color: #0087C3;
      font-size: 1.4em;
      line-height: 1em;
      font-weight: normal;
      margin: 0 0 10px 0;
    }

    #invoice .date {
      font-size: 1.1em;
      color: #777777;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table th,
    table td {
      /*padding: 20px;*/
      padding: 2px 5px;
      background: #EEEEEE;
      text-align: right;
      border-bottom: 1px solid #FFFFFF;
    }

    table th {
      white-space: nowrap;
      font-weight: normal;
    }

    table td {
      text-align: right;
    }

    table td h3 {
      color: #57B223;
      font-size: 1.2em;
      font-weight: normal;
      margin: 0 0 0.2em 0;
    }

    table .no {
      color: #FFFFFF;
      font-size: 1.2em;
      background: #57B223;
    }

    table .desc {
      text-align: left;
    }

    table .unit {
      background: #DDDDDD;
    }

    table .qty {}

    table .total {
      background: #57B223;
      color: #FFFFFF;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table tbody tr:last-child td {
      border: none;
    }

    table tfoot td {
      padding: 10px 20px;
      background: #FFFFFF;
      border-bottom: none;
      font-size: 1.2em;
      white-space: nowrap;
      border-top: 1px solid #AAAAAA;
    }

    table tfoot tr:first-child td {
      border-top: none;
    }

    table tfoot tr:last-child td {
      color: #57B223;
      font-size: 1.4em;
      border-top: 1px solid #57B223;

    }

    table tfoot tr td:first-child {
      border: none;
    }

    #thanks {
      font-size: 2em;
      margin-bottom: 50px;
    }

    #notices {
      padding-left: 6px;
      border-left: 6px solid #0087C3;
    }

    #notices .notice {
      font-size: 1.2em;
    }

    #logoPaid {
      text-align: center;
      height: 70px;
    }

    footer {
      color: #777777;
      width: 100%;
      height: 30px;
      position: absolute;
      bottom: 0;
      border-top: 1px solid #AAAAAA;
      padding: 8px 0;
      text-align: center;
    }
  </style>
</head>

<body>
  @php $tot = $subtotal =0; @endphp
  @isset($invoiceData)
  @foreach ($invoiceData as $rws)
  <header class="clearfix">
    <div id="logo">
      <img src="https://www.pestcityusa.com/wp-content/uploads/2021/01/PestCityLogo.png">
    </div>
    <div id="company">
      <h2 class="name">Pest City USA</h2>
      <div>18665 West 8 mile, Detroit MI, US</div>
      <div> +1-248-7912209</div>
      <div><a href="mailto:info@pestcityusa.com">info@pestcityusa.com</a></div>
    </div>
    </div>
  </header>
  <main>
    <div id="details" class="clearfix">
      <div id="client">
        <div class="to">INVOICE TO:</div>
        <h2 class="name">{{ $rws->full_name }}</h2>
        <div class="address">{{ $rws->street_number }}, {{ $rws->city }},{{ $rws->state }}-{{ $rws->postcode }}</div>
        <div class="email">Phone:{{ $rws->phone }}</div>
        <div class="email">Email:<a href="mailto:{{ $rws->email }}">{{ $rws->email }}</a></div>
      </div>
      <div id="invoice">
        <h1>INVOICE #00{{$rws->bid}}</h1>
        <div class="date">Date of Invoice: {{date('m/d/Y',strtotime( $rws->invoice_date))}}</div>
        @if($rws->paymentType!='Cash')<div class="date">Due Date: {{date('m/d/Y',strtotime( $rws->invoice_date.' + 30 days'))}}</div>@endif
      </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th class="no">#</th>
          <th class="desc">SERVICES</th>
          <th class="total">TOTAL</th>
        </tr>
      </thead>
      <tbody>

        @isset($extraService)
        @php $k="2"; @endphp
        @foreach($extraService as $exs)
        @php
        $tot+= $exs->price;
        @endphp
        <tr>
          <td class="no">{{$k}}</td>
          <td class="desc">
            <h3>{{ $exs->service_name }}</h3>
          </td>
          <td class="total">${{ $exs->price  }}</td>
        </tr>
        @php $k++; @endphp
        @endforeach
        @endisset

        @php
              $subtotal1= $tot;
             
             
              @endphp

      </tbody>
      <tfoot>
        <tr>

          <td colspan="2">Subtotal</td>
          <td>${{$subtotal1}}</td>
        </tr>

        <tr>
          <td colspan="2">Advance:</td>
          <td>$0.00</td>
        </tr>
        @if($rws->paymentType!='Cash')
        <td colspan="2">Amount to be Paid</td>
        <td>${{ $subtotal1 }}</td>
        @else
         <td colspan="2">Collected Amount</td>
        <td>${{ $subtotal1 }}</td>
         @endif
        </tr>
        @if($rws->paymentType!='Cash')
        <tr>
          <td colspan="2">Transactions Fee (3.5%)</td>
          <td>$@php $taxAmount = ($subtotal1 * 35)/1000; @endphp {{ $taxAmount }}</td>
        </tr>
        @else
        @php $taxAmount = 0; @endphp
        @endif
        <tr>

          <td colspan="2">GRAND TOTAL</td>
          <td>  $ @php $totalAmount = ($taxAmount)+($subtotal1);@endphp
        {{ $totalAmount }}</td>
        </tr>
      </tfoot>
    </table>
    <div id="thanks">Thank you!</div>
    <div id="notices" style="display:none;">
      <div>NOTICE:</div>
      <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
    @if($rws->paymentType=='Cash')
    <div id="logoPaid">
      <img src="https://portal.pestcityusa.com/img/paid-removebg.png" width="150px" height="150px">
    </div>
    @endif
  </main>
  <footer>
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>
  @endforeach
  @endisset
</body>

</html>