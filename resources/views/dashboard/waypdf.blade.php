<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
    .mmfont{
      font-family: 'Zawgyi_One';
    }

    .table-warning{
      background-color: #ffeeba;
    }
  </style>
</head>
<body>
  <h1>Ways of {{$data['deliveryman']->user->name}}</h1>
  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>No</th>
        <th>Item Cod</th>
        <th>Delivered Township</th>
        <th>Receiver Name</th>
        {{-- <th>Full Address</th>
        <th>Receiver Phone No</th> --}}
        <th>Item Price</th>
        <th>Deli Fees</th>
        <th>Other Charges</th>
        <th>Client</th>
      </tr>
    </thead>

    <tbody>
      @php $i=1; $total=0;@endphp
      @foreach($data["ways"] as $way)
        @php
          $allpaid = "";
          $payment_type = "";
          $total += $way->item->deposit+$way->item->delivery_fees;

          if ($way->item->paystatus==2) {
            $payment_type = "(allpaid)";
            $allpaid = "table-warning";
            $total -= $way->item->delivery_fees;
          }elseif ($way->item->paystatus==3) {
            $payment_type = "(only deli)";
          }elseif ($way->item->paystatus==4) {
            $total -= $way->item->delivery_fees;

            $payment_type = "(only item price)";
          }
        @endphp
        <tr class="{{$allpaid}}">
          <td>{{$i++}}</td>
          <td>
            {{$way->item->codeno}}{{$payment_type}}
          </td>
          @if($way->item->sender_gate_id != null)
          <td>{{$way->item->SenderGate->name}}</td>
        @elseif($way->item->sender_postoffice_id != null)
          <td> {{$way->item->SenderPostoffice->name}}</td>
        @else
         <td>{{$way->item->township->name}}</td>
        @endif
          <td>{{$way->item->receiver_name}}</td>
          {{-- <td>{{$way->item->receiver_address}}</td>
          <td>{{$way->item->receiver_phone_no}}</td> --}}
          <td>{{number_format($way->item->deposit)}}</td>
          <td>
          @if($way->item->paystatus == 2 || $way->item->paystatus == 4)
          {{0}}
          @else
          {{number_format($way->item->delivery_fees)}}
          @endif
          </td>
          
          <td>{{number_format($way->item->other_fees)}}</td>
          <td>
            {{$way->item->pickup->schedule->client->user->name}}<br>
            ({{$way->item->pickup->schedule->client->phone_no}})
          </td>
        </tr>
      @endforeach
        <tr>
          <td colspan="4">Total Amount</td>
          <td colspan="4">{{number_format($total)}} Ks</td>
        </tr>
    </tbody>
  </table>
</body>
</html>