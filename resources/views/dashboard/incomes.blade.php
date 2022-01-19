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
          <h3 class="tile-title d-inline-block">{{ __("Incomes List")}} ({{$mytime->toFormattedDateString()}})</h3>
          {{-- <a href="{{route('incomes.create')}}" class="btn btn-sm btn-primary float-right">{{ __("Add Income")}}</a> --}}
          <div class="row">
            <div class="form-group col-md-6">
              <label for="InputDeliveryMan">{{ __("Select Delivery Man")}}:</label>
              <select class="form-control InputDeliveryMan" id="InputDeliveryMan" name="deliveryman">
                <optgroup label="Select Delivery Man">
                  @foreach($delivery_men as $deliveryman)
                    <option value="{{$deliveryman->id}}" data-name="{{$deliveryman->user->name}}">{{$deliveryman->user->name}}</option>
                  @endforeach
                </optgroup>
              </select>

            </div>
          </div>
          <label class="delivery_man"></label>

          <div >
            <div class="table-responsive">
              <table class="table incomedata table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Codeno</th>
                    <th>Delivered Date</th>
                    <th>Client Name</th>
                    <th>Township</th>
                    <th>Customer Name</th>
                    <th>Delivery Fees</th>
                    <th>Item Price</th>
                    <th>SubTotal</th>
                    <th>Note</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i=1; $total=0; @endphp

                  @foreach($ways as $row)


                    @if($row->income)
                      @if($row->income->status == 0)
                          @php
                            $e_date = date('d-m-Y',strtotime($row->item_with_trash->expired_date));
                            $date = date('d-m-Y',strtotime($row->delivery_date));
                            if ($row->item_with_trash->paystatus=="1" && $row->status_code=="001") {
                              $total+=$row->item_with_trash->amount;
                            }else if($row->item_with_trash->paystatus=="2"){
                              $total+=0;
                            }else if($row->item_with_trash->paystatus=="3" && $row->status_code=="001"){
                              $total+=($row->item_with_trash->delivery_fees+$row->item_with_trash->other_fees);
                            }else if($row->item_with_trash->paystatus=="4" && $row->status_code=="001"){
                              $total+=$row->item_with_trash->deposit;
                            }

                            if ($row->status_code=="002") {
                              $color = "table-warning";
                              if ($row->item_with_trash->paystatus=="1") {
                                $total-=$row->item_with_trash->amount;
                              }else if($row->item_with_trash->paystatus=="2"){
                                $total-=0;
                              }else if($row->item_with_trash->paystatus=="3"){
                                $total-=($row->item_with_trash->delivery_fees+$row->item_with_trash->other_fees);
                              }else if($row->item_with_trash->paystatus=="4"){
                                $total-=Number($row->item_with_trash->deposit);
                              }
                            }else{
                              $color = "";
                            }

                        @endphp
                        
                          <tr class="{{$color}}">
                            <td>{{$i++}}</td>
                            
                            @if($row->item_with_trash->paystatus == "1")
                              @php
                                $subtotal = $row->item_with_trash->deposit + $row->item_with_trash->delivery_fees;
                              @endphp
                            @elseif($row->item_with_trash->paystatus == "2")

                              @php
                                $subtotal = $row->item_with_trash->deposit + $row->item_with_trash->delivery_fees;
                              @endphp

                            @elseif($row->item_with_trash->paystatus == "3")

                            @php
                              $subtotal = $row->item_with_trash->delivery_fees;
                            @endphp                              

                            @elseif($row->item_with_trash->paystatus == "4")

                            @php
                              $subtotal = $row->item_with_trash->deposit;
                            @endphp


                            @endif



                            <td>{{$row->item_with_trash->codeno}} <br>
                              @if($row->status_code == "001")
                                <span class="badge badge-info">success</span>
                                @if($row->item_with_trash->paystatus == 1)

                                   <span class="badge badge-info">Unpaid</span>
                           


                                  @elseif($row->item_with_trash->paystatus == 2)

              
                                     <span class="badge badge-info">All Paid</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 3)
                          
                                     <span class="badge badge-info">Only Deli</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 4)
                          
                                     <span class="badge badge-info">Only Item Price</span>
                             
                                @endif

                              @elseif($row->status_code == "002")
                                <span class="badge badge-warning">return</span>
                                @if($row->item_with_trash->paystatus == 1)
                          
                                     <span class="badge badge-info">Unpaid</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 2)
                 
                                     <span class="badge badge-info">All Paid</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 3)

                          
                                     <span class="badge badge-info">Only Deli</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 4)

                          
                                     <span class="badge badge-info">Only Item Price</span>
                             

                                @endif
                              @elseif($row->status_code == "003")
                                <span class="badge badge-danger">reject</span>
                                @if($row->item_with_trash->paystatus == 1)

                          
                                     <span class="badge badge-info">Unpaid</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 2)

                          
                                     <span class="badge badge-info">All Paid</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 3)

                          
                                     <span class="badge badge-info">Only Deli</span>
                             

                                  @elseif($row->item_with_trash->paystatus == 4)

                          
                                     <span class="badge badge-info">Only Item Price</span>
                             

                                @endif
                              @endif
                            </td>
                            @if($row->delivery_date)
                              <td>{{$date}}</td>
                            @else
                              <td>{{'-'}}</td>
                            @endif

                            <td>{{$row->item_with_trash->pickup->schedule->client->user->name}}</td>
                            <td>
                              @if(isset($row->item_with_trash->township))
                              {{$row->item_with_trash->township->name}}
                              @elseif(isset($row->item_with_trash->SenderGate))
                              {{$row->item_with_trash->SenderGate->name}}
                              @elseif(isset($row->item_with_trash->SenderPostoffice))
                              {{$row->item_with_trash->SenderPostoffice->name}}
                              @endif
                            </td>
                            <td>{{$row->item_with_trash->receiver_name}}</td>
                            @if($row->delivery_date)
                              
                              <td>{{number_format($row->item_with_trash->delivery_fees)}}
                              @if($row->item_with_trash->other_fees > 0)
                                {{'+'.number_format($row->item_with_trash->other_fees)}}
                              @endif
                              </td>
                              <td>{{number_format($row->item_with_trash->deposit)}}</td>
                            @else
                              
                              <td>{{'-'}}</td>
                              <td>{{'-'}}</td>
                             
                            @endif

                            <td>
                              @if($subtotal>0)
                                {{$subtotal}}
                              @else
                                {{0}}
                              @endif
                            </td>

                            @if($row->status_code=="001")
                              <td>{{'-'}}</td>
                            @elseif($row->status_code=="002")
                              <td>{{$e_date}}</td>
                            @elseif($row->status_code=="003")
                              <td><span class="badge badge-danger">reject way</span></td>

                            @endif

                          </tr>
                      @endif
                    @else

                      @php
                        $e_date = date('d-m-Y',strtotime($row->item_with_trash->expired_date));
                        $date = date('d-m-Y',strtotime($row->delivery_date));
                        if ($row->item_with_trash->paystatus=="1" && $row->status_code=="001") {
                          $total+=$row->item_with_trash->amount;
                        }else if($row->item_with_trash->paystatus=="2"){
                          $total+=0;
                        }else if($row->item_with_trash->paystatus=="3" && $row->status_code=="001"){
                          $total+=($row->item_with_trash->delivery_fees+$row->item_with_trash->other_fees);
                        }else if($row->item_with_trash->paystatus=="4" && $row->status_code=="001"){
                          $total+=$row->item_with_trash->deposit;
                        }

                        if ($row->status_code=="002") {
                          $color = "table-warning";
                          if ($row->item_with_trash->paystatus=="1") {
                            $total-=$row->item_with_trash->amount;
                          }else if($row->item_with_trash->paystatus=="2"){
                            $total-=0;
                          }else if($row->item_with_trash->paystatus=="3"){
                            $total-=($row->item_with_trash->delivery_fees+$row->item_with_trash->other_fees);
                          }else if($row->item_with_trash->paystatus=="4"){
                            $total-=$row->item_with_trash->deposit;
                          }
                        }else{
                          $color = "";
                        }
                      @endphp

                      <tr class="{{$color}}">
                        <td>{{$i++}}</td>

                        @if($row->item_with_trash->paystatus == 1)
                          @php
                            $subtotal = $row->item_with_trash->deposit + $row->item_with_trash->delivery_fees;
                          @endphp
                        @elseif($row->item_with_trash->paystatus == 2)

                            @php
                              $subtotal = $row->item_with_trash->delivery_fees;
                            @endphp


                        @elseif($row->item_with_trash->paystatus == 3)

                          @php
                            $subtotal = $row->item_with_trash->delivery_fees;
                          @endphp

                        @elseif($row->item_with_trash->paystatus == 4)

                          @php
                            $subtotal = $row->item_with_trash->deposit ;
                          @endphp

                        @endif

                        {{-- <td><span class="badge badge-primary">{{$row->item_with_trash->codeno}}</span></td> --}}
                        
                        <td>{{$row->item_with_trash->codeno}} <br>
                          @if($row->status_code == "001")
                            <span class="badge badge-info">success</span>
                            @if($row->item_with_trash->paystatus == 1)                        
                                 <span class="badge badge-info">Unpaid</span>
                              @elseif($row->item_with_trash->paystatus == 2)
                                 <span class="badge badge-info">All Paid</span>
                              @elseif($row->item_with_trash->paystatus == 3)
                                 <span class="badge badge-info">Only Deli</span>
                         
                              @elseif($row->item_with_trash->paystatus == 4)
                                 <span class="badge badge-info">Only Item Price</span>
                            @endif

                          @elseif($row->status_code == "002")
                            <span class="badge badge-warning">return</span>
                            @if($row->item_with_trash->paystatus == 1)

                      
                                 <span class="badge badge-info">Unpaid</span>
                         

                              @elseif($row->item_with_trash->paystatus == 2)

                      
                                 <span class="badge badge-info">All Paid</span>
                         

                              @elseif($row->item_with_trash->paystatus == 3)

                      
                                 <span class="badge badge-info">Only Deli</span>
                         

                              @elseif($row->item_with_trash->paystatus == 4)

                      
                                 <span class="badge badge-info">Only Item Price</span>
                         

                            @endif
                          @elseif($row->status_code == "003")
                            <span class="badge badge-danger">reject</span>
                            @if($row->item_with_trash->paystatus == 1)

                      
                                 <span class="badge badge-info">Unpaid</span>
                         

                              @elseif($row->item_with_trash->paystatus == 2)

                      
                                 <span class="badge badge-info">All Paid</span>
                         

                              @elseif($row->item_with_trash->paystatus == 3)

                      
                                 <span class="badge badge-info">Only Deli</span>
                         

                              @elseif($row->item_with_trash->paystatus == 4)

                      
                                 <span class="badge badge-info">Only Item Price</span>
                         

                            @endif
                          @endif
                        </td>
                        @if($row->delivery_date)
                          <td>{{$date}}</td>
                        @else
                          <td>{{'-'}}</td>
                        @endif

                        <td>{{$row->item_with_trash->pickup->schedule->client->user->name}}</td>
                        <td>
                          @if(isset($row->item_with_trash->township))
                          {{$row->item_with_trash->township->name}}
                          @elseif(isset($row->item_with_trash->SenderGate))
                          {{$row->item_with_trash->SenderGate->name}}
                          <br>
                          <p class="badge badge-dark">Gate</p>

                          @elseif(isset($row->item_with_trash->SenderPostoffice))
                          {{$row->item_with_trash->SenderPostoffice->name}}
                          <br>
                          <p class="badge badge-dark">Post Office</p>

                          @endif

                        
                        </td>
                        <td>{{$row->item_with_trash->receiver_name}}</td>
                        @if($row->delivery_date)
                          
                          <td>{{number_format($row->item_with_trash->delivery_fees)}}
                          @if($row->item_with_trash->other_fees > 0)
                            {{'+'.number_format($row->item_with_trash->other_fees)}}
                          @endif
                          </td>
                          <td>{{number_format($row->item_with_trash->deposit)}}</td>
                        @else
                          
                          <td>{{'-'}}</td>
                          <td>{{'-'}}</td>
                         
                        @endif

                        <td>
                          {{0}}
                        </td>

                        @if($row->status_code=="001")
                          <td>{{'-'}}</td>
                        @elseif($row->status_code=="002")
                          <td>{{$e_date}}</td>
                        @elseif($row->status_code=="003")
                          <td><span class="badge badge-danger">reject way</span></td>

                        @endif
                      </tr>
                    @endif
                  @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      // $('.js-example-basic-single').select2({
      //   width: '100%',
      // });

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      var data_table = $('.incomedata').DataTable( {
        "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
        "pageLength": 500,
        
        fixedHeader: {
            header: true,
            footer: true
        }
        } );

      $('.InputDeliveryMan').change(function () {
          var deliveryman_id = $(this).val();
          var html = '';
          var deliveryman = $(".InputDeliveryMan option:selected").text();
          var url = `/incomes/getsuccesswaysbydeliveryman/${deliveryman_id}`;
          var table = $('.incomedata').DataTable();
          table.destroy();
          var delivery_fee = 0;
          var total = 0;
          var price = 0;
          var delivery_fees = 0;
          var price_confirm = 0;
         
          var deli_t = 0;
          var price_t = 0;
          var id = new Array();

          $('.incomedata').dataTable({
          "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
          "pageLength": 500,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bRetrieve": true,
          "dataSrc": "data",
          "bAutoWidth": true,
          "bStateSave": true,
          "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ -1,0] }
          ],
          "bserverSide": true,
          "bprocessing":true,
          'stateSave': true,

          "ajax": {   
            url: url,
            type: "GET",
            dataType:'json',
          },


          "columns": [


          {"data":'DT_RowIndex'},
          {"data": null,
          render:function(data,row){

            
            id.push(data.id);

              let paystatus=state="";
              if (data.item.paystatus == "1") {
                paystatus="unpaid"
              }else if (data.item.paystatus == "2") {
                paystatus="allpaid"
              }else if (data.item.paystatus == "3") {
                paystatus="only deli"
              }else if (data.item.paystatus == "4") {
                paystatus="only item price"
              }

            if(data.status_code=="001"){
              
              state = `<span class="badge badge-info">{{'success'}}</span>`
            }else if(data.status_code=="002"){
               state = `<span class="badge badge-warning">{{'return'}}</span>`
            }else if(data.status_code=="003"){
              state = `<span class="badge badge-danger">{{'reject'}}</span>`
            }else{
              state = `<span class="badge badge-dark">{{'assign'}}</span>`
            }

            return `<span class="d-block">${data.item.codeno}</span>
                      <span class="badge badge-pill badge-info">${paystatus}</span> ${state}`
          }
        },
        
        {
          "data":null,
          render:function(data,row){
            if(data.delivery_date != null){

              return `${formatDate(data.delivery_date)}`

            }else{
              return '-'
            }
          }
        },
        {
          "data":"item.pickup.schedule.client.user.name"
          
        },
        {
          "data":"item_with_trash",
          render:function(data){
              console.log(data);
            if(data.township_id){
              return `${data.township.name}`;
            }else if(data.sender_gate_id){
              return `${data.sender_gate.name}<br>
              <p class="badge badge-dark">Gate</p>
              `;
            }else if(data.sender_postoffice_id){
              return `${data.sender_postoffice.name}<br>
              <p class="badge badge-dark">Post Office</p>
              `;
            }
          }
        },


        {
          "data":"item.receiver_name"   
        },


        {
          data:function(data,row,type,val){
            
            // console.log(data);

            if(data.item_with_trash.way_with_trash){

                if(data.delivery_date == null){
                  return `${thousands_separators(0)}`

                }else{
                 
                return `${thousands_separators(data.item_with_trash.delivery_fees)}`;
                }

              }
            
          }
        },
        
        
        {
          data:function(data,row,da){
            if(data.delivery_date == null){
              return `${thousands_separators(0)}`
            }else{
              return `
              
              ${thousands_separators(data.item.deposit)}`
            }
          }
        },


        {
          data:function(data,row){
            let subtotal = 0;

            if(data.status_code == "001"){
              if(data.item_with_trash.paystatus == 1){

                  subtotal += Number(data.item_with_trash.deposit) + Number(data.item_with_trash.delivery_fees);
                  return `${thousands_separators(subtotal)}`

              }else if(data.item_with_trash.paystatus == 2){

                  subtotal += subtotal += Number(data.item_with_trash.deposit) + Number(data.item_with_trash.delivery_fees);
                  return `${thousands_separators(subtotal)}`

              }else if(data.item_with_trash.paystatus == 3){
                  subtotal += Number(data.item_with_trash.delivery_fees);
                  return `${thousands_separators(subtotal)}`

              }else if(data.item_with_trash.paystatus == 4){
                  subtotal += Number(data.item_with_trash.deposit);
                  return `${thousands_separators(subtotal)}`

              }
            }else{
              return `0`;
            }
          }
        },
        
        {
         "data":null,
          render:function(data,row){
            if(data.delivery_date != null){
              return `-`
            }else if(data.item.expired_date){
              return `${formatDate(data.item.expired_date)}`
            }else{
              return `<p class="badge badge-danger">reject</p>`
            }
          }
        },
        
       ],
     

       rowCallback: function (row, data) {
            
            if (data.status_code == '002') {
                $(row).addClass('table-warning');
                $(data).val(0);
            }

            
          },

      footerCallback: function ( row, data,display) {

            
            var table = $('.incomedata').DataTable();

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

              // delivery_fees = api
              //   .column( 6, { page: 'current'} )
              //   .data()
              //   .reduce( function (a, b) {
              //     return intVal(a)+intVal(b);
                    
              //   }, 0 );

              deposit = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                  return intVal(a)+intVal(b);
                    
                }, 0 );

              $( api.column( 0 ).footer() ).html(
                thousands_separators(data.length) ,
              );

              $( api.column( 8 ).footer() ).html(
                thousands_separators(deposit) ,
              );

              


              if(id){
                $( api.column( 9 ).footer() ).html(

                    `
                    <form action='{{route('income_status_change')}}' method='post'>
                    @csrf
                    <input type="hidden" name="id[]" value="${id}">
                    <button class='btn btn-info'>Complete</button>
                    </form>`,
                );
              }

            }else{
              $( api.column( 0 ).footer() ).html(
                thousands_separators(0) ,
              );

              $( api.column( 8 ).footer() ).html(
                thousands_separators(0) ,
              );
            }
        },

      
       "info":false

        });
        })
     


      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    })


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
  </script>
@endsection