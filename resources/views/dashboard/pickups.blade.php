@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        @php $mytime = Carbon\Carbon::now(); @endphp
        <h1><i class="fa fa-dashboard"></i> {{ __("Pickups")}} ({{$mytime->toFormattedDateString()}})</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('pickups')}}">{{ __("Pickups")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
         @if(session('successMsg') != NULL)
              <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
                  <strong> ✅ SUCCESS!</strong>
                  {{ session('successMsg') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
      </div>
    </div>

        {{-- <div class="tile"> --}}
          
          {{-- <h3 class="tile-title d-inline-block">Pickup List ({{$mytime->toFormattedDateString()}})</h3> --}}
          
          {{-- <div class="table-responsive">
            <table class="table table-bordered dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Client Name</th>
                  <th>Township</th>
                  <th>Pickup Date</th>
                  <th>remark</th>
                  <th>Quantity</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1;@endphp
                @foreach($pickups as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td class="text-danger">{{$row->schedule->client->user->name}}</td>
                  <td>{{$row->schedule->client->address}}</td>
                  <td class="text-danger">{{$row->schedule->pickup_date}}</td>
                  <td>{{$row->schedule->remark}}</td>
                  <td>{{$row->schedule->quantity}}</td>
                  <td>
                    @if($row->status==0)
                    <a href="#" class="btn btn-primary">Pending</a>
                    <a href="{{route('pickupdone',$row->id)}}" class="btn btn-success">Done</a>
                    @else
                    <a href="#" class="btn btn-primary">completed pick up</a>
                    @endif
                    
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> --}}
      <div class="row">
          @foreach($pickups as $row)
          <div class="col-md-4">
            <div class="card mb-3">
              <h5 class="card-header">{{$row->schedule->client->user->name}}  @if($row->schedule->amount!=null && $row->schedule->quantity!=null )({{$row->schedule->quantity}})@endif <small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> {{\Carbon\Carbon::parse($row->schedule->pickup_date)->format('d-m-Y')}}</small></h5>
              <div class="card-body">
                <h5 class="card-title">{{ __("Phone No")}}: {{$row->schedule->client->phone_no}}</h5>
                <h5 class="card-title">{{$row->schedule->client->address}}</h5>
                @if($row->schedule->amount!=null && $row->schedule->quantity!=null )
                <p class="card-text">{{ __("Deposit")}}: {{number_format($row->schedule->amount)}} Ks</p>
                <p class="card-text">{{ __("Quantity")}}: {{$row->schedule->quantity}}</p>
                @endif
                @if($row->schedule->remark != null)
                  <p class="card-text">
                    <strong class="text-danger">* </strong> 
                    {{$row->schedule->remark}}
                  </p>
                @endif
                @if($row->schedule->qty==0 && $row->schedule->amount==0 && $row->status==0)
                  <a href="#" class="btn btn-sm btn-secondary addamount" data-id="{{$row->schedule->id}}">{{ __("Make Complete")}}</a>
                @elseif($row->status==0)
                  <a href="{{route('pickupdone',['id' => $row->id, 'qty' => $row->schedule->quantity])}}" class="btn btn-sm btn-success">{{ __("Make Complete")}}</a>
                @else
                  <a href="#" class="btn btn-sm btn-primary">{{ __("Completed")}}</a>
                @endif

              </div>
            </div>
          </div>
          @endforeach

      


        {{-- </div> --}}
      </div>
  </main>

  {{--Add amount modal--}}
  <div class="modal fade" id="addamount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Add Amount and Quantity")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="schedule" id="schedule_id" value="">
          <div class="form-group quantity">
            <label for="quantity">{{ __("Quantity")}}:</label>
            <input type="number"  id="quantity" class="form-control" name="quantity">
            <span class="Eamount error d-block" ></span>
          </div>
          <div class="form-group amount">
            <label for="amount">{{ __("Amount")}}:</label>
            <input type="number"  id="amount" class="form-control" name="amount">
            <span class="Equantity error d-block" ></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary amountsave">{{ __("Save")}}</button>
        </div>
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(".addamount").click(function(e){
      e.preventDefault();
      $('#addamount').modal('show');
      var id=$(this).data('id');
      $("#schedule_id").val(id);
    })

    $(".amountsave").click(function(){
      var schedule_id=$("#schedule_id").val();
      var amount=$("#amount").val();
      var quantity=$("#quantity").val();
      var url="{{route('editamountandqty')}}";
      
      $.ajax({
        url:url,
        type:"post",
        data:{schedule_id:schedule_id,amount:amount,quantity:quantity},
        dataType:'json',
        success:function(response){
          if(response.success){
             $('#addamount').modal('hide');
             $('.Eamount').text('');
             $('.quantity').text('');
            $('span.error').removeClass('text-danger');
            location.href="{{route('pickups')}}";
          }
        },
        error:function(error){
          var message=error.responseJSON.message;
          var errors=error.responseJSON.errors;
          console.log(error.responseJSON.errors);
          if(errors){
            var amount=errors.amount;
            var quantity=errors.quantity;
            $('.Eamount').text(amount);
            $('.Equantity').text(quantity);
            $('span.error').addClass('text-danger');
          }
        }
      })
    })
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
  })
</script>
@endsection