@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Incomes")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('incomes')}}">{{ __("Incomes")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-primary success d-none" role="alert"></div>
        <div class="tile">
          <h3 class="tile-title d-inline-block">Income Create Form</h3>
          
          <div class="row">
            <div class="form-group col-md-6">
              <label for="InputDeliveryMan">{{ __("Select Delivery Man")}}:</label>
              <select class="js-example-basic-single" id="InputDeliveryMan" name="deliveryman">
                <optgroup label="Select Delivery Man">
                  @foreach($delivery_men as $deliveryman)
                    <option value="{{$deliveryman->id}}" data-name="{{$deliveryman->deliveryname}}">{{$deliveryman->deliveryname}}</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
            
          </div>

          <div id="incomeform">
          </div>
        </div>
      </div>
      
    </div>
  </main>

@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      $('.js-example-basic-single').select2({
        width: '100%',
      });

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#InputDeliveryMan').change(function () {
        var deliveryman_id = $(this).val();
        var deliveryman = $("#InputDeliveryMan option:selected").text();
        //alert(deliveryman)
        getdata(deliveryman_id,deliveryman);
      })

      function getdata(deliveryman_id,deliveryman){
        var url = `/incomes/getsuccesswaysbydeliveryman/${deliveryman_id}`;
        $.get(url,function (response) {
          console.log(response);
          var html = `
            
            <label>Success Ways By ${deliveryman}:</label>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Codeno</th>
                    <th>Township</th>
                    <th>Customer Name</th>
                    <th>Delivered Date</th>
                    <th>Delivery Fees</th>
                    <th>Item Price</th>
                    <th>Note</th>
                  </tr>
                </thead>
                <tbody>`;
                var i=1;
                var total=0;
                var pp="";
                $.each(response.paymenttypes,function(i,v){
                  pp+=`<option value="${v.id}">${v.name}</option>`
                })
                $("#paymenttype").html(pp);

                var hh=`<option value=${null}>Choose Bank</option>`;
                $.each(response.banks,function(i,v){
                  hh+=`
                  <option value="${v.id}">${v.name}</option>`
                })
                $("#bank").html(hh);
          console.log(response.ways)
          for(let row of response.ways){
            console.log(row);
            if (row.item.paystatus==1) {
              total+=Number(row.item.item_amount)
            }else if(row.item.paystatus==2){
              total+=0
            }else if(row.item.paystatus==3){
              total+=Number(row.item.delivery_fees)+Number(row.item.other_fees)
            }else if(row.item.paystatus==4){
              total+=Number(row.item.deposit)
            }

            if (row.status_code=="002") {
              color = "table-warning"
              if (row.item.paystatus==1) {
                total-=Number(row.item.item_amount)
              }else if(row.item.paystatus==2){
                total-=0
              }else if(row.item.paystatus==3){
                total-=Number(row.item.delivery_fees)+Number(row.item.other_fees)
              }else if(row.item.paystatus==4){
                total-=Number(row.item.deposit)
              }
            }else{
              color = ""
            }
            html +=`
              <tr class="${color}">
                    <td>${i++}</td>
                    <td>
                      ${row.item.item_code}`
                    if(row.item.paystatus == 2){
                      html+=` <span class="badge badge-success">All Paid</span>`
                    }else if(row.item.paystatus == 3){
                      html+=` <span class="badge badge-success">Only Deli</span>`
                    }else if(row.item.paystatus == 4){
                      html+=` <span class="badge badge-success">Only Item Price</span>`
                    }
                    html+=`</td>
                    <td>${row.item.township.township_name}</td>
                    <td>
                      ${row.item.receiver_name}
                    </td>`
                    if(row.delivery_date){
                      html+=`<td>${row.delivery_date}</td>`
                      html+=`<td>${thousands_separators(row.item.delivery_fees)}`
                      if(row.item.other_fees > 0){
                        html += `+ ${thousands_separators(row.item.other_fees)}`
                      }
                      html+=`</td><td>${thousands_separators(row.item.deposit)}</td>`
                    }else{
                      html+=`<td>-</td>
                            <td>-</td>
                            <td>-</td>`
                    }
                    
                    if(row.status_code=="001"){
                      html+=`<td>-</td>`
                      }else if(row.status_code=="002"){
                        let return_date = new Date(row.item.expired_date);
                       html+= `<td>${return_date.getDate()}-${return_date.getMonth()+1}-${return_date.getFullYear()}</td>`
                      }else if(row.status_code=="003"){
                       html+= `<td><span class="badge badge-danger">reject way</span></td>`
                      }
              html+=`</tr>`;
          }
          html+=`<tr>
                    <td colspan="5">Total:</td>
                    <td colspan="3">${thousands_separators(total)} Ks</td>
                  </tr>`;
          $('#incomeform').html(html);
        })
      }

      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    })

    function thousands_separators(num){
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }
  </script>
@endsection
