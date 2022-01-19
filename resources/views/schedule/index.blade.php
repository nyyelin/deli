@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Schedules")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">{{ __("Schedules")}}</a></li>
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

        <input type="hidden" name="rolename" value="{{$rolename}}" id="rolename">
        <input type="hidden" name="" value="" id="notidata">
        <div class="tile">
          <h3 class="tile-title d-inline-block">{{ __("Pickup List")}}</h3>
          @role('staff||client')
          <a href="{{route('schedules.create')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> {{ __("Add New")}}</a>
          @endrole

          <div class="bs-component">
            @role('staff')
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link @role('client'){{'active'}}@endrole" data-toggle="tab" href="#schedules">{{ __("Schedules")}}</a></li>
              <li class="nav-item"><a class="nav-link @role('staff|admin'){{'active'}}@endrole" data-toggle="tab" href="#assigned">{{ __("Assigned")}}</a></li>
            </ul>
            

            @endrole
            @role('admin')
            <ul class="nav nav-tabs">
              
              <li class="nav-item"><a class="nav-link @role('staff|admin'){{'active'}}@endrole" data-toggle="tab" href="#assigned">{{ __("Assigned")}}</a></li>
            </ul>
            @endrole

            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade @role('client'){{'active show'}}@endrole" id="schedules">
                <div class="table-responsive">
                  <table class="table schedule_dataTable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Pickup Date")}}</th>
                        @role('staff')<th>{{ __("Client Name")}}</th>@endrole
                        <th>{{ __("Remark")}}</th>
                        <th>{{ __("Quantity")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1; @endphp
                      @foreach($schedules as $row)
                      <tr>
                        <td class="align-middle">{{$i++}}</td>
                        <td class="align-middle">{{\Carbon\Carbon::parse($row->pickup_date)->format('d/m/Y')}}
                        </td>@role('staff')
                          <td class="text-danger">{{$row->client->user->name}}</td>
                        @endrole
                        <td class="align-middle">{{$row->remark}}</td>
                        <td class="align-middle">{{$row->quantity}}</td>
                        <td class="align-middle">
                          @role('staff')
                            <a href="#" class="btn btn-sm btn-primary assign" data-id="{{$row->id}}">{{ __("Assign")}}</a>
                            <a href="#" class="btn btn-sm btn-info showfile" data-file="{{$row->file}}">{{ __("show file")}}</a>
                          @endrole
                          @role('client')
                            @if($row->status == 0)
                            <a href="{{route('schedules.edit',$row->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                            @else
                            <button class="btn btn-sm btn-info">{{ __("Complete")}}</button>
                            @endif
                          @endrole
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade @role('staff|admin'){{'active show'}}@endrole" id="assigned">

              @role('staff')

              <div class="row my-4">
                <div class="col-md-3">
                  <label for="InputStartDate">{{ __("Start Date")}}:</label>
                  <input type="date" name="start_date" class="start_date form-control" id="InputStartDate">
                </div>
                <div class="col-md-3">
                  <label for="InputEndDate">{{ __("End Date")}}:</label>
                  <input type="date" name="end_date" class="end_date form-control" id="InputEndDate">
                </div>
                <div class="col-md-3">
                  <button class="btn btn-success mt-4 btn_search">Search</button>
                </div>
              </div>

              @endrole


                <div class="table-responsive assign_table_div">
                  <table class="table checktable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Pickup Date")}}</th>
                        @role('staff||admin')<th>{{ __("Client Name")}}</th>@endrole
                        <th>{{ __("Remark")}}</th>
                        
                        <th>{{ __("Qty")}}  </th>
                        <th>{{ __("In Stock")}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Total")}}</th>
                        <th>{{ __("Prepaid Amount")}}</th>
                        <th>{{ __("Delivery Man")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody class="assigntbody">
                      @php 
                        $i=1; $total = 0;$total_stock_qty=0;
                        $pickup_qty = 0;
                        $pickup_amount = 0;
                      @endphp
                     
                      @foreach($pickups as $row)
                      @php
                      $data_amount = 0;
                      $total_stock_qty+=count($row->items);
                      $pickup_qty += $row->schedule->quantity;
                      $pickup_amount += $row->schedule->amount;

                      @endphp

                      @if($row->schedule)
                      
                          @foreach($row->items as $value)
                            @if($value->pickup_id == $row->id)
                              @php
                                $data_amount += $value->deposit;
                                $total += $value->deposit;
                              @endphp
                            @endif
                          @endforeach

             
                          
                        <tr>
                          <td class="align-middle">{{$i++}}</td>
                          <td class="align-middle">{{\Carbon\Carbon::parse($row->schedule->pickup_date)->format('d-m-Y')}}</td>
                          @role('staff||admin')<td class="text-danger align-middle">{{$row->schedule->client->user->name}}</td>@endrole
                          <td class="align-middle">{{$row->schedule->remark}}</td>
                          
                          <td class="align-middle">{{$row->schedule->quantity}}</td>
                          <td class="align-middle">@if($row->items){{count($row->items)}}@else 0 @endif</td>
                          <td class="align-middle"> {{number_format($row->schedule->amount)}}  </td>
                          <td class="align-middle"> {{number_format($data_amount)}} </td>
                          <td class="align-middle">
                            @if($row->expense)
                              {{number_format($row->expense->amount)}}
                            @else
                              {{'-'}}
                            @endif
                          </td>
                          <td class="text-danger align-middle">{{$row->delivery_man->user->name}}
                            @foreach($data as $dd)
                              @if($dd->id==$row->id)
                              <span class="badge badge-info seen">seen</span>
                              @endif
                            @endforeach
                          </td>
                          <td class="align-middle">

                            @role('admin')
                            @if($row->status == 4)

                              <button type="button" class="btn btn-sm btn-info">{{ __("completed")}}</button>
                              <a href="{{route('pickupstatuschangebyadmin',$row->id)}}" class="btn btn-sm btn-warning">{{__("edit")}}</a>

                            @else

                              <button type="button" class="btn btn-sm btn-primary">{{ __("Collecting")}}</button>

                            @endif

                            @endrole


                            @if($row->status==1)
                              @role('staff')
                                <a href="{{route('items.collect',['cid'=>$row->schedule->client->id,'pid'=>$row->id])}}" class="btn btn-sm btn-primary">{{ __("Collect")}}</a>
                              @endrole
                              @role('client')
                                <button type="button" class="btn btn-sm btn-info">{{ __("Brought")}}</button>
                              @endrole

                            @elseif($row->status == 4)

                            @role('staff')
                              <button type="button" class="btn btn-sm btn-info">{{ __("completed")}}</button>
                            @endrole

                            
                              @if($row->expense)
                                @if($row->expense->description == 'Client Deposit')
                                <button type="button" class="btn btn-sm btn-warning editprepaid" data-id="{{$row->id}}" data-amount="{{$row->expense->amount}}">Edit Prepaid Amount</button>
                                @endif
                              @endif
                          @elseif($row->status==2)
                            <a href="{{route('checkitem',$row->id)}}" class="btn btn-sm btn-danger">{{ __("fail")}}</a>
                          @elseif($row->status==3)
                            <a href="#" class="btn btn-sm btn-secondary addamount" data-id="{{$row->schedule->id}}">{{ __("Add amount and qty")}}</a>
                          @else
                            <button type="button" class="btn btn-sm btn-danger">{{ __("pending")}}</button>
                          @endif

                            @role('staff|client')
                
                          @if($row->status != 4)
                            <a href="{{route('schedules.edit',$row->schedule->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>

                          @if(count($row->items) == 0 || $row->status == 0)
                            <form action="{{ route('schedules.destroy',$row->schedule->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger">{{ __("Delete")}}</button>
                            </form>
                          @endif
                          
                          @endif

                            @if(count($row->items) > 0)
                              <a href="{{route('checkitems',$row->id)}}" class="btn btn-sm btn-dark">{{__("check")}}</a>
                            @endif

                        @endrole
                        </td>
                      </tr>
                      @endif

                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td class="align-middle">{{count($pickups)}}</td>
                        
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle">
                          {{$pickup_qty}}
                        </td>
                        <td class="align-middle">{{$total_stock_qty}}</td>
                        <td class="align-middle">
                          {{$pickup_amount}}
                        </td>

                        <td class="align-middle">
                        @if(count($pickups)>0)
                        {{number_format($total)}}
                        @else
                        0
                        @endif
                        </td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                        <td class="align-middle"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                 
                <div class="table-responsive search_table_div">
                  <table class="table search_table">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Pickup Date")}}</th>
                        @role('staff||admin')<th>{{ __("Client Name")}}</th>@endrole
                        <th>{{ __("Remark")}}</th>
                        
                        <th>{{ __("Qty")}}  </th>
                        <th>{{ __('In Stock')}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Total")}}</th>
                        <th>{{ __("Prepaid Amount")}}</th>
                        <th>{{ __("Delivery Man")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody >
                      
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
                        <td class="align-middle"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- Assign modal --}}
  <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Assign Delivery Man")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('schedules.storeandassign')}}" method="POST" enctype="multipart/form-data">
            @csrf
          <input type="hidden" name="assignid" id="assignid" value="">
          <select class="form-control" name="deliveryman">
            <optgroup label="Choose Delivery Man">
              <option>{{ __("Choose Delivery Man")}}</option>
              @foreach($deliverymen as $row)
              <option value="{{$row->id}}">{{$row->user->name}}</option>
              @endforeach
            </optgroup>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
          <button type="submit" class="btn btn-primary">{{ __("Assign")}}</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  {{-- addfile modal --}}
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Add File")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('uploadfile')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="addid" id="addid" value="">
            <input type="hidden" name="oldfile" id="oldfile">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __("New file")}}</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __("Old file")}}</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="form-group">
                  <input type="file"  id="addfile" name="addfile">
                 </div>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <img src="" class="myoldfile img-fluid">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ __("Save")}}</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  {{-- show file modal --}}
  <div class="modal fade" id="filedisplay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("File")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img src="" class="img-fluid stafffile" width="100%" height="100%">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
        </div>
      </div>
    </div>
  </div>

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

  {{--Add amount modal--}}
  <div class="modal fade" id="editprepaid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Edit Prepaid Amount!")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="pickup" id="pickup_id" value="">
          <div class="form-group prepaidamount">
            <label for="prepaidamount">{{ __("Amount")}}:</label>
            <input type="number" id="prepaidamount" class="form-control" name="prepaidamount">
            <span class="Equantity error d-block" ></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary prepaidamountsave">{{ __("Save")}}</button>
        </div>
      </div>
    </div>
  </div>

@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      $.ajaxSetup({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('.assign_table_div').show();
      $('.search_table_div').hide();

      $('.schedule_dataTable').dataTable({
        "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
        "pageLength": 500,
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




      $('.checktable').dataTable({
        "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
        "pageLength": 100,
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

     

      var notiurl="{{route("getnoti")}}";
      $.get(notiurl,function(res){
       //console.log(res);
        $("#notidata").val(JSON.stringify(res));
        // assign_table();
      // $('.search_table').hide();

      })

      $('.assign').click(function () {
        $('#assignModal').modal('show');
        var id=$(this).data(id);
        $("#assignid").val(id.id);
      })

      $('.addfile').click(function () {
        $('#addModal').modal('show');
        var id=$(this).data(id);
        var file=$(this).data(file);
        console.log(file.file);
        //console.log(id.id);
        $("#addid").val(id.id);
        $("#oldfile").val(file.file);
        $(".myoldfile").attr("src",file.file)
      })

      $(".showfile").click(function(){
        $('#filedisplay').modal('show');
        var file=$(this).data("file");
        //console.log(file);
        $(".stafffile").attr("src",file);
      })

      $(".assigntbody").on('click','.addamount',function(e){
        e.preventDefault();
        $('#addamount').modal('show');
        var id=$(this).data('id');
        $("#schedule_id").val(id);
      })

      $(".assigntbody").on('click','.editprepaid',function(e){
        e.preventDefault();
        $('#editprepaid').modal('show');
        var id=$(this).data('id');
        var amount = $(this).data('amount');
        $("#pickup_id").val(id);
        $("#prepaidamount").val(amount);

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
              location.href="{{route('schedules.index')}}";
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

      $(".prepaidamountsave").click(function(){
        var pickup_id=$("#pickup_id").val();
        var prepaidamount=$("#prepaidamount").val();
        // var bank_id=$("#bank").val();
        var url="{{route('editprepaidamount')}}";
          
        $.ajax({
          url:url,
          type:"post",
          data:{pickup_id:pickup_id,prepaidamount:prepaidamount},
          dataType:'json',
          success:function(response){
            if(response.success){
               $('#prepaidamount').modal('hide');
               $('.Eamount').text('');
              $('span.error').removeClass('text-danger');
              location.href="{{route('schedules.index')}}";
            }
          },
          error:function(error){
            var message=error.responseJSON.message;
            var errors=error.responseJSON.errors;
            console.log(error.responseJSON.errors);
            if(errors){
              var amount=errors.amount;
              $('.Eamount').text(amount);
              $('span.error').addClass('text-danger');
            }
          }
        })

      })

      $('.btn_search').click(function(){
        var rolename = $('#rolename').val();
        $('.assign_table_div').hide();
        $('.search_table_div').show();
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        var route="{{route('pickupBydate')}}";
        // alert(route);

        $('.search_table').dataTable({
          "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],

          "pageLength": 500,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": true,
          "stateSave": true,
          destroy:true,
          "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ -1,0] }
          ],
          "bserverSide": true,
          "bprocessing":true,
          "stateSave": true,
          "ajax": {
            url: route,
            type: "POST",
            data : {start_date:start_date,end_date:end_date},
            dataType:'json',
          },
          "columns": [
          {"data":'DT_RowIndex'},

          {"data": "schedule.pickup_date",
            render:function(data){
              return formatDate(data);
            }
          },
          {
            "data":null,
            render:function(data){
              return `<p class="text-danger">${data.schedule.client.user.name}</p>`
            }
            
          },
          {
            "data":"schedule.remark",

          },

          

          {"data":'schedule.quantity'},

          {data:function(data){
            var total_qty = 0;

              if(data.items){
                
                total_qty = data.items.length;

              }else{
                total_qty = 0;
              }
              return `${total_qty}`
            }
          },

          {"data":null,
            render:function(data){
              return `${thousands_separators(data.schedule.amount)}`;
            }
          },

          {
            data:function(data){
            var total_amount = 0;

              // console.log(data.items.deposit);
              // var total_amount = 0;
              if(data.items.length > 0){
                $.each(data.items,function(i,v){
                  total_amount += Number(v.deposit);

                })
              }else{
                total_amount = 0
              }
              // total_amount += data.item.deposit;
              return `${thousands_separators(total_amount)}`;
            }
          },

          {"data":null,
            render:function(data){
              // console.log(data)
              var total_expense_amount = 0;
              if(data.expenses.length > 0){
                $.each(data.expenses,function(a,b){
                  total_expense_amount += Number(b.amount);
                })
                return `${thousands_separators(total_expense_amount)}`
              }else{
                return '-';
              }          
            }
          },

          {
            "data":null,
            render:function(data){
              return `<p class="text-danger">${data.delivery_man.user.name}</p>`
            }
          },

          {data:function(data){
              // return "hi"
              var html = '';
              // console.log(data.items.length);
                if(data.status==1){
                  if(rolename == 'staff'){

                    var item_collect = `{{route('items.collect',['cid'=>':client_id','pid'=>':pickup_id'])}}`;

                    item_collect = item_collect.replace(":client_id", data.schedule.client.id);
                    item_collect = item_collect.replace(":pickup_id", data.id);

                    html += `<a href="${item_collect}" class="btn btn-sm btn-primary d-inline-block mx-2">{{ __("Collect")}}</a>`
                  }
                  
                  else if(rolename == 'client'){
                   html+= `<button type="button" class="btn btn-sm btn-info d-inline-block">{{ __("Brought")}}</button>`
                  }
                }else if(data.status == 4){

                  if(rolename=='staff'){
                    html += `<button type="button" class="btn btn-sm btn-info d-inline-block">{{ __("completed")}}</button>`
                  }

                  if(data.expenses.length > 0 ){
                      html += `<button type="button" class="btn btn-sm btn-warning editprepaid" data-id="${data.id}" data-amount="${data.expense.amount}">Edit Prepaid Amount</button>`
                   }
               }else if(data.status==3){
                  html += `<a href="#" class="btn btn-sm btn-secondary addamount" data-id="${data.schedule.id}">{{ __("Add amount and qty")}}</a>`
                }
                else if(data.status == 0){
                  html += `<button type="button" class="btn btn-sm btn-danger mx-2">{{ __("pending")}}</button>`
                }

            
              if(rolename == 'admin'){

                var pickupstatuschangebyadmin = '{{route('pickupstatuschangebyadmin',':id')}}';
                pickupstatuschangebyadmin = pickupstatuschangebyadmin.replace(":id",data.id);


                if(data.status == 4){
                  html += `<button type="button" class="btn btn-sm btn-info">{{ __("completed")}}</button>`
                  if(data.status != 5){
                    html += `<a href="${pickupstatuschangebyadmin}" class="btn btn-sm btn-warning d-inline-block mx-2">{{__("edit")}}</a>`
                  }
                }else{
                  html += `<button type="button" class="btn btn-sm btn-primary d-inline-block mx-2">{{ __("Collecting")}}</button>`
                }

              }

              if(rolename == 'staff' || rolename == 'client'){
                var schedule_route = `{{route('schedules.edit',':schedule_id')}}`;
                schedule_route = schedule_route.replace(':schedule_id',data.schedule.id);
        
                if(data.status != 4){
                  if(data.status != 5){
                    html += `<a href="${schedule_route}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>`
                  }

                }

                if((data.status == 0 || data.status == 1) && data.items.length == 0){
                  var schedule_destroy_route = `{{ route('schedules.destroy',':schedule_destroy_id') }}`;
                  schedule_destroy_route = schedule_destroy_route.replace(':schedule_destroy_id', data.schedule.id);

                  html += `<form action="${schedule_destroy_route}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __("Delete")}}</button>
                              </form>`

                 
                }

                if(data.items.length > 0){
                  var checkitems = `{{route('checkitems',':checkitems_id')}}`;
                  checkitems = checkitems.replace(':checkitems_id',data.id)
                  html+= `<a href="${checkitems}" class="btn btn-sm btn-dark d-inline-block mx-2">{{__("check")}}</a>`
                }

                if (data.status == 5) {
                  html+= `<button type="button" class="btn btn-sm btn-success">Cleared</button>`
                }
               
              }
              return html;
                  
            }


          }
          
         ],
          footerCallback: function ( row, data) {
            var table = $('.search_table').DataTable();

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


              total_stock_qty = api
                  .column(5 ,{ page: 'current'})
                  .data()
                  .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                      
                  }, 0 );

              alltotal =  api
                  .column(7 ,{ page: 'current'})
                  .data()
                  .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                      
                  }, 0 );



              // Update footer
              $( api.column( 0 ).footer() ).html(
                  // '$'+(delivery_fee_pageTotal)+
                   thousands_separators(data.length) ,
              );

              $( api.column( 5 ).footer() ).html(
                  // '$'+(delivery_fee_pageTotal)+
                   thousands_separators(total_stock_qty) ,
              ); 

              $( api.column( 7 ).footer() ).html(
                  // '$'+(delivery_fee_pageTotal)+
                   thousands_separators(alltotal) ,
              );  
              
            }else{
              // Update footer
              $( api.column( 0 ).footer() ).html(
                  // '$'+(delivery_fee_pageTotal)+
                   thousands_separators(0) ,
              );


              $( api.column( 5 ).footer() ).html(
                  // '$'+(delivery_fee_pageTotal)+
                   thousands_separators(0) ,
              ); 

              $( api.column( 7 ).footer() ).html(
                  // '$'+(delivery_fee_pageTotal)+
                   thousands_separators(0) ,
              );
            }
          },
         
         "info":false
        });
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

      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    })
  </script>
@endsection