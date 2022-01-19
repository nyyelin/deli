<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
  <body>
  	<h1>Ways of {{$data['deliveryman']->user->name}}</h1>
  	<table border="1" cellpadding="5px">
      <thead>
        <tr>
        	<th>No</th>
          <th>Item Cod</th>
          <th>Delivered Township</th>
          <th>Receiver Name</th>
          <th>Item Price</th>
          <th>Deli Fees</th>
          <th>Other Charges</th>
          <th>Client</th>
        </tr>
      </thead>

      <tbody>
        @php $i=1; @endphp
        @foreach($data["ways"] as $way)
        <tr>
         	<td>{{$i++}}</td>
         	<td>
            {{$way->item->codeno}}
            @if($way->item->paystatus==2)
              <span>{{'(Allpaid)'}}</span>
            @endif
          </td>
         	@if($way->item->sender_gate_id != null)
    			<td>{{$way->item->SenderGate->name}}</td>
    			@elseif($way->item->sender_postoffice_id != null)
     				<td> {{$way->item->SenderPostoffice->name}}</td>
    			@else
     			 <td>{{$way->item->township->name}}</td>
    			@endif
         	<td>{{$way->item->receiver_name}}</td>
         	<td>{{number_format($way->item->deposit)}} Ks</td>
         	<td>{{number_format($way->item->delivery_fees)}} Ks</td>
			    <td>{{number_format($way->item->other_fees)}} Ks</td>
          <td>{{$way->item->pickup->schedule->client->user->name}}<br>
          ({{$way->item->pickup->schedule->client->phone_no}})
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>