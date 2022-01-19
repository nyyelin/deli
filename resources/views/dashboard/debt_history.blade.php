@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Debt History")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
         <div class="alert alert-primary success d-none" role="alert"></div>
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">{{ __("Debt History")}}</h3>
          <div class="row">
            <div class="form-group col-md-3">
              <label for="InputClient">{{ __("Select Client")}}:</label>
              <select class="form-control" id="InputClient" name="client">
                <optgroup label="Select Client">
                  @foreach($clients as $client)
                    <option value="{{$client->id}}" data-name="{{$client->clientname}}">{{$client->clientname}}</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
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
        
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __("To Get")}}</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __("To Pay")}}</a>
            </li>
          </ul>
          <div class="tab-content mt-4" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{ __("#")}}</th>
                    <th>{{ __("Name")}}</th>
                    {{-- <th>Township</th> --}}
                    <th>{{ __("Delivery Fees")}}</th>
                    <th>{{ __("Deposit Amount")}}</th>
                    <th>{{ __("Total Amount")}}</th>
                  </tr>
                </thead>
                <tbody id="reject_list">
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{ __("#")}}</th>
                    <th>{{ __("Description")}}</th>
                    <th>{{ __("Expense Type")}}</th>
                    <th>{{ __("Amount")}}</th>
                  </tr>
                </thead>
                <tbody id="debit_list">
                </tbody>
              </table>
            </div>
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
        var client_id = $('#InputClient option:selected').val();
        var clientname = $("#InputClient option:selected").text();
        var sdate = $('#InputStartDate').val();
        var edate = $('#InputEndDate').val();
        
        var url = `/debit/getdebithistorybyclient`;
        $.post(url,{client_id:client_id,sdate:sdate,edate:edate},function (response) {
          console.log(response)
          
          let i = 1;
          var html = "";
          let total = 0;
          for(let row of response.expenses){
            html +=`<tr>
                    <td>${i++}</td>
                    <td>${row.description}</td>
                    <td>${row.expense_type.name}</td>
                    <td>${thousands_separators(row.amount)} Ks</td>
                  </tr>`;
                  total += Number(row.amount);
          }
          html +=`<tr>
                    <td colspan="3">Total: </td>
                    <td>${thousands_separators(total)} Ks</td>
                  </tr>`;

          let j=1;
          var html2="";
          let total2=totalreject=totalincome=totalcarryfees=0;
          for(let row of response.rejects){
            
            let delivery_fees = 0;

            html2 +=`<tr>
                      <td>${j++}</td>
                      <td>${row.item.receiver_name}`; 
            if(row.status_code == '003')
                  html2 +=` <span class="badge badge-danger">reject</span>`;
          
            html2 +=`</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(row.item.deposit)}</td>
                      <td>${thousands_separators(row.item.deposit + delivery_fees)} Ks</td>
                  </tr>`;
                  totalreject += Number(row.item.deposit + delivery_fees);
          }

          for(let row of response.incomes){
            let delivery_fees=deposit=0;

            html2 +=`<tr>
                      <td>${j++}</td>
                      <td>${row.way.item.receiver_name}`;

            if(row.payment_type_id == 4){
              delivery_fees = Number(row.way.item.delivery_fees);
              deposit = Number(row.way.item.deposit);
              html2 +=` <span class="badge badge-info">All OS</span>`;
            }

            if(row.payment_type_id == 5){
              deposit = Number(row.way.item.deposit);
              html2 +=` <span class="badge badge-info">Only Deposit</span>`;
            }

            if(row.payment_type_id == 6){
              delivery_fees = Number(row.way.item.delivery_fees);
              html2 +=` <span class="badge badge-info">Only Deli</span>`;
            }

            html2 +=`</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(deposit)}</td>
                      <td>${thousands_separators(delivery_fees+deposit)} Ks</td>
                    </tr>`;
                  totalincome += Number(delivery_fees + deposit);
          }

          for(let row of response.carryfees){
            html2 +=`<tr>
                      <td>${j++}</td>
                      <td>${row.item.receiver_name} - ${row.item.township.name}</td>
                      <td>${0}</td>
                      <td>${thousands_separators(row.amount)} <span class="badge badge-info">carryfees</span> </td>
                      <td>${thousands_separators(row.amount)} Ks</td>
                  </tr>`;
                  totalcarryfees += Number(row.amount);
          }

          total2  = Number(totalreject)+Number(totalincome)+Number(totalcarryfees);

          html2 +=`<tr>
                    <td colspan="4">Total: </td>
                    <td>${thousands_separators(total2)} Ks</td>
                  </tr>`;

          $('#debit_list').html(html);
          $('#reject_list').html(html2);
        })
      })
  })
</script>
@endsection
