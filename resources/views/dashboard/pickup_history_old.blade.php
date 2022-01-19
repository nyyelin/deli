@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Pickup History")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">{{ __("Pickup History")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
      <div class="row">
              <div class="form-group col-md-3">
              <label for="InputStartDate">{{ __("Start Date")}}:</label>
              <input type="date" class="form-control" id="InputStartDate" name="start_date">
            </div>
            <div class="form-group col-md-3">
              <label for="InputEndDate">{{ __("End Date")}}:</label>
              <input type="date" class="form-control" id="InputEndDate" name="end_date">
            </div>
            @role('staff')
            <div class="form-group col-md-3">
              <label for="InputClient">{{ __("Select Client")}}:</label>
                <select class="js-example-basic-single" id="InputClient" name="client">
                  <option value="">Choose Client</option>
                    @foreach($clients as $client)
                      <option value="{{$client->id}}" data-name="{{$client->clientname}}">{{$client->clientname}}</option>
                    @endforeach
                </select>
            </div>
            @endrole
            <div class="form-group col-md-3">
              <button class="btn btn-primary search_btn mt-4" type="button">{{ __("Search")}}</button>
            </div>
        </div>
          
          
          <div class="table-responsive">
            <table class="table" id="picktable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Pickup Date")}}</th>
                  <th>{{ __("Quantity")}}</th>
                  <th>{{ __("Amount")}}</th>
                  <th>{{ __("Actions")}}</th>
                </tr>
              </thead>
              <tbody>
              @role('client')
                @php $i=1; @endphp
                @foreach($pickups as $row)

                @php $sub=0; @endphp

                @foreach($row->items as $item)
                  @if($item->paystatus == 2)
                    @php $sub += $item->delivery_fees; @endphp
                  @endif
                @endforeach
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{\Carbon\Carbon::parse($row->schedule->pickup_date)->format('d-m-Y')}}</td>
                  <td>{{$row->schedule->quantity}}</td>
                  <td>{{number_format($row->schedule->amount-$sub)}}</td>
                  
                  @if($row->items)
                  <td><a class="btn btn-primary btn-sm d-inline-block btnEdit " href="{{route('historydetails',$row->id)}}">Detail</a></td>
                  @endif
                  
                </tr>

                @endforeach
              @endrole
                
              </tbody>
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
    $('.js-example-basic-single').select2({width:'100%'});

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Y/M/D into D/M/Y
    function formatDate (input) {
      var datePart = input.match(/\d+/g),
      year = datePart[0].substring(0,4), // get only two digits
      month = datePart[1], day = datePart[2];
      return day+'-'+month+'-'+year;
    }

    function thousands_separators(num){
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

    $('.search_btn').click(function () {
      //alert("ok");
      var sdate = $('#InputStartDate').val();
      var edate = $('#InputEndDate').val();
      var client_id=$("#InputClient").val();
      // console.log(start_date, end_date)
      var url="{{route('pickupbyclient')}}";
      var i=1;
      $('#picktable').DataTable({
        "processing": true,
        "serverSide": true,
        destroy:true,
        "sort":false,
        "stateSave": true,
        "ajax": {
            url: url,
            type: "POST",
            data:{sdate:sdate,edate:edate,client_id:client_id},
            dataType:'json',
          },
        "columns": [
          {"data":'DT_RowIndex'},
          { "data": "schedule.pickup_date",
            render:function (data) {
              return formatDate(data)
            }
          },
          { "data": "schedule.quantity" },
          { "data": "expenses[0].guest_amount" },
          { "data": "id",
            sortable:false,
            render:function(data){
              var routeurl="{{route('historydetails',':id')}}";
              routeurl=routeurl.replace(':id',data);
              return `<a class="btn btn-primary btn-sm d-inline-block btnEdit" href="${routeurl}" data-id="${data}">Detail</a>`;
            }
          }
        ],
        "info":false
      });   
    })
  })
</script>
@endsection
