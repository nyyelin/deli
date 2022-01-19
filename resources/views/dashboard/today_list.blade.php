@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Today List")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      
    </div>
    <div class="row">
      <div class="col-md-12">
        
        <div class="tile">
         
          @php $i=1;$j=1;  @endphp
          <div class="bs-component">
            <div class="table-responsive">
              <table class="table table-bordered dataTable">
                <thead>
                  <tr>
                    <th>{{ __("#")}}</th>
                    <th>{{ __("Assign Date")}}</th>
                    <th>{{ __("Client Name")}}</th>
                    <th>{{ __("Customer Name")}}</th>
                    <th>{{ __("Township")}}</th>
                   
                    <th>{{ __("Amount")}}</th>
                    
                    <th>{{ __("Action")}}</th>
                  </tr>
                </thead>
                <tbody class="mytbody">
                  
                  @php
                  $i=1;
                  $total = 0;
                  $amount = 0;
                  @endphp
                  
                  @foreach($ways as $way)
                  
                  
                    <tr>
                  <td class="align-middle">{{$i++}}</td>

                  <td class="align-middle">
                    {{Carbon\Carbon::parse($way->item->assign_date)->format('d-m-Y')}}
                    <br>
                    {{-- assign, success --}}
                    @if($way->status_code == "001")
                    <p class="badge badge-success">{{$way->status->description}}</p>
                    @elseif($way->status_code == "002")
                    <p class="badge badge-warning">{{$way->status->description}}</p>
                    @elseif($way->status_code == "005" && $way->remark)
                    <p class="badge badge-danger">reject</p>
                    @else
                    <p class="badge badge-dark">{{$way->status->description}}</p>
                    @endif
                  </td>
                  <td class="align-middle">{{$way->item->pickup->schedule->client->user->name}}</td>
                  <td class="align-middle">{{$way->item->receiver_name}}<br>
                    <p class="badge badge-dark">{{$way->item->receiver_phone_no}}</p>
                  </td>
                  @if($way->item->township)
                  <td class="align-middle">{{$way->item->township->name}}</td>
                  @elseif($way->item->SenderGate)
                  <td class="align-middle">{{$way->item->SenderGate->name}}<br>
                    <p class="badge badge-dark">Gate</p>
                  </td>
                  @else
                  <td class="align-middle">{{$way->item->SenderPostoffice->name}}<br>
                    <p class="badge badge-dark">Post Office</p>
                  </td>

                  @endif

                  {{-- unpaid --}}
                  @if($way->item->paystatus == 1)

                    @php
                    if(($way->status_code == "005" && $way->remark == null) || $way->status_code == "001"){
                        $amount = $way->item->deposit + $way->item->delivery_fees;
                        $total += $way->item->deposit + $way->item->delivery_fees;
                      }else{
                        $amount = $way->item->deposit + $way->item->delivery_fees;
                        
                      }
                    @endphp
                    <td class="align-middle">{{number_format($amount)}}<br>
                      <p class="badge badge-dark">Unpaid</p>
                      
                    </td>

                  {{-- all paid --}}
                  @elseif($way->item->paystatus == 2)
                    @php
                      if(($way->status_code == "005" && $way->remark == null) || $way->status_code == "001"){
                        
                      $amount = $way->item->deposit + $way->item->delivery_fees;
                      $total += $way->item->deposit + $way->item->delivery_fees;
                    }else{
                      $amount = $way->item->deposit + $way->item->delivery_fees;

                    }
                    @endphp
                    <td class="align-middle">{{number_format($amount)}}
                      <br>
                      <p class="badge badge-dark">All paid</p>
                    </td>

                  {{-- only deli --}}
                  @elseif($way->item->paystatus == 3 )
                    @php
                    if(($way->status_code == "005" && $way->remark == null) || $way->status_code == "001"){
                      $amount = $way->item->delivery_fees;
                      $total += $way->item->delivery_fees;
                    }else{
                      $amount = $way->item->delivery_fees;

                    }

                    @endphp
                    <td class="align-middle">{{number_format($amount)}}<br>
                      <p class="badge badge-dark">Only Deli</p></td>

                  @else

                    @php
                    if(($way->status_code == "005" && $way->remark == null) || $way->status_code == "001"){

                      $amount = $way->item->deposit;
                      $total += $way->item->deposit;
                    }else{
                      $amount = $way->item->deposit;

                    }

                    @endphp
                    <td class="align-middle">{{number_format($amount)}}<br>
                      <p class="badge badge-dark">Only Item Price</p></td>
                  @endif
                 
                 
                  <td class="align-middle">
                  @if($way->status_code == 005 && $way->remark == null && $way->deleted_at == null)
                    <button class="btn btn-sm btn-info success" data-id="{{$way->id}}" data-amount="{{$way->item->amount}}" data-deliveryfee="{{$way->item->delivery_fees+$way->item->other_fees}}" data-deposit="{{$way->item->deposit}}" data-paystatus="{{$way->item->paystatus}}">{{ __("Success")}}</button>
                    <a href="#" class="btn btn-warning btn-sm return" data-id="{{$way->id}}">{{ __("Return")}}</a>
                    {{-- <a href="#" class="btn btn-danger btn-sm btnreject" data-id="{{$way->id}}">{{ __("Reject")}}</a> --}}
                  @endif
                    <a href="#" class="btn btn-sm btn-primary detail" data-id="{{$way->item->id}}">Detail</a> 
                  </td>
                  </tr>
                  

                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5" class="align-middle">Total</td>
                    <td colspan="3" class="align-middle">
                      {{number_format($total)}} Ks
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
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
          <input type="hidden" name="paystatus" class="paystatus">
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
            <select class="form-control returnremark" name="remark">
              <option value="Recall" selected="">Recall</option>
              <option value="Off">Off</option>
              <option value="PMK">PMK</option>
              <option value="Add">Add</option>

            </select>
            {{-- <textarea class="form-control returnremark" id="InputRemark" name="remark"></textarea> --}}
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


 {{-- reject modal --}}{{-- 
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
 --}}
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {

      $(".bankform").hide();
      $(".bamountform").hide();
      $(".camountform").hide();

      function thousands_separators(num){
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
      }

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


    $('#checktable').dataTable({
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

    $(".detail").click(function(){
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


    $(".success").click(function(){
        $("#incomemodal").modal('show');
        var amount=$(this).data("amount");
        var id=$(this).data("id");
        var delivery_fees=$(this).data("deliveryfee");
        var deposit = $(this).data("deposit");
        let paystatus = $(this).data("paystatus");


        $(".totalamount").html(`${thousands_separators(amount)} Ks`);
        $("#totalamount").val(amount);
        $("#way_id").val(id);
        $("#deliveryfee").val(delivery_fees);
        $("#deposit").val(deposit);
        $('.paystatus').val(paystatus);

        if (paystatus == 2) {
          $("#paymenttype").val(4)
          // $('#paymenttype').attr('disabled',true)
        }else if (paystatus == 3) {

          $("#paymenttype").val(5)
          // $('#paymenttype').attr('disabled' ,true)
          $(".bankform").show();
          $('.bankform option[value="1"]').show();

        }else if (paystatus == 4) {
          $("#paymenttype").val(6)
          // $('#paymenttype').attr('disabled',true)
          $(".bankform").show();
          $('.bankform option[value="1"]').show();
        }else{
          $("#paymenttype").val(1)
          $('#paymenttype').attr('disabled',false);
          $(".bankform").hide();
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
        var paystatus = $('.paystatus').val();
        // alert(paystatus);
        $.ajax({
          url:url,
          type:"post",
          data:{deliveryfee:deliveryfee,deposit:deposit,amount:amount,paymenttype:paymenttype,way_id:way_id,bank:bank,bank_amount:bank_amount,cash_amount:cash_amount,carryfees:carryfees,paystatus:paystatus},
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
              location.href="{{route('today_list')}}";
            }
        })

      })


      $(".return").click(function(e){
        // alert('hi');
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
              location.href="{{route('today_list')}}";
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



      $(".reject").click(function(e){
        e.preventDefault();
        $('#rejectModal').modal('show');
        var id=$(this).data('id');
        $("#rejectway").val(id);
      })

      $(".btnreject").click(function(){
        var wayid=$(this).data('id');
        // var remark= $(".rejectremark").val();
        var url="{{route('rejectDeliver')}}";
         $.ajax({
          url:url,
          type:"post",
          data:{wayid:wayid},
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
              location.href="{{route('today_list')}}";
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

  })
</script>
@endsection
