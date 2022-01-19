@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Pickup Detail")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('pickup_history')}}">{{ __("Pickup Hsitory")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
            <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Codeno")}}</th>
                  <th>{{ __("Township")}}</th>
                  <th>{{__("Receiver Name")}}</th>
                  {{-- <th>{{__("Receiver Phone No")}}</th> --}}
                  <th>{{ __("Way State")}}</th>
                  <th>{{__("Deli Fees")}}</th>
                  <th>{{ __("Item Amount")}}</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1;$total=0;$sub=0; @endphp
                @foreach($items as $row)
                @php 
                  $total+=$row->deposit;
                @endphp
                @if($row->paystatus == 2 || $row->paystatus == 4)
                  @php $sub += $row->delivery_fees; @endphp
                @endif

                <tr>
                  <td class="align-middle">{{$i++}}</td>
                  <td class="align-middle">
                    <span class="d-block">{{$row->codeno}}</span>
                    @if($row->paystatus == 1)
                      <span class="badge badge-info">unpaid</span>
                    @elseif($row->paystatus == 2)
                      <span class="badge badge-info">allpaid</span>
                    @elseif($row->paystatus == 3)
                      <span class="badge badge-info">only deli</span>
                    @elseif($row->paystatus == 4)
                      <span class="badge badge-info">only item price</span>
                    @endif
                  </td>
                  <td class="align-middle">
                    @if($row->township != null)
                      {{$row->township->name}}
                    @elseif($row->sender_gate_id != null)
                      {{$row->SenderGate->name}}
                    @elseif($row->sender_postoffice_id != null)
                      {{$row->SenderPostoffice->name}}
                    @endif
                  </td>
                  <td class="align-middle">{{$row->receiver_name}}</td>
                  {{-- <td>{{$row->receiver_phone_no}}</td> --}}
                  <td class="align-middle">
                    @if($row->way==null)
                    <span class="badge badge-primary">
                      delay
                    </span>
                    @elseif($row->way->status_code=='001')
                    <span class="badge badge-info">
                      success
                    </span>
                    @elseif($row->way->status_code=='005')
                      <span class="badge badge-primary">
                      pending
                    </span>
                    @elseif($row->way->status_code=='003')
                      <span class="badge badge-danger">
                      reject
                    </span>
                    @else
                      <span class="badge badge-warning">
                      return
                    </span>
                    @endif

                  </td>
                  <td class="align-middle">{{number_format($row->delivery_fees)}}</td>
                  <td class="align-middle">{{number_format($row->deposit)}}</td>
                </tr>
                @endforeach
                
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="align-middle">Total Amount</td>
                  <td class="align-middle">{{number_format($total-$sub)}}</td>
                </tr>
              </tfoot>
            </table>
          </div>
           
          
        </div>
      </div>
    </div>
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#myTable').DataTable({
      "pageLength": 100,
    });
  })
</script>
@endsection
