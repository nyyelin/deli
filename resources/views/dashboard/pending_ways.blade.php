@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        @php $mytime = Carbon\Carbon::now(); @endphp
        <h1><i class="fa fa-dashboard"></i> {{ __("Pending Ways")}} ({{$mytime->toFormattedDateString()}})</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('pending_ways')}}">{{ __("Pending Ways")}}</a></li>
      </ul>
    </div>

    {{-- <div class="row">
      <div class="col-md-12">
        <div class="tile">
          
          <h3 class="tile-title d-inline-block">Pending Ways List </h3>

          <div class="float-right actions">
            <a href="#" class="btn btn-success btn-sm mx-2 success">Success</a>
          </div>

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="home" aria-selected="true">Pending ways</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#success" role="tab" aria-controls="profile" aria-selected="false">success ways</a>
            </li>

          </ul>
          <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="home-tab">
              <div class="col-12">
              <div class="alert alert-primary success d-none" role="alert"></div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Codeno</th>
                      <th>Township</th>
                      <th>Receiver Info</th>
                      <th>Expired Date</th>
                      <th>Amount</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($ways as $way)
                    <tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="ways[]" value="{{$way->id}}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>
                        {{$way->item->codeno}}
                        @if($way->status_code == '001')
                        <span class="badge badge-info">{{'success'}}</span>
                        @elseif($way->status_code == '002')
                        <span class="badge badge-warning">{{'return'}}</span>
                        @elseif($way->status_code == '003')
                        <span class="badge badge-danger">{{'reject'}}</span>
                        @endif

                      </td>
                      <td class="text-danger">{{$way->item->township->name}}</td>
                      <td>
                        {{$way->item->receiver_name}} <span class="badge badge-dark">{{$way->item->receiver_phone_no}}</span>
                      </td>
                      <td class="text-danger">{{$way->item->expired_date}}</td>
                      <td>{{number_format($way->item->amount)}}</td>
                      <td>
                        @if($way->status_code == 005)
                            <a href="#" class="btn btn-info btn-sm success" data-id="{{$way->id}}">Success</a>
                            <a href="#" class="btn btn-warning btn-sm return" data-id="{{$way->id}}">Return</a>
                            <a href="#" class="btn btn-danger btn-sm reject" data-id="{{$way->id}}">Reject</a>
                        @endif
                        <a href="#" class="btn btn-sm btn-primary detail" data-id="{{$way->item->id}}">Detail</a> 
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="success" role="tabpanel" aria-labelledby="profile-tab">
              <div class="table-responsive">
                <table class="table table-bordered dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Codeno</th>
                      <th>Township</th>
                      <th>Receiver Info</th>
                      <th>Expired Date</th>
                      <th>Amount</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i=1 @endphp
                    @foreach($successways as $way)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>
                        {{$way->item->codeno}}

                      </td>
                      <td class="text-danger">{{$way->item->township->name}}</td>
                      <td>
                        {{$way->item->receiver_name}} <span class="badge badge-dark">{{$way->item->receiver_phone_no}}</span>
                      </td>
                      <td class="text-danger">{{$way->item->expired_date}}</td>
                      <td>{{number_format($way->item->amount)}}</td>
                      <td>
                        <a href="{{route('normal',$way->id)}}" class="btn btn-warning">edit</a>
                        <a href="#" class="btn btn-primary detail" data-id="{{$way->item->id}}">Detail</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    <div class="row">
       <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="form-group">
              <label for="dtownship">{{ __("Select Township")}}:</label>
                <select class="js-example-basic-single" id="dtownship" name="dtownship">
                  <option value="">Choose Your Townships</option>
                    @foreach($townships as $row)
                    <option value="{{$row->township_id}}">{{$row->township_name}}</option>
                    @endforeach
                </select>
          </div>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="form-group">
              <label for="dgate">{{ __("Select Gate")}}:</label>
                <select class="js-example-basic-single" id="dgate" name="dgate">
                  <option value="">Choose Your Gate</option>
                    @foreach($gates as $row)
                    <option value="{{$row->gate_id}}">{{$row->gate_name}}</option>
                    @endforeach
                </select>
          </div>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="form-group">
          <label for="doffice">{{ __("Select Post Office")}}:</label>
          <select class="js-example-basic-single" id="doffice" name="doffice">
            <option value="">Choose Your Post Office</option>
            @foreach($postoffices as $row)
              <option value="{{$row->office_id}}">{{$row->office_name}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <div class="row mypendingrow">
      <div class="col-12">
        <div class="alert alert-primary alertsuccess d-none" role="alert"></div>
      </div>
     
      @foreach($pending_ways as $row)
      <div class="col-md-4">
        <div class="card mb-3">
          <h5 class="card-header">{{$row->item->receiver_name}}
            @if($row->status_code == '001')
            <span class="badge badge-info">{{'success'}}</span>
            @elseif($row->status_code == '002')
            <span class="badge badge-warning">{{'return'}}</span>
            @elseif($row->status_code == '003')
            <span class="badge badge-danger">{{'reject'}}</span>
            @endif
            <small class="float-right">
              <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
              @if($row->item->expired_date == null)
                {{Carbon\Carbon::parse($row->item->assign_date)->format('d-m-Y')}}
              @else
                {{Carbon\Carbon::parse($row->item->expired_date)->format('d-m-Y')}}
              @endif
            </small>
          </h5>
          <div class="card-body">
            <h5 class="card-title">{{ __("Item Code")}}: {{$row->item->codeno}}</h5>
            <h5 class="card-title">{{ __("Delivered Address")}}: 
              @if($row->item->sender_gate_id != null)
                {{$row->item->SenderGate->name}}
              @elseif($row->item->sender_postoffice_id != null)
                {{$row->item->SenderPostoffice->name}}
              @else
                {{$row->item->township->name}}
              @endif
            </h5>
            @if($row->item->receiver_address!=null)
            <p class="card-text">{{ __("Full Address")}}:{{$row->item->receiver_address}}</p>
            @endif

            @if($row->item->receiver_phone_no!=null)
            <p class="card-text">
              {{ __("Receiver Phone No")}}:{{$row->item->receiver_phone_no}}
            </p>
            @endif
            <p class="card-text">
             Client {{ __("Name")}}: {{$row->item->pickup->schedule->client->user->name}}
            </p>
            <p class="card-text">
             Client {{ __("Phone No")}}: {{$row->item->pickup->schedule->client->phone_no}}
            </p>
            <p class="card-text">
              @if($row->item->paystatus==1)
                {{ __("Amount")}}: {{number_format($row->item->amount)}} Ks
               {{-- <span class="badge badge-success">Unpaid!</span> --}}
              @elseif($row->item->paystatus==3)
                {{ __("Amount")}}: {{$row->item->delivery_fees}} Ks
               <span class="badge badge-success">Only Deli!</span>
              @elseif($row->item->paystatus==4)
                {{ __("Amount")}}: {{$row->item->deposit}} Ks
               <span class="badge badge-success">Only Item Price!</span>
              @else
               <span class="badge badge-success">All Paid!</span>
              @endif
            </p>
            @if($row->status_code == 005)
            {{-- <a href="#" class="btn btn-info btn-sm success" data-id="{{$row->id}}"></a> --}}
            <button class="btn btn-sm btn-info success" data-id="{{$row->id}}" data-amount="{{$row->item->amount}}" data-deliveryfee="{{$row->item->delivery_fees+$row->item->other_fees}}" data-deposit="{{$row->item->deposit}}" data-paystatus="{{$row->item->paystatus}}">{{ __("Success")}}</button>
            <a href="#" class="btn btn-warning btn-sm return" data-id="{{$row->id}}">{{ __("Return")}}</a>
            <a href="#" class="btn btn-danger btn-sm reject" data-id="{{$row->id}}">{{ __("Reject")}}</a>
            @endif
            <a href="#" class="btn btn-sm btn-primary detail" data-id="{{$row->item->id}}">Detail</a> 
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </main>

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
          <p ><strong >{{ __("Receiver Phone No")}}:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >{{ __("Receiver Address:")}}</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p>
          <p><strong>{{ __("Remark")}}:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  {{-- return modal --}}
  <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel">Return</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="wayid" id="returnway" value="">
          </div>
          <div class="form-group">
            <label for="InputDate">{{ __("Date")}}:</label>
            <input type="date" name="return_date" class="form-control returndate" id="InputDate">
          </div>
          <div class="form-group">
            <label for="InputRemark">{{ __("Remark")}}:</label>
            <textarea class="form-control returnremark" id="InputRemark" name="remark"></textarea>
            <span class="Eremark error d-block" ></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btnreturn">OK</button>
          </form>
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

  {{-- Success modal --}}
  <div class="modal fade" id="incomemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Income form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- <form action="{{route('incomes.store')}}" method="POST">
            @csrf -->
            <h3 class="text-dark">{{ __("Total Amount")}}:<span class="totalamount text-danger"></span></h3>
            <input type="hidden" id="totalamount" name="amount">
            <input type="hidden" name="way_id" id="way_id">
             <input type="hidden" name="deliveryfee" id="deliveryfee">
             <input type="hidden" name="deposit" id="deposit">
            <div class="form-group">
              <label for="exampleFormControlSelect1">{{ __("PaymentTypes")}}</label>
              <select class="form-control" id="paymenttype" name="paymenttype">
                <option>Choose Payment Type</option>
                @foreach($paymenttypes as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group bankform">
              <label for="bank">{{ __("Banks")}}</label>
              <select class="form-control" id="bank" name="bank">
                <option>Choose Bank</option>
                @foreach($banks as $bank)
                  <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group bamountform">
              <label for="bankamount">{{ __("Bank amount")}}</label>
              <input type="number" name="bank_amount" id="bankamount" class="form-control">
            </div>
            <div class="form-group camountform">
              <label for="cashamount">{{ __("Cash amount")}}</label>
              <input type="number" name="cash_amount" id="cashamount" class="form-control">
            </div>

            <div class="form-group carryfees">
              <label for="carryfees">Carry Fees (တန်ဆာခ)</label>
              <input type="number" name="carryfees" class="form-control" id="carryfees">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
          <button type="button" class="btn btn-primary incomesave">{{ __("Save")}}</button>
          <!-- </form> -->
        </div>
      </div>
    </div>
  </div>

@endsection
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      // $('.delivery_actions').hide();
      function thousands_separators(num){
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
      }

     $('.js-example-basic-single').select2({width:'100%'});

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

     $(".mypendingrow").on('click','.detail',function(){
        var id=$(this).data('id');
        //console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.post("{{route('itemdetail')}}",{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);
          $(".rcode").html(res.codeno);
        })
      })

      // control actions
      var $actions = $(".actions").hide();
      $cbs = $('input[name="ways[]"]').click(function() {
          $actions.toggle( $cbs.is(":checked") , 2000);
      });

      // $(".mypendingrow").on('click','.success',function(e){
        
      // })

      $(".bankform").hide();
      $(".bamountform").hide();
      $(".camountform").hide();

      $(".mypendingrow").on('click','.success',function(){
        $("#incomemodal").modal('show');
        var amount=$(this).data("amount");
        var id=$(this).data("id");
        var delivery_fees=$(this).data("deliveryfee");
        var deposit = $(this).data("deposit");
        let paystatus = $(this).data("paystatus");

        console.log(paystatus)

        $(".totalamount").html(`${thousands_separators(amount)} Ks`);
        $("#totalamount").val(amount);
        $("#way_id").val(id);
        $("#deliveryfee").val(delivery_fees);
        $("#deposit").val(deposit);

        if (paystatus == 2) {
          $("#paymenttype").val(4)
          $('#paymenttype').attr('disabled',true)
        }else if (paystatus == 3) {
          $("#paymenttype").val(5)
          $('#paymenttype').attr('disabled',true)
          $(".bankform").show();
          $('.bankform option[value="1"]').show();
        }else if (paystatus == 4) {
          $("#paymenttype").val(6)
          $('#paymenttype').attr('disabled',true)
          $(".bankform").show();
          $('.bankform option[value="1"]').show();
        }else{
          $('#paymenttype').attr('disabled',false)
        }
        // carry fees
        $('.carryfees').hide();

        $.post("{{route('getitembyway')}}",{wayid:id},function (response) {
          // console.log(response)
          if (response.deposit == 0 && (response.sender_gate_id!=null || response.sender_postoffice_id!=null)) {
            $('.carryfees').show();
          }
        })
      })

      $("#paymenttype").change(function(){
        var id=$(this).val();
        if(id==2){
          $(".bankform").show();
          $('.bankform option[value="1"]').hide();
        }else if(id==3){
          $(".bankform").show();
          $('.bankform option[value="1"]').hide();
          $(".bamountform").show();
          $(".camountform").show();
        }else if(id==5 || id==6){
          $(".bankform").show();
          $('.bankform option[value="1"]').show();
        }else{
          $(".bankform").hide();
          $(".bamountform").hide();
          $(".camountform").hide();
        }
      })

      $(".incomesave").click(function(){
        // alert('hi');
        var deliveryman_id = $("#InputDeliveryMan option:selected").val();
        var deliveryman = $("#InputDeliveryMan option:selected").text();
        var deliveryfee=$("#deliveryfee").val();
        var deposit = $("#deposit").val();
        var amount=$("#totalamount").val();
        var paymenttype=$("#paymenttype").val();
        var way_id=$("#way_id").val();
        var bank=$("#bank").val()
        var bank_amount=$("#bankamount").val();
        var cash_amount=$("#cashamount").val();
        var carryfees=$("#carryfees").val();
        var url="{{route('incomes.store')}}";
        $.ajax({
          url:url,
          type:"post",
          data:{deliveryfee:deliveryfee,deposit:deposit,amount:amount,paymenttype:paymenttype,way_id:way_id,bank:bank,bank_amount:bank_amount,cash_amount:cash_amount,carryfees:carryfees},
          dataType:'json',
          async: false,
          success:function(response){
            if(response.success){
              $('#incomemodal').modal('hide');
              // $('.success').removeClass('d-none');
              // $('.success').show();
              // $('.success').text('successfully added to income list');
              // $('.success').fadeOut(3000);
            }
          }
        })

        var wayid = way_id;
        var ways = [];
        if (!wayid) {
          $.each($("input[name='ways[]']:checked"), function(){
            let wayObj = {id:$(this).val()};
            ways.push(wayObj);
          });
        }else{
          let wayObj = {id:wayid};
          ways.push(wayObj);
        }
        $.post("{{route('makeDeliver')}}",{ways:ways},function (response) {
          console.log(response);
          //alert('successfully changed!')
          if(response.success){
              $('.alertsuccess').removeClass('d-none');
              $('.alertsuccess').show();
              $('.alertsuccess').text('successfully changed');
              $('.alertsuccess').fadeOut(3000);
              location.href="{{route('pending_ways')}}";
            }
        })

      })

      $(".mypendingrow").on('click','.return',function(e){
        e.preventDefault();
        $('#returnModal').modal('show');
        var id=$(this).data('id');
        $("#returnway").val(id);
      })

      $(".btnreturn").click(function(){
        var wayid=$("#returnway").val();
        var remark= $(".returnremark").val();
        var date= $(".returndate").val();
        var url="{{route('retuenDeliver')}}";
         $.ajax({
          url:url,
          type:"post",
          data:{wayid:wayid,remark:remark,date:date},
          dataType:'json',
          success:function(response){
            if(response.success){
               $('#returnModal').modal('hide');
               $('.Eremark').text('');
              $('span.error').removeClass('text-danger');
              $('.alertsuccess').removeClass('d-none');
              $('.alertsuccess').show();
              $('.alertsuccess').text('successfully added to return list');
              $('.alertsuccess').fadeOut(3000);
              location.href="{{route('pending_ways')}}";
            }
          },
          error:function(error){
            var message=error.responseJSON.message;
            var errors=error.responseJSON.errors;
            console.log(error.responseJSON.errors);
            if(errors){
              var remark=errors.remark;
              $('.Eremark').text(remark);
              $('span.error').addClass('text-danger');
            }

          }
          

        })
      })

      $(".mypendingrow").on('click','.reject',function(e){
        e.preventDefault();
        $('#rejectModal').modal('show');
        var id=$(this).data('id');
        $("#rejectway").val(id);
      })

      $(".btnreject").click(function(){
        var wayid=$("#rejectway").val();
        var remark= $(".rejectremark").val();
        var url="{{route('rejectDeliver')}}";
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
              location.href="{{route('pending_ways')}}";
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

      $("#dtownship").change(function(){
        var id=$(this).val();
        //alert(id);
        $.ajaxSetup({
           headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
        var url="{{route('pendingwaysbytownship')}}";
        $.post(url,{id:id},function(res){
          console.log(res);
          var html="";
          $.each(res,function(i,v){
            
            html+=`
            <div class="col-md-4">
        <div class="card mb-3">
          <h5 class="card-header">${v.item.receiver_name}`
            if(v.status_code=='001'){
            html+=`<span class="badge badge-info">success</span>`}
            else if(v.status_code == '002'){
            html+=`<span class="badge badge-warning">return</span>`}
            else if(v.status_code == '003'){
           html+=`<span class="badge badge-danger">reject</span>`}
           html+= `<small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ${v.item.expired_date}</small></h5>`
            html+=`<div class="card-body">
            <h5 class="card-title">Item Code: ${v.item.codeno}}</h5>
          <h5 class="card-title">Delivered Address: `
              if(v.item.sender_gate_id!=null){
              html+=`${v.item.sender_gate.name}`}
              else if(v.item.sender_postoffice_id != null){
               html+=`${v.item.sender_postoffice.name}`
              }
              else{
              html+=`${v.item.township.name}`}
           html+=`</h5>
          <p class="card-text">Full Address:${v.item.receiver_address}</p>
          <p class="card-text">
            Receiver Phone No:${v.item.receiver_phone_no}
          </p>
          <p class="card-text">
           Client Name: ${v.item.pickup.schedule.client.user.name}
          </p>
          <p class="card-text">
           Client Phone No: ${v.item.pickup.schedule.client.phone_no}
          </p>
          <p class="card-text">`
            if(v.item.paystatus==1){
             html+= `Amount: ${v.item.amount}Ks`
           }
             {{-- <span class="badge badge-success">ma shin ya thay</span> --}}
            else
            {
            html+=`<span class="badge badge-success">All Paid!</span>`
          }
            
          html+=`</p>`
          
            
            if(v.status_code=="005"){
           html+=`<a href="#" class="btn btn-info btn-sm success" data-id="${v.id}">Success</a>
            <a href="#" class="btn btn-warning btn-sm return" data-id="${v.id}">Return</a>
            <a href="#" class="btn btn-danger btn-sm reject" data-id="${v.id}">Reject</a>`
          }
          html+=`<a href="#" class="btn btn-sm btn-primary detail" data-id="${v.item.id}">Detail</a> 
          </div>
        </div>
      </div>
            `
          })
          $(".mypendingrow").html(html)
        })
      })


     $("#dgate").change(function(){
        var id=$(this).val();
        //alert(id);
        $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
         });
        var url="{{route('pendingwaysbygate')}}";
        $.post(url,{id:id},function(res){
          console.log(res);
          var html="";
          $.each(res,function(i,v){
            
            html+=`
            <div class="col-md-4">
        <div class="card mb-3">
          <h5 class="card-header">${v.item.receiver_name}`
            if(v.status_code=='001'){
            html+=`<span class="badge badge-info">success</span>`}
            else if(v.status_code == '002'){
            html+=`<span class="badge badge-warning">return</span>`}
            else if(v.status_code == '003'){
           html+=`<span class="badge badge-danger">reject</span>`}
           html+= `<small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ${v.item.expired_date}</small></h5>`
            html+=`<div class="card-body">
            <h5 class="card-title">Item Code: ${v.item.codeno}}</h5>
          <h5 class="card-title">Delivered Address: `
              if(v.item.sender_gate_id!=null){
              html+=`${v.item.sender_gate.name}`}
              else if(v.item.sender_postoffice_id != null){
               html+=`${v.item.sender_postoffice.name}`
              }
              else{
              html+=`${v.item.township.name}`}
           html+=`</h5>
          <p class="card-text">Full Address:${v.item.receiver_address}</p>
          <p class="card-text">
            Receiver Phone No:${v.item.receiver_phone_no}
          </p>
          <p class="card-text">
           Client Name: ${v.item.pickup.schedule.client.user.name}
          </p>
          <p class="card-text">
           Client Phone No: ${v.item.pickup.schedule.client.phone_no}
          </p>
          <p class="card-text">`
            if(v.item.paystatus==1){
             html+= `Amount: ${v.item.amount}Ks`
           }
             {{-- <span class="badge badge-success">ma shin ya thay</span> --}}
            else
            {
            html+=`<span class="badge badge-success">All Paid!</span>`
          }
            
          html+=`</p>`
          
            
            if(v.status_code=="005"){
           html+=`<a href="#" class="btn btn-info btn-sm success" data-id="${v.id}">Success</a>
            <a href="#" class="btn btn-warning btn-sm return" data-id="${v.id}">Return</a>
            <a href="#" class="btn btn-danger btn-sm reject" data-id="${v.id}">Reject</a>`
          }
          html+=`<a href="#" class="btn btn-sm btn-primary detail" data-id="${v.item.id}">Detail</a> 
          </div>
        </div>
      </div>
            `
          })
          $(".mypendingrow").html(html)
        })
      })
 

     $("#doffice").change(function(){
        var id=$(this).val();
        //alert(id);
        $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
         });
        var url="{{route('pendingwaysbyoffice')}}";
        $.post(url,{id:id},function(res){
          console.log(res);
          var html="";
          $.each(res,function(i,v){
            
            html+=`
            <div class="col-md-4">
        <div class="card mb-3">
          <h5 class="card-header">${v.item.receiver_name}`
            if(v.status_code=='001'){
            html+=`<span class="badge badge-info">success</span>`}
            else if(v.status_code == '002'){
            html+=`<span class="badge badge-warning">return</span>`}
            else if(v.status_code == '003'){
           html+=`<span class="badge badge-danger">reject</span>`}
           html+= `<small class="float-right"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> ${v.item.expired_date}</small></h5>`
            html+=`<div class="card-body">
            <h5 class="card-title">Item Code: ${v.item.codeno}}</h5>
          <h5 class="card-title">Delivered Address: `
              if(v.item.sender_gate_id!=null){
              html+=`${v.item.sender_gate.name}`}
              else if(v.item.sender_postoffice_id != null){
               html+=`${v.item.sender_postoffice.name}`
              }
              else{
              html+=`${v.item.township.name}`}
           html+=`</h5>
          <p class="card-text">Full Address:${v.item.receiver_address}</p>
          <p class="card-text">
            Receiver Phone No:${v.item.receiver_phone_no}
          </p>
          <p class="card-text">
           Client Name: ${v.item.pickup.schedule.client.user.name}
          </p>
          <p class="card-text">
           Client Phone No: ${v.item.pickup.schedule.client.phone_no}
          </p>
          <p class="card-text">`
            if(v.item.paystatus==1){
             html+= `Amount: ${v.item.amount}Ks`
           }
             {{-- <span class="badge badge-success">ma shin ya thay</span> --}}
            else
            {
            html+=`<span class="badge badge-success">All Paid!</span>`
          }
            
          html+=`</p>`
          
            
            if(v.status_code=="005"){
           html+=`<a href="#" class="btn btn-info btn-sm success" data-id="${v.id}">Success</a>
            <a href="#" class="btn btn-warning btn-sm return" data-id="${v.id}">Return</a>
            <a href="#" class="btn btn-danger btn-sm reject" data-id="${v.id}">Reject</a>`
          }
          html+=`<a href="#" class="btn btn-sm btn-primary detail" data-id="${v.item.id}">Detail</a> 
          </div>
        </div>
      </div>
            `
          })
          $(".mypendingrow").html(html)
        })
      })

    })
  </script>
@endsection