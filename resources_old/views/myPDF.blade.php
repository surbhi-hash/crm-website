<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Invoice!</title>

  <style type="text/css">
    * {
      font-family: Verdana, Arial, sans-serif;
    }

    table {
      font-size: x-small;
    }

    tfoot tr td {
      font-weight: bold;
      font-size: x-small;
    }

    .gray {
      background-color: lightgray
    }
  </style>

</head>

<body>
  @php $tot = $subtotal =0; @endphp
  @isset($invoiceData)
  @foreach ($invoiceData as $rws)

  <table width="100%">
    <tr>
      <td valign="top"><img src="https://themesforwebsite.com/work/crm/public/assets/dist/img/user1-128x128.jpg" alt="" width="150" /></td>
      <td align="right">
        <h3>Shinra Electric power company</h3>
        <pre>
                Company representative name
                Company address
                Tax ID
                phone
                fax
            </pre>
      </td>
    </tr>

  </table>

  <table width="100%">
    <tr>
      <td><strong>From:</strong>
        <address>
          <strong>Admin, Inc.</strong><br>
          795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (804) 123-5432<br>
          Email: info@almasaeedstudio.com
        </address>
      </td>
      <td><strong>To:</strong>
        <address>
          <strong>{{ $rws->full_name }}</strong><br>
          {{ $rws->street_number }}<br>
          {{ $rws->city }},{{ $rws->state }}-{{ $rws->postcode }}<br>
          Phone: {{ $rws->phone }}<br>
          Email: {{ $rws->email }}
        </address>
      </td>
    </tr>

  </table>

  <br />

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th width="20%">#</th>
        <th width="40%">Service</th>
        <th width="40%">Total $</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
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

    @php
    $subtotal= $rws->sprice+$tot;
    @endphp

    <tfoot>
      <tr>
        <td colspan="3"></td>
        <td align="right">Subtotal $</td>
        <td align="right">{{ $subtotal }}</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Tax $</td>
        <td align="right">@php $taxAmount = ($subtotal*93)/1000; @endphp {{ $taxAmount }}</td>
      </tr>

      <tr>
        <td colspan="3"></td>
        <td align="right">Advance Amount $</td>
        <td align="right">{{ $rws->paidAmount }}</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Total $</td>
        <td align="right" class="gray"> @php $totalAmount = ($subtotal+$taxAmount)-($rws->paidAmount);@endphp {{ $totalAmount; }}</td>
      </tr>
    </tfoot>
  </table>

  @endforeach
  @endisset

</body>

</html>