<table>
	<thead>
		<th valign="center">Date</th>
		@foreach($ways as $way)
		<th valign="center" style="width: 30px;height: 30px;">{{$way->user->name}}</th>
		@endforeach
	</thead>
	<tbody>
		<tr></tr>
		@foreach($dates as $date)
		<tr>
			<td valign="center" style="width: 20px;height: 30px;">{{$date}}</td>
			@foreach($ways as $man)
				@php $count=0;$mycount=0; $gate=[];$office=[]; @endphp
				@foreach($man->pickups as $pickup) 
					@if($pickup->created_at->format('d-m-y')==$date)
						@php $count++; @endphp
					@endif
				@endforeach

				@foreach($man->ways as $way) 
					@if($way->created_at->format('d-m-y')==$date && $way->item->sender_gate_id==null && $way->item->sender_postoffice_id==null && $way->status_code=="001")
						@php $mycount++; @endphp
					
					@elseif($way->created_at->format('d-m-y')==$date && $way->item->sender_gate_id!=null && $way->status_code=="001")
					@php
					$gateobj=[
					"id"=>$way->item->sender_gate_id,
					"date"=>$way->created_at->format('d-m-y'),
					];
					@endphp
					@php
					if(count($gate)==0){
					  array_push($gate,$gateobj);
					}else{
						 for ($i = 0; $i <count($gate); $i++)
 						if($gate[$i]["id"]!=$gateobj["id"] && $gate[$i]["date"]!=$gateobj["date"]){
 						array_push($gate,$gateobj);
 					}
 						
					}
					

					@endphp

					@elseif($way->created_at->format('d-m-y')==$date && $way->item->sender_postoffice_id!=null && $way->status_code=="001")
					@php
					$postobj=[
					"id"=>$way->item->sender_postoffice_id,
					"date"=>$way->created_at->format('d-m-y'),
					];
					@endphp
					@php
					if(count($office)==0){
					array_push($office,$postobj);
					}else{
						for ($i = 0; $i <count($office); $i++) 
 						if($office[$i]["id"]!=$gateobj["id"] && $office[$i]["date"]!=$gateobj["date"]){
 						array_push($office,$postobj);
 					}
 				
					}
					
					@endphp

					
					@endif
				@endforeach
				@php 
				$gatecount=count($gate);
				$officecount=count($office);
				$mycount=$count+$gatecount+$officecount+$mycount; @endphp
				<td valign="center" style="width:20px;height: 30px;">{{$mycount}}</td>
			@endforeach
		</tr>
		@endforeach
		<tr>
			<td valign="center" style="width: 20px;height: 30px;">Total:</td>

			@foreach($ways as $man)
				@php $tcount=0; @endphp
				@foreach($man->pickups as $pickup) 
					@if($pickup->created_at->format('m')==$month)
						@php $tcount++; @endphp
					@endif
				@endforeach

				@foreach($man->ways as $way) 
					@if($way->created_at->format('m')==$month && $way->status_code=="001")
						@php $tcount++; @endphp
					@endif
				@endforeach
				<td valign="center" style="width:20px;height: 30px;">{{$tcount}}</td>
			@endforeach
		</tr>
	</tbody>
</table>