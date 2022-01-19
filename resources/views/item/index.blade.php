@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Items")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}">{{ __("Items")}}</a></li>
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
        <div class="tile">
          <h3 class="tile-title d-inline-block">{{ __("Item List")}}</h3>
          <a href="#" class="btn btn-sm btn-primary float-right wayassign" id="submit_assign">{{ __("Way Assign")}}</a>

          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#collect">{{ __("In Stock")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#way">{{ __("On Ways")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#print">{{ __("Print Ways")}}</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              {{-- In Stock --}}
              <div class="tab-pane fade active show" id="collect">
                <div class="table-responsive">
                  <table class="table table-bordered" id="checktable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Assign Date")}}</th>
                        <th>{{ __("Client Name")}}</th>
                        <th>{{ __("Receiver Info")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Item Price")}}</th>
                        <th>{{ __("Deli Fees")}}</th>
                        <th>{{ __("Remark")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $total_price = 0;
                        $total_delivery_fee = 0;
                        $array = array();
                      @endphp
                      @foreach($items as $row)
                     
                      @if($row->way_only_trash)
                       @php
                        array_push($array,$row->way);
                      @endphp
                      <tr>
                        @php
                            $total_price += $row->deposit;
                            $total_delivery_fee += $row->delivery_fees;
                            $assign_date = date('d-m-y',strtotime($row->assign_date));
                            $date = date('d-m-Y',strtotime($row->expired_date));
                        @endphp
                        <td class="align-middle">
                          <div class="animated-checkbox">
                            <label class="mb-0">
                              <input type="checkbox" name="assign[]" value="{{$row->id}}" data-codeno="{{$row->codeno}}"><span class="label-text"> </span>
                            </label>
                          </div>
                        </td>
                        <td class="align-middle">
                          <span class="d-block">{{$row->codeno}}</span>
                          @if($row->paystatus=="1")
                            <span class="badge badge-info badge-pill">unpaid</span>
                          @elseif($row->paystatus=="2")
                            <span class="badge badge-info badge-pill">allpaid</span>
                          @elseif($row->paystatus=="3")
                            <span class="badge badge-info badge-pill">only deli</span>
                          @elseif($row->paystatus=="4")
                            <span class="badge badge-info badge-pill">only item price</span>
                          @endif
                        </td>
                        <td class="align-middle">{{Carbon\Carbon::parse($row->assign_date)->format('d-m-Y')}}</td>
                        <td class="align-middle">{{$row->pickup->schedule->client->user->name}}</td>
                        <td class="align-middle">
                          {{$row->receiver_name}} <span class="badge badge-dark">{{$row->receiver_phone_no}}</span>
                        </td>
                        @if($row->township)
                        <td class="align-middle">{{$row->township->name}}</td>
                        @elseif($row->SenderGate)
                        <td class="align-middle">{{$row->SenderGate->name}}</td>
                        @else
                        <td class="align-middle">{{$row->SenderPostoffice->name}}</td>
                        
                        @endif
                        
                        <td class="align-middle">{{number_format($row->deposit)}}</td>
                        <td class="align-middle">{{number_format($row->delivery_fees)}}</td>
                         <td class="align-middle">
                          {{$date}}
                          @if($row->error_remark !== null)
                            <span class="badge badge-warning">{{ __("date changed")}}</span><br>
                            <span>( {{$row->error_remark}} )</span>
                          @endif
                        </td>
                        <td class="mytd align-middle">
                          <a href="#" class="btn btn-sm btn-primary detail" data-id="{{$row->id}}">{{ __("Detail")}}</a>
                          <a href="{{route('items.edit',$row->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>

                           <a href="javascript:void(0)" class="btn btn-sm btn-danger btn_reject" data-id = "{{$row->way_with_trash->id}}">{{ __("Reject")}}</a>
                          {{-- <form action="{{ route('items.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __("Delete")}}</button>
                          </form> --}}
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td>{{count($array)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                          {{number_format($total_price)}}
                        </td>
                        <td>
                          {{number_format($total_delivery_fee)}}
                        </td>
                        <td></td>
                        <td></td>

                      </tr>

                    </tfoot>
                  </table>
                </div>
              </div>

              {{-- On Ways --}}
              <div class="tab-pane fade" id="way">
                <div class="table-responsive">
                  <table class="table table-bordered w-100" id="onwaytable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Assign Date")}}</th>
                        <th>{{ __("Client")}}</th>
                        <th>{{ __("Customer Name")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Delivery Man")}}</th>
                        <th>{{ __("Item Price")}}</th>
                        <th>{{ __("Deli Fees")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>

                    <tfoot>
                      <tr>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>

              {{--  Print Ways --}}
              <div class="tab-pane fade" id="print">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>{{ __("Choose Delivery Man")}}:</label>
                      <select class="deliverymanway form-control" name="delivery_man">
                        {{-- <option>Choose Delivery Man</option> --}}
                        @foreach($deliverymen as $man)
                        <option value="{{$man->id}}" >{{$man->user->name}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered printway">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Item Code")}}</th>
                        <th>{{ __("Assign Date")}}</th>
                        <th>{{ __("Client Name")}}</th>
                        <th>{{ __("Customer Name")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Item Price")}}</th>
                        <th>{{ __("Deli Fees")}}</th>
                       
                      </tr>
                    </thead>

                    <tbody class="tbody">
                    </tbody>
                    <tfoot>
                      <tr>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <form action="{{route("createpdf")}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="" id="exportid">
                  <div class="justify-content-end mb-4" id="export">
                    <button type="submit" class="btn btn-primary exportpdf">Export to PDF</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- Ways Assign modal --}}
  <div class="modal fade" id="wayAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Choose Delivery Man")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('wayassign')}}">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __("Choose Assign Date")}}:</label>
              <input type="date" name="assign_date" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
            <div class="form-group">
              <label>{{ __("Way Code Numbers")}}:</label>
              <div id="selectedWays"></div>
            </div>
            <div class="form-group">
              <label>{{ __("Choose Delivery Man")}}:</label>
              <select class="js-example-basic-multiple form-control" name="delivery_man">
                @foreach($deliverymen as $man)
                  <option value="{{$man->id}}">{{$man->user->name}}
                  @foreach($man->townships as $township)
                    ({{$township->name}})
                  @endforeach</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
            <button type="submit" class="btn btn-primary">{{ __("Assign")}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Edit Ways Assign modal --}}
  <div class="modal fade" id="editwayAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Choose Delivery Man")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('updatewayassign')}}">
          @csrf
          <input type="hidden"  id="wayid" name="wayid">
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __("Choose Delivery Man")}}:</label>
              <select class="js-example-basic-single form-control" name="delivery_man">
                @foreach($deliverymen as $man)
                  <option value="{{$man->id}}">{{$man->user->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
            <button type="submit" class="btn btn-primary">{{ __("Assign")}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Item Detail modal --}}
  <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>{{ __("Receiver Name")}}:</strong> <span id="rname">Ma Mon</span></p>
          {{-- <p ><strong >{{ __("Receiver Phone No")}}:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >{{ __("Receiver Address")}}:</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p> --}}
          <p><strong>{{ __("Remark")}}:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>

          <p id="error_remark" class="d-none"></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("OK")}}</button>
        </div>
      </div>
    </div>
  </div>

    {{-- reject modal --}}
  <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel">Reject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="wayid" id="rejectway" value="">
            </div>
          <div class="form-group">
                  <label for="InputRemark">{{ __("Remark")}}:</label>
                  <textarea class="form-control rejectremark" id="InputRemark" name="remark"></textarea>
                  <span class="Ejremark error d-block" ></span>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btnreject">OK</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      getway();

      function getway(){   
        var url="{{route('onway')}}";
        $('#onwaytable').dataTable({



          "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
          "pageLength": 500,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "bStateSave": true,

          "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ -1,0] },
         
          ],
          "bserverSide": true,
          "bprocessing":true,
          "ajax": {
            url: url,
            type: "GET",
            dataType:'json',
          },
          "columns": [
          {"data":'DT_RowIndex'},
          {"data": null,
            render:function(data, type, full, meta){
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
                state='<span class="badge badge-pill badge-info">success</span>'
              }else if(data.status_code=="002"){
                state='<span class="badge badge-pill badge-warning">return</span>'
              }else if(data.status_code=="005" && data.remark){
                state='<span class="badge badge-pill badge-danger">reject</span>'
              }else if(data.status_code=="003"){
                state='<span class="badge badge-pill badge-danger">reject</span>'
              }else{
                state='<span class="badge badge-pill badge-dark">assign</span>'
              }

              return `<span class="d-block">${data.item.codeno}</span>
                      <span class="badge badge-pill badge-info">${paystatus}</span> ${state}`
            }
          },
          {
            "data":null,
            render:function(data){
              return formatDate(data.item.assign_date);
            }
          },
          {
            "data":"item.pickup.schedule.client.user.name"
          },
          {"data":"item.receiver_name"},

          {
            "data":null,
            render:function(data){
              // return data.item.sender_gate.name
              if(data.item.township){
                return data.item.township.name
              }
              else if(data.item.sender_gate){
                return data.item.sender_gate.name
              }else{
                return data.item.sender_postoffice.name
              }
            }
          },
          {
            "data":"delivery_man.user.name"
          },
          {
            data:function(data){
              if(data.item.paystatus == 1 || data.item.paystatus == 4){
                  return `${thousands_separators(data.item.deposit)}`
              }else {
                return `0`
              }
            }
          },
          {
            data:function(data){
              if(data.item.paystatus == 1 || data.item.paystatus == 3){
                  return `${thousands_separators(data.item.delivery_fees)}`
              }else {
                return `0`
              }
            }
          },
          {
            "data":null,
             render:function(data, type, full, meta){
              var wayediturl="{{route('items.edit',":id")}}"
              wayediturl=wayediturl.replace(':id',data.item.id);
              var waydeleteurl="{{route('deletewayassign',":id")}}"
              waydeleteurl=waydeleteurl.replace(':id',data.item.id);
              // var rejectwaybystaff = "{{route('rejectwaybystaff',":id")}}";
              // rejectwaybystaff=rejectwaybystaff.replace(':id',data.id);


             
                return `<a href="#" class="btn btn-sm btn-primary detail" data-id="${data.item.id}">{{ __("Detail")}}</a>
                      <a href="${wayediturl}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                      `
              
             }
          }
         ],



         footerCallback: function ( row, data) {


            var table = $('#onwaytable').DataTable();

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
              
              let nototal = api
                .column(0, { page: 'current'} )
                .data()
                .length

              // var price = data[0].item.deposit;
            delivery_fee_total =  api
                .column(8 )
                .data()
                .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
                    
                }, 0 );

            delivery_fee_pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b) ;
                    
                }, 0 );

            price_total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            price_pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // price_confirm_total = price_pageTotal+price_confirm;
            // delivery_fees_confirm_total = delivery_fee_pageTotal+delivery_fees_confirm;
            // console.log(price_pageTotal);
            // Update footer
            $( api.column( 0 ).footer() ).html(
                // '$'+(delivery_fee_pageTotal)+
                 thousands_separators(nototal) ,
            );

            $( api.column( 7 ).footer() ).html(
                // '$'+(delivery_fee_pageTotal)+
                 thousands_separators(price_pageTotal) ,
            );

            $( api.column( 8 ).footer() ).html(
                // '$'+(delivery_fee_pageTotal)+
                thousands_separators( delivery_fee_pageTotal ),
            );

            }
        },
         "info":false
        });
      }

    

      $('.btn_reject').click(function(e){
        
        e.preventDefault();
        $('#rejectModal').modal('show');
        var id=$(this).data('id');
        $("#rejectway").val(id);
      })

      $(".btnreject").click(function(){
        var wayid=$("#rejectway").val();
        var remark= $(".rejectremark").val();
        var url="{{route('rejectwaybystaff')}}";
         $.ajax({
          url:url,
          type:"post",
          data:{wayid:wayid,remark:remark},
          dataType:'json',
          success:function(response){
            if(response.success){
              $('#rejectModal').modal('hide');
              $('.Ejremark').text('');
              $('span.error').removeClass('text-danger');
              $('.alertsuccess').removeClass('d-none');
              $('.alertsuccess').show();
              $('.alertsuccess').text('successfully added to reject list');
              $('.alertsuccess').fadeOut(3000);
              location.reload();
            }
          },
          error:function(error){
            var message=error.responseJSON.message;
            var errors=error.responseJSON.errors;
            console.log(error.responseJSON.errors);
            if(errors){
              var remark=errors.remark;
              $('.Ejremark').text(remark);
              $('span.error').addClass('text-danger');
            }
          }
        })
      })
      

      //item detail
      $("#onwaytable tbody").on('click','.detail',function(){
        var id=$(this).data('id');
        //console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.post('itemdetail',{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);
          if(res.error_remark != null){
            $('#error_remark').removeClass('d-none')
            $("#error_remark").html(`<strong>Date Changed Remark:</strong> <span class="text-warning">${res.error_remark}</span>`)
          };
          var price =  `${thousands_separators(res.deposit)}`;
          var deli_fee = `${thousands_separators(res.delivery_fees)}`;
          var total = res.deposit + res.delivery_fees;
          var total_amount = `${thousands_separators(total)}`;
          $('#rtotal').html(total_amount);
          $('#rprice').html(price);
          $('#rdfee').html(deli_fee);
          $(".rcode").html(res.codeno);
        })
      })


      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
      $('#checktable').dataTable({
        "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
        "pageLength": 500,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "bStateSave": true,
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ -1,0] }
        ]
      });

      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


      $('.wayassign').click(function () {
        var ways = [];
        var oTable = $('#checktable').dataTable();
        // console.log(oTable);
        var rowcollection = oTable.$("input[name='assign[]']:checked", {"page": "all"});
        
        $.each(rowcollection,function(index,elem){
          let wayObj = {id:$(elem).val(),codeno:$(elem).data('codeno')};
          ways.push(wayObj);
        });

        // console.log(ways)
        var html="";
        for(let way of ways){
          html+=`<input type="hidden" value="${way.id}" name="ways[]"><span class="badge badge-primary mx-2">${way.codeno}</span>`;
        }
        $('#selectedWays').html(html);

        $('#wayAssignModal').modal('show');
      })

      //item detail
      $(".dataTable tbody").on('click','.detail',function(){
        var id=$(this).data('id');
        //console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.post('itemdetail',{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);

          if(res.error_remark != null){
            $('#error_remark').removeClass('d-none')
            $("#error_remark").html(`<strong>Date Changed Remark:</strong> <span class="text-warning">${res.error_remark}</span>`)
          }

          $(".rcode").html(res.codeno);
        })
      })

      //check detail
      $("#checktable tbody").on('click','.detail',function(){
        var id=$(this).data('id');
        //console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.post('itemdetail',{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);

          if(res.error_remark != null){
            $('#error_remark').removeClass('d-none')
            $("#error_remark").html(`<strong>Date Changed Remark:</strong> <span class="text-warning">${res.error_remark}</span>`)
          }

          $(".rcode").html(res.codeno);
        })
      })
      
      $('.js-example-basic-multiple').select2({
        width: '100%',
        dropdownParent: $('#wayAssignModal')
      });

      $('.js-example-basic-single').select2({
        width: '100%',
        dropdownParent: $('#editwayAssignModal')
      });

       $('.deliverymanway').select2({
        width: '100%',
      })

      var submit = $("#submit_assign").hide();
      cbs = $('.dataTable tbody').on('click', 'input[name="assign[]"]', function () {
      // cbs = $('input[name="assign[]').click(function() {
      // submit.toggle(cbs.is(":checked") , 2000);
      // submit.toggle(cbs.is(":checked"));
        if($('.dataTable tbody :input[type="checkbox"]:checked').length>0)
        {
          $("#submit_assign").show();
        }else{
          $("#submit_assign").hide();
        }
        // submit.toggle();
        console.log(submit)
      });
      // console.log($cbs)

      $(".wayedit").click(function(){
        $('#editwayAssignModal').modal('show');
        var id=$(this).data("id");
        //console.log(id);
        $("#wayid").val(id);
      })


     /*setTimeout(function(){
      window.location.reload(1);
    }, 90000);*/


    // $(".deliverymanway").change(function(){
    //   //alert("ok");
    //   var id=$(this).val();
    //   //console.log(id);
    //   var url="{{route('waybydeliveryman')}}";
      
       
    //   $.post(url,{id:id},function(res){
    //     // getway(res);
    //     // var html="";
    //     // console.log(res);
    //     let deposit_total=0;
    //     let delivery_total=0;

    //     $.each(res,function(i,v){
    //       let payment_type = "";
    //       let allpaid = "";
    //       deposit_total += Number(v.item.deposit)
    //       delivery_total+= Number(v.item.delivery_fees)

    //       if (v.item.paystatus==2) {
    //         payment_type = "allpaid"
    //         allpaid = "table-warning"
    //         delivery_total -= Number(v.item.delivery_fees)
    //       }else if (v.item.paystatus==3) {
    //         payment_type = "only deli"
    //       }else if (v.item.paystatus==4) {
    //         payment_type = "only item price"
    //       }
    //       html+=`<tr class="${allpaid}">
    //             <td class="align-middle">${++i}</td>
    //             <td class="align-middle">${v.item.codeno} <span class="badge badge-danger badge-pill">${payment_type}</span></td>
    //             <td class="align-middle">${v.item.assign_date}</td>
    //             <td class="align-middle">${v.item.pickup.schedule.client.user.name}</br>(${v.item.pickup.schedule.client.phone_no})</td>
    //             <td class="align-middle">${v.item.receiver_name}</td>
    //             <td class="align-middle">${v.item.township.name}</td>
    //             <td class="align-middle">${thousands_separators(v.item.deposit)}</td>
    //             <td class="align-middle">${thousands_separators(v.item.delivery_fees)}</td>
    //             <td class="align-middle">${thousands_separators(v.item.other_fees)}</td>
                
    //           </tr>`
    //     })
    //     html+=`<tr>
    //               <td colspan="6">Total Amount</td>
    //               <td >${thousands_separators(deposit_total)} Ks</td>
    //               <td colspan="2">${thousands_separators(delivery_total)} Ks</td>
    //             </tr>`;
    //     $(".tbody").html(html);

    //     if(res.length==0){
    //        $("#export").hide();
    //     }else{
    //       $("#export").show();
    //     }
       
    //     $("#exportid").val(id);
    //   })

    // })
    $(".deliverymanway").change(function(){

          let deposit_total=0;
          let delivery_total=0;
          let payment_type = "";
          let allpaid = "";
          var length = 0;
          var url = "{{route('waybydeliveryman')}}";
          var id=$(this).val();
          var table = $('.printway').DataTable();
          var array = new Array();
          table.destroy();
          
        $('.printway').dataTable({
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
            data : {
              'id': id,

            },
            url: url,
            type: "POST",
            dataType:'json',
            
          },

          "columns": [

          {"data":'DT_RowIndex'},
          {"data": null,
          render:function(data, type, full, meta,row){
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

            array.push(data);
            length += array.length;
            if(data.status_code=="001"){
              state = `<span class="badge badge-info badge-pill">success</span>`
            }else if(data.status_code=="002"){
              state = `<span class="badge badge-warning badge-pill">return</span>`
            }else if(data.status_code=="003"){
              state = `<span class="badge badge-danger badge-pill">reject</span>`
            }else if(data.remark && data.status_code == "005"){
              state = `<span class="badge badge-danger badge-pill">reject</span>`
              
            }
            else{
              state = `<span class="badge badge-dark badge-pill">assign</span>`
            }

            return `<span class="d-block">${data.item.codeno}</span>
                    <span class="badge badge-info badge-pill">${paystatus}</span> ${state}`
            
          }
        },
        {
          "data":null,
            render:function(data){
              // var date=new Date(data);
              // date =date.toLocaleDateString(undefined, {day:'2-digit'})+'-'+date.toLocaleDateString(undefined, {month:'numeric'})+'-'+date.toLocaleDateString(undefined, {year:'numeric'});
               return formatDate(data.item.assign_date);
            }
        },
        {
          "data":"item.pickup.schedule.client.user.name"
          
        },
        {
          "data":"item.receiver_name"
          
        },
        // {
        //   "data":"delivery_man.user.name"
        // },
        {
          "data":null,
          render:function(data){
            if(data.item.township){
                return data.item.township.name
              }
              else if(data.item.sender_gate){
                return data.item.sender_gate.name
              }else{
                return data.item.sender_postoffice.name
              }
            }
          
        },
        {
          data:function(data,row){
            if(data.item.paystatus == 1 || data.item.paystatus == 4){
                return `${thousands_separators(data.item.deposit)}`
            }else {
              return `0`
            }
          }
        },

        {
          data:function(data,row){
            let delivery_fees;
            if (data.item.paystatus == "2" || data.item.paystatus == "4") {
              delivery_fees = 0;
            }else{
              delivery_fees = data.item.delivery_fees;
            }

            return `${thousands_separators(delivery_fees)}`
          }
        },
        

        // {
        //   "data":"item.other_fees",
        //   render:function(data,row){
        //     return `${thousands_separators(data)}`
        //   }
        // },
        // {
        //   "data":null,
        //   render:function(data){
        //     array.push(data);
        //     if(array.length == 0){
        //       $("#export").hide();
        //     }else{
        //       $("#export").show();
        //     }
        //   }
        // }
        
       ],


       footerCallback: function ( row, data) {


            var table = $('.printway').DataTable();

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
              
              
              let nototal = api
                .column(0, { page: 'current'} )
                .data()
                .length
                
            delivery_fee_total =  api
                .column(7 )
                .data()
                .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
                    
                }, 0 );

            delivery_fee_pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b) ;
                    
                }, 0 );

            price_total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            price_pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // price_confirm_total = price_pageTotal+price_confirm;
            // delivery_fees_confirm_total = delivery_fee_pageTotal+delivery_fees_confirm;
            // console.log(price_pageTotal);
            // Update footer
            // $( api.column( 6 ).footer() ).html(
            //     // '$'+(delivery_fee_pageTotal)+
            //      thousands_separators(price_pageTotal) ,
            // );
            $( api.column( 0 ).footer() ).html(
                // '$'+(delivery_fee_pageTotal)+
                 nototal ,
            );

            $( api.column( 7 ).footer() ).html(
                // '$'+(delivery_fee_pageTotal)+
                thousands_separators( delivery_fee_pageTotal + price_pageTotal),
            );

            }
        },
        
       "info":false

     });

        $("#exportid").val(id);

        
      })



      // Y/M/D into D/M/Y
      function formatDate (input) {
        var datePart = input.match(/\d+/g),
        year = datePart[0].substring(0,4), // get only two digits
        month = datePart[1], day = datePart[2];
        return day+'-'+month+'-'+year;
      }




    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }



    })

   
  </script>
@endsection