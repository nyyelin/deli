@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Reports")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">{{ __("Reject List")}} ({{$mytime->toFormattedDateString()}})</h3>
          <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __("Item Code")}}</th>
                  <th>{{ __("Client")}}</th>
                  <th>{{ __("Customer Name")}}</th>
                  <th>{{ __("Delivery Man")}}</th>
                  <th>{{ __("Item Price")}}</th>
                  <th>{{ __("Deli Fees")}}</th>
                  <th>{{ __("Remark")}}</th>
                  {{-- <th>Action</th> --}}
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach($rejectways as $row)
                 <tr>
                  <td>{{$i++}}</td>
                  <td><span class="btn badge badge-primary btndetail" data-itemid="{{$row->item->id}}">{{$row->item->codeno}}</span></td>
                  <td>{{$row->item->pickup->schedule->client->user->name}}</td>
                  <td>{{$row->item->receiver_name}} Ks</td>

                  <td>{{$row->delivery_man->user->name}}
                      @if($row->income) ({{'ရှင်းပြီး'}}) @endif
                  </td>
                  <td>{{number_format($row->item->deposit)}} Ks</td>
                  <td>{{number_format($row->item->delivery_fees)}} Ks</td>
                  <td>{{$row->remark}}</td>
                  {{-- @foreach($row->notifications as $notification)
                    @if($notification->unread())
                      <td><a href="{{route('clearrejectnoti',$notification->id)}}" class="btn btn-sm btn-info">done</a></td>
                    @else
                      <td><a href="" class="btn btn-sm btn-primary">complete</a></td>
                    @endif
                  @endforeach --}}

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="modal fade" id="detailmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Item Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="rejectitemdetail my-1">
              
          </div>
      </div>
  
    </div>
  </div>
</div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $(".btndetail").click(function(){
      $("#detailmodal").modal("show");
      var item_id=$(this).data("itemid");
      //console.log(item_id);
      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
      var routeURL="{{route('rejectitem')}}";
      $.post(routeURL,{id:item_id},function(res){
        console.log(res);
        var html="";
        $.each(res,function(i,v){
           html+=`<h6 class="text-dark">Expire Date: <span class="text-danger">${v.expired_date}</span></h6>
              <h6 class="text-dark">Deposit Fee: <span>${thousands_separators(v.deposit)}Ks</span></h6>
              <h6 class="text-dark">Delivery Fee:<span>${thousands_separators(v.delivery_fees)}Ks</span></h6>
              <h6 class="text-dark">Client's Name:<span>${v.uname}</span></h6>
              <h6 class="text-dark">Contact Person:<span>${v.cperson}</span></h6>
              <h6 class="text-dark">Client's Phone:<span>${v.cphone}</span></h6>
              <h6 class="text-dark">Client's Full Address:<span>${v.caddress}</span></h6>`
        })
       $(".rejectitemdetail").html(html);

      })
    })
     function thousands_separators(num)
  {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
  }
  })
    
</script>
@endsection