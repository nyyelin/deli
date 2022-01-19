@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
     @if(session('successMsg') != NULL)
          <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
              <strong> ✅ SUCCESS!</strong>
              {{ session('successMsg') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
    <div class="row">
      <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
          <div class="info">
            <h4>{{ __("Incomes")}}</h4>
            <p><b>{{number_format($incomes)}}</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
          <div class="info">
            <h4>{{ __("Expenses")}}</h4>
            <p><b>{{number_format($expenses)}}</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
          <div class="info">
            <h4>{{ __("Staff")}}</h4>
            <p><b>{{$staff}}</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
          <div class="info">
            <h4>{{ __("Delivery Man")}}</h4>
            <p><b>{{$deliverymen}}</b></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">{{ __("Monthly Ways")}}</h3>
          <div class="embed-responsive embed-responsive-16by9">
            <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title">{{$mytime->format('F')}} (Success | Reject)</h3>
          <div class="embed-responsive embed-responsive-16by9">
            <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 
@section('script')
  <script type="text/javascript" src="{{ asset('assets/js/plugins/chart.js') }}"></script>

  <script type="text/javascript">
    // Get Ways
    $.get("{{route('getways')}}",function (response) {
      console.log(response);
      var data = {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
          // {
          //   label: "My First dataset",
          //   fillColor: "rgba(220,220,220,0.2)",
          //   strokeColor: "rgba(220,220,220,1)",
          //   pointColor: "rgba(220,220,220,1)",
          //   pointStrokeColor: "#fff",
          //   pointHighlightFill: "#fff",
          //   pointHighlightStroke: "rgba(220,220,220,1)",
          //   data: [65, 59, 80, 81, 56]
          // },
          {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: response.ways
          }
        ]
      };

      var pdata = [
        {
          value: response.success_ways,
          color: "#46BFBD",
          highlight: "#5AD3D1",
          label: "Success Ways"
        },
        {
          value: response.reject_ways,
          color:"#F7464A",
          highlight: "#FF5A5E",
          label: "Reject Ways"
        }
      ]
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);
    })
    
    
  </script>
@endsection