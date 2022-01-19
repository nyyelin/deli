@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Financial Statements</h1>
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
          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">{{ __("Income")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">{{ __("Expense")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profit">{{ __("Profit")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#banks">{{ __("Banks")}}</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="home">
                <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                    <input type="date" name="" class="form-control start-date">
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                    <input type="date" name="" class="form-control end-date">
                  </div>
                  <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 my-2">
                    <button class="btn btn-success search">{{ __("Search")}}</button>
                  </div>
                </div>
                <div class="table-responsive mytable">
                  <table class="table table-bordered w-100" id="incometable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>{{ __("Item Code")}}</th>
                        <th>{{ __("Delivery Man")}}</th>
                        <th>{{ __("Cash Amount")}}</th>
                        <th>{{ __("Bank Amount")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="profile">
                <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                  <input type="date" name="" class="form-control exstart-date">
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                  <input type="date" name="" class="form-control exend-date">
                  </div>
                  <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 my-2">
                   <button class="btn btn-success exsearch">{{ __("Search")}}</button>
                  </div>
                </div>
                <div class="table-responsive mytable">
                  <table class="table table-bordered w-100" id="expensetable">
                    <thead>
                      <tr>  
                        <th>#</th>
                        <th>{{ __("Description")}}</th>
                        <th>{{ __("Expense Type")}}</th>
                        <th>{{ __("Amount")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="profit">
                <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                  <input type="date" name="" class="form-control pstart-date">
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                  <input type="date" name="" class="form-control pend-date">
                  </div>
                  <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 my-2">
                   <button class="btn btn-success psearch">{{ __("Search")}}</button>
                  </div>
                </div>

                <div class="table-responsive mytable">
                  <table class="table table-bordered w-100" id="profittable">
                    <thead>
                      <tr>  
                        <th>{{ __("Total Income")}}</th>
                        <th>{{ __("Net Income")}}</th>
                        <th>{{ __("Expense")}}(အခြား+တန်ဆာခ)</th>
                        <th>{{ __("Net Profit")}}</th>
                      </tr>
                    </thead>
                    <tbody class="searchTable">
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="banks">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>  
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Banks")}}</th>
                        <th>{{ __("Amount")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1; @endphp
                      @foreach($banks as $row)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->amount}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function (argument) {
      $(".mytable").hide();

      $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('.search').click(function (argument) {
        $(".mytable").show();
        var start_date = $('.start-date').val();
        var end_date = $('.end-date').val();
        var url="{{route('incomesearch')}}";
        var i=1;
        $('#incometable').DataTable({
          "pageLength": 100,
          "processing": true,
          "serverSide": true,
          destroy:true,
          "sort":false,
          "stateSave": true,
          "ajax": {
              url: url,
              type: "POST",
              data:{start_date:start_date,end_date:end_date},
              dataType:'json',
          },
          "columns": [
            {"data":'DT_RowIndex'},
            {"data": "item_code",
              render:function(data){
                return `<span class="btn badge badge-primary">${data}</span>`
              } 
            },
            {"data": "delivery_man" },
            {"data": "cash_amount" },
            {"data": "bank_amount" }
          ],
          footerCallback: function ( row, data) {
            var table = $('#incometable').DataTable();
            var api = table,data;
            
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            if(data.length > 0){
              // var price = data[0].item.deposit;
              bank_amount_total =  api
                  .column(3 )
                  .data()
                  .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                  }, 0 );

              bank_amount_pageTotal = api
                  .column( 3, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b) ;
                  }, 0 );

              $( api.column( 3 ).footer() ).html(
                thousands_separators(bank_amount_total) ,
              );
            }
          },
          "info":false
        });
      })
  
      //expensesearch
      $('.exsearch').click(function (argument) {
        $(".mytable").show();
        var start_date = $('.exstart-date').val();
        var end_date = $('.exend-date').val();
        // console.log(start_date, end_date)
        var url="{{route('expensesearch')}}";
        var i=1;
        $('#expensetable').DataTable( {
          "processing": true,
          "serverSide": true,
          destroy:true,
          "sort":false,
          "stateSave": true,
          "ajax": {
            url: url,
            type: "POST",
            data:{start_date:start_date,end_date:end_date},
            dataType:'json',
          },
          "columns": [
            {"data":'DT_RowIndex'},
            {"data": "description",},
            {"data": "expense" },
            {"data": "amount" }
          ],
          "info":false
        });  
      })

      //profit
      $('.psearch').click(function (argument) {
        $(".mytable").show();
        var start_date = $('.pstart-date').val();
        var end_date = $('.pend-date').val();
        var url="{{route('profit')}}";
        $.ajaxSetup({
          headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.post(url,{start_date:start_date,end_date:end_date},function(res){
          var allincomes=res.allincomes;
          var netincomes=res.netincomes;
          var expenses=res.expenses;
          var profit=netincomes-expenses;

          var html='';
          html+=`<tr><td>${thousands_separators(allincomes)}</td><td>${thousands_separators(netincomes)}</td><td>${thousands_separators(expenses)}</td><td>${thousands_separators(profit)}</td></tr>`
          $(".searchTable").html(html);
        })  
      })

      function thousands_separators(num){
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
      }
    })
  </script>
@endsection