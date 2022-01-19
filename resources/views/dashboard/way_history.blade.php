@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Ways History")}}</h1>
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
          

         
      <div class="row">
              <div class="form-group col-md-3">
              <label for="InputStartDate">{{ __("Start Date")}}:</label>
              <input type="date" class="form-control" id="InputStartDate" name="start_date">
            </div>
            <div class="form-group col-md-3">
              <label for="InputEndDate">{{ __("End Date")}}:</label>
              <input type="date" class="form-control" id="InputEndDate" name="end_date">
            </div>
            <div class="form-group col-md-3">
              <button class="btn btn-primary search_btn mt-4" type="button">{{ __("Search")}}</button>
            </div>
        </div>
          
          
          <div class="table-responsive">
            <table class="table" id="waystable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Item Code")}}</th>
                  <th>{{ __("Client")}}</th>
                  <th>{{ __("Delivery Man")}}</th>
                  <th>{{ __("ways state")}}</th>
                  <th>{{ __("Remark")}}</th>
                  {{-- <th>Action</th> --}}
                </tr>
              </thead>
              <tbody>
                
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

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

    $('.search_btn').click(function () {
        var sdate = $('#InputStartDate').val();
        var edate = $('#InputEndDate').val();
// console.log(start_date, end_date)
        var url="{{route('getwayhistory')}}";
        var i=1;
         $('#waystable').DataTable({
        "processing": true,
        "serverSide": true,
        destroy:true,
        "sort":false,
        "stateSave": true,
        "ajax": {
            url: url,
            type: "POST",
            data:{sdate:sdate,edate:edate},
            dataType:'json',
        },
        "columns": [
         {"data":'DT_RowIndex'},
        { "data": "item.codeno",},
        { "data": "item.pickup.schedule.client.user.name" },
        { "data": "delivery_man.user.name" },
        {"data":"status_code",
           render:function(data){
            if(data=="001"){
              return "success"
            }else if(data=="002"){
              return "return"
            }else{
              return "reject"
            }
           }
        },
        { "data": "remark",
          render:function(data){
            if(data==null){
              return "-"
            }else{
              return data
            }
          }
        }
        ],
        "info":false
    });
        
      })
  })
</script>
@endsection
