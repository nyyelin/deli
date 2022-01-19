@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Reports</h1>
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
          <h3 class="tile-title d-inline-block">Return List ({{$mytime->toFormattedDateString()}})</h3>
          <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Item Code</th>
                  <th>Delivery Men</th>
                  <th>Amount</th>
                  <th>Remark</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach($returnways as $row)
                @php $amount=number_format($row->item->amount) @endphp;
                 <tr>
                  <td>{{$i++}}</td>
                  <td><span class="btn badge badge-primary btndetail" data-itemid="{{$row->item->id}}">{{$row->item->codeno}}</span></td>
                  <td>{{$row->delivery_man->user->name}}</td>
                  <td>{{$amount}}</td>
                  <td>{{$row->remark}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
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
          <div class="returnitemdetail my-1">
              
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
      var routeURL="{{route('returnitem')}}";
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
       $(".returnitemdetail").html(html);

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