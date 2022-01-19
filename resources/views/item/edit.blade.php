@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i>Items</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('items.index')}}"> Items</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item Edit Form</h3>
          
          <form action="{{route('items.update',$item->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <div class="col">
                    <label for="InputCodeno">Codeno:</label>
                    <input class="form-control" id="InputCodeno" type="text" value="{{$item->codeno}}" name="codeno" readonly>
                  </div>

                  <div class="col">
                    <label for="txtDate">{{ __("Assign Date")}}:</label>
                    <input class="form-control" id="txtDate" type="date" name="assign_date"  value="{{$item->assign_date}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('assign_date') }} </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col">
                    <label for="InputReceiverName">Receiver Name:</label>
                    <input class="form-control" id="InputReceiverName" type="text" name="receiver_name" value="{{$item->receiver_name}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('receiver_name') }} </div>
                  </div>
                  {{-- <div class="col">
                    <label for="InputExpiredDate">Expired Date:</label>
                    <input class="form-control" id="InputExpiredDate" type="date" name="expired_date"  value="{{$item->expired_date}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('expired_date') }} </div>
                  </div> --}}
                  {{-- <div class="col">
                    <label for="InputReceiverPhoneNumber">Receiver Phone Number:</label>
                    <input class="form-control" id="InputReceiverPhoneNumber" type="text" name="receiver_phoneno" value="{{$item->receiver_phone_no}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('receiver_phoneno') }} </div>
                  </div> --}}
                </div>

                {{-- <div class="form-group row">
                  <div class="col">
                    <label for="InputReceiverAddress">Receiver Address:</label>
                    <textarea class="form-control" id="InputReceiverAddress" name="receiver_address">{{$item->receiver_address}}</textarea>
                     <div class="form-control-feedback text-danger"> {{$errors->first('receiver_address') }} </div>
                  </div>
                </div> --}}

                <div class="row my-3">
                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="rcity" id="incity" value="1" @if($item->sender_gate_id==null && $item->sender_postoffice_id==null)
                        checked="checked" 
                       @endif>
                      <label class="form-check-label" for="incity">
                        {{ __("In city")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="rcity" id="gate" value="2" @if($item->sender_gate_id!=null)
                        checked="checked" 
                       @endif>
                      <label class="form-check-label" for="gate" >
                        {{ __("Gate")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="rcity" id="post" value="3" @if($item->sender_postoffice_id!=null)
                        checked="checked" 
                       @endif >
                      <label class="form-check-label" for="post">
                        {{ __("Post Office")}}
                      </label>
                    </div>
                  </div>
                  <div class="form-control-feedback text-danger"> {{$errors->first('rcity') }} </div>
                </div>

                <div class="form-group mygate">
                  <label for="mygate">{{ __("Sender Gate")}}:</label><br>
                  <select class="js-example-basic-single" id="mygate" name="mygate"  >
                    <option value="">{{ __("Choose Gate")}}</option>
                    @foreach($sendergates as $row)
                      <option value="{{$row->id}}" @if($item->sender_gate_id==$row->id) selected @endif>{{$row->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group myoffice">
                  <label for="myoffice">{{ __("Sender PostOffice")}}:</label><br>
                  <select class="js-example-basic-single" id="myoffice" name="myoffice"  >
                    <option value="">{{ __("Choose Post Office")}}</option>
                    @foreach($senderoffice as $row)
                      <option value="{{$row->id}}" @if($item->sender_postoffice_id==$row->id) selected @endif>{{$row->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group mytownship">
                  <input type="hidden" name="oldtownship" value="{{$item->township_id}}" id="oldtownship">
                  <label for="InputReceiverTownship">Receiver Township:</label>
                  <select class="js-example-basic-single form-control mytownship" id="InputReceiverTownship" name="receiver_township">
                    <optgroup label="Choose Township">
                      <option>Choose township</option>
                      @foreach($townships as $row)
                        <option value="{{$row->id}}" @if($item->township_id==$row->id) selected @endif>{{$row->name}}</option>
                      @endforeach
                    </optgroup>
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group row">
                  <div class="col">
                    <label for="InputDeposit">Item Price:</label>
                    <input class="form-control" id="InputDeposit" type="number" name="deposit" value="{{$item->deposit}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('deposit') }} </div>
                  </div>

                  <div class="col">
                    <label for="InputDeliveryFees">Delivery Fees:</label>
                    <input class="form-control" id="InputDeliveryFees" type="number" name="delivery_fees" value="{{$item->delivery_fees}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('delivery_fees') }} </div>
                  </div>

                  {{-- <div class="form-group">
                    <label for="other">{{ __("Other Charges")}}:</label>
                    <input class="form-control" id="other" type="number" name="othercharges" value="{{$item->other_fees}}">
                  </div> --}}

                  <div class="col">
                    <label for="InputAmount">Amount:</label>
                    <input class="form-control" id="InputAmount" type="number" name="amount" value="{{$item->amount}}">
                    <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
                  </div>
                </div>

                <div class="form-group row">
                  {{-- <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="amountstatus" id="amountpaid" value="1" @if($item->paystatus==1) checked="checked" @endif>
                      <label class="form-check-label" for="amountpaid">
                       {{ __("Unpaid")}}
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="amountstatus" id="amountunpaid"  value="2" @if($item->paystatus==2) checked="checked" @endif >
                      <label class="form-check-label" for="amountunpaid">
                        {{ __("All paid")}}
                      </label>
                    </div>
                  </div> --}}
                  <div class="col">
                    <label for="other">{{ __("Delivery Type")}}:</label>
                    <select class="form-control paystatus" name="amountstatus" >
                      <optgroup label="Choose type">
                        <option value="1" @if($item->paystatus==1) {{"selected"}} @endif>Unpaid</option>
                        <option value="2" @if($item->paystatus==2) {{"selected"}} @endif>Allpaid</option>
                        <option value="3" @if($item->paystatus==3) {{"selected"}} @endif>Only Deli</option>
                        <option value="4" @if($item->paystatus==4) {{"selected"}} @endif>Only Item Price</option>
                      </optgroup>
                    </select>
                    <div class="form-control-feedback text-danger"> {{$errors->first('amountstatus') }} </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col">
                    <label for="InputRemark">Remark:</label>
                    <textarea class="form-control" id="InputRemark" name="remark">{{$item->remark}}</textarea>
                    <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
                  </div>
                </div>
                @if($item->way)
                <div class="form-group row ">
                  <div class="col">
                    <label>{{ __("Choose Delivery Man")}}:</label>
                    <select class="js-example-basic-multiple form-control mydeliveryman" name="delivery_man">
                      <option>Choose Delivery Man</option>
                      @foreach($deliverymen as $man)
                        <option value="{{$man->id}}" @if($man->id == $item->way->delivery_man_id) {{'selected'}} @endif>{{$man->user->name}}
                          @foreach($man->townships as $township)
                            ({{$township->name}})
                          @endforeach
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif

                <div class="form-group row">
                  <div class="col">
                    <button class="btn btn-primary" type="submit">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $(".mygate").hide();
    $(".myoffice").hide();
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    // $(".township").hide();
    // for in city
    var today = new Date();
    var numberofdays = 3;
    today.setDate(today.getDate() + numberofdays); 
    var day = ("0" + today.getDate()).slice(-2);
    var month = ("0" + (today.getMonth() + 1)).slice(-2);
    //console.log(month);
    var incityday= today.getFullYear()+"-"+(month)+"-"+(day) ;
    console.log(incityday);
    $(".pickdate").val(incityday);

    $(".mytownship").change(function(){
      var id=$(this).val();
      var html = '';
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.post("/delichargebytown",{id:id},function(res){
        console.log(res);
        $("#InputDeliveryFees").val(res.deliverycharge);
        if(res.delivery_men.length > 0){
            
          $.each(res.delivery_men,function(i,v){  
            console.log(v);
          
            html+=` <option value="${v.id}">${v.user.user_name}`

              $.each(v.township,function(a,b){
                html += `(${b.name})`;
              })

            html += `</option>`;
          })


          $('.mydeliveryman').html(html);


        }else{

          
                      
          $.each(res.alldelivery_man,function(i,v){  
            
            html+=` <option value="${v.id}">${v.user.name}`
              $.each(v.townships,function(a,b){
                html += `(${b.name})`;
              })
            html+=  `</option>`;
          })
          $('.mydeliveryman').html(html);

        }
      })
    })

    $("#InputAmount").focus(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees;
      $(this).val(amount);
      }
    })

    $("#InputDeposit").change(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees;
      $("#InputAmount").val(amount);
      }
    })

    $("#InputRemark").focus(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees;
      $("#InputAmount").val(amount);
      }
    })
    
    $(function(){
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        //alert(maxDate);
        $('#txtDate').attr('min', maxDate);
    });

    $("input[name=rcity]").click(function(){
    if ($(this).is(':checked')){
      $(".township").show();
      var id=$(this).val();
      if(id==1){
        var today = new Date();
        var numberofdays = 3;
        today.setDate(today.getDate() + numberofdays); 
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        //console.log(month);
        var incityday= today.getFullYear()+"-"+(month)+"-"+(day) ;
        console.log(incityday);
        $(".pickdate").val(incityday);
        $('#InputDeposit').prop('readonly',false);
        // getTownship(id);
        let oldtownship = $('#oldtownship').val();
        $.post("/delichargebytown",{id:oldtownship},function(res){
          $("#InputDeliveryFees").val(res);
        })
      }else{
        var today = new Date();
        var numberofdays = 7;
        today.setDate(today.getDate() + numberofdays); 
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        //console.log(month);
        var gateday= today.getFullYear()+"-"+(month)+"-"+(day) ;
        console.log(gateday);
        $(".pickdate").val(gateday);
        $("#InputDeposit").val(0);
        $('#InputDeposit').prop('readonly',true);
        // getTownship(id);
        $("#InputDeliveryFees").val(1000);
      } 
    }
  });

  // function getTownship(id){
  //   $.ajaxSetup({
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     }
  //   });
  //   $.post("/townshipbystatus",{id:id},function(res){
  //     // console.log(res);
  //     var html="";
  //     html+=`<option>Choose township</option>`
  //     $.each(res,function(i,v){
  //       html+=`<option value="${v.id}">${v.name}</option>`
  //     })
  //     $("#InputReceiverTownship").html(html);
  //     let oldtownship = $('#oldtownship').val();
  //     $(`#InputReceiverTownship option:eq(${oldtownship})`).prop('selected', true)
  //   })
  // }

  var checked=$("input[name='rcity']:checked").val();
  console.log(checked);
  if(checked==1){
    // getTownship(checked);
    $(".mygate").hide();
    $(".myoffice").hide();
    $(".mytownship").show();
      $('#InputDeliveryFees').val(1000);
    
  }else if(checked==2){
    // getTownship(checked);
    $(".mygate").show();
    $(".myoffice").hide();
    $(".mytownship").hide();
      $('#InputDeliveryFees').val(1000);

  }else if(checked==3){
    $(".mygate").hide();
    $(".myoffice").show();
    $(".mytownship").hide();
    // getTownship(checked);
      $('#InputDeliveryFees').val(1000);

  }

  $("#gate").click(function(){
    $(".mygate").show();
    $(".myoffice").hide();
    $(".mytownship").hide();
    $('#InputDeliveryFees').val(1000);
    $('#InputAmount').val($('#InputDeliveryFees').val());
    var html = '';
    html+= `<option value="2">Allpaid</option>`;
    $('.paystatus_show').html(html);
  })

  $("#post").click(function(){
    $(".mygate").hide();
    $(".myoffice").show();
    $(".mytownship").hide();
    $('#InputDeliveryFees').val(1000);
    $('#InputAmount').val($('#InputDeliveryFees').val());
    var html = '';
    html+= `<option value="2">Allpaid</option>`;
    $('.paystatus_show').html(html);
  })

  $("#incity").click(function(){
    $(".mygate").hide();
    $(".myoffice").hide();
    $('.mytownship').show();
    var html = '';
    html+=`<optgroup label="Choose type">
              <option value="1">Unpaid</option>
              <option value="2">Allpaid</option>
              <option value="3">Only Deli</option>
              <option value="4">Only Item Price</option>
            </optgroup>`;

    $('.paystatus_show').html(html);
      
  })

  // $("#post").click(function(){
  //   var html='';
  //   $(".mygate").hide();
  //   $(".myoffice").show();
  //   $('.mytownship').hide();
  //   $('#InputDeliveryFees').val(1000);
  //   $('#InputAmount').val($('#InputDeliveryFees').val());

  //   html+= `<option value="2">Allpaid</option>`;
  //   $('.paystatus_show').html(html);
  // })

  // $("#gate").click(function(){
  //   $(".mygate").show();
  //   $(".myoffice").hide();
  //   $(".mytownship").hide();
  // })

  // $("#incity").click(function(){
  //   $(".mygate").hide();
  //   $(".myoffice").hide();
  //   $(".mytownship").show();
  // })

  // $("#post").click(function(){
  //   $(".mygate").hide();
  //   $(".myoffice").show();
  //   $(".mytownship").hide();
  // })

    $('.js-example-basic-single').select2({width:'100%'});
  })
</script>
@endsection