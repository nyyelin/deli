@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Items")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      
    </div>
    <div class="row">
      <div class="col-md-12">
        @if(!empty($successMsg))
          <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
              <strong> ✅ Fail!</strong>
              {{ $successMsg }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
        <div class="tile">
          <h3 class="tile-title d-inline-block">{{ __("Total Deposit Amount")}}: {{number_format($checkitems[0]->pickup->schedule->amount)}} Ks</h3>
          @php $i=1;$j=1;  @endphp
          <div class="bs-component">
                <div class="table-responsive">
                  <table class="table table-bordered" id="checktable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Receiver Name")}}</th>
                        <th>{{ __("Receiver Township")}}</th>
                        <th>{{ __("Receiver Phone No")}}</th>
                        <th>{{ __("Remark")}}</th>
                        <th>{{ __("Deposit Amount")}}</th>
                      </tr>
                    </thead>
                    <tbody class="mytbody">
                      
                      @foreach($checkitems as $row)
                      <tr>
                      <td>{{$i++}}</td>
                      <td>{{$row->codeno}}</td>
                      <td>{{$row->receiver_name}}</td>
                      <td>{{$row->township->name}}</td>
                      <td>{{$row->receiver_phone_no}}</td>
                      <td>{{$row->remark}}</td>
                      <td class="mytd"><input type="number" class="form-control checkitemamount{{$j++}}" name="amount" value="@if($row->deposit){{$row->deposit}}@else{{0}}@endif"  data-id="{{$row->id}}" @if($row->deposit == null){{'readonly'}}@endif></td>
                      @endforeach
                      
                    </tr>
                      
                    </tbody>
                  </table>
                  
                  <input type="hidden" name="totalamount" value="{{$checkitems[0]->pickup->schedule->amount}}" id="totaldeposit">
                  <input type="hidden" name="count" id="count" value="{{count($checkitems)}}">
                  <button class="btn btn-primary saveBtn">Save</button>

                </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deposit Amount: {{number_format($checkitems[0]->pickup->schedule->amount)}} KS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paystatus" id="paid" value="1" checked="checked">
              <label class="form-check-label" for="paid">
               {{ __("Paid")}}
              </label>
            </div>
          </div>
          <div class="col-6">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="paystatus" id="unpaid" value="2" >
                <label class="form-check-label" for="unpaid">
                  {{ __("Unpaid")}}
                </label>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-control-feedback text-danger">
              {{$errors->first('paystatus') }} 
            </div>
          </div>
        </div>
        <div class="row mt-3 bank">
          <div class="form-row col-md-12">
            <div class="col-md-4">
              <label>Choose Bank or Cash:</label>
            </div>
            <div class="col-md-8">
              <select class="form-control payment_method" name="payment_method">
                <option value="" data-amount="0">Choose Bank</option>
                @foreach($banks as $bank)
                <option value="{{$bank->id}}" data-amount="{{$bank->amount}}">{{$bank->name}} ({{$bank->amount}})</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <span class="d-none text-danger errormsg">Not Enough To Paid!</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
        <button type="submit" class="btn btn-primary checkitemsave">Confirm and Save</button>
      </div>
    </div>
  </div>
</div>

 @endsection
 @section('script')
<script type="text/javascript">
  $(document).ready(function(){
    //alert("ok");
    $('input[name="paystatus"]').click(function(){
      var inputValue = $(this).val();
      if(inputValue == 1){
        $('.bank').show();
      }else{
        $('.bank').hide();
        $('.checkitemsave').prop('disabled',false);
      }
    });

    $('.checkitemsave').prop('disabled',true);
    $('#depositModal').on('change','.payment_method',function () {
      let depositamount = Number($('#totaldeposit').val());
      let amount = Number($(this).find('option:selected').attr('data-amount'));
      // console.log(amount)
      if(amount==0){
        $('.errormsg').addClass('d-none');
        $('.checkitemsave').prop('disabled',true);
      }else if(depositamount>amount){
        // console.log('hi')
        $('.errormsg').removeClass('d-none');
        $('.checkitemsave').prop('disabled',true);
      }else{
        $('.errormsg').addClass('d-none');
        $('.checkitemsave').prop('disabled',false);
      }
    })

    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);

      $('#checktable').dataTable({
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

    $(".checkitemsave").click(function(){
      var count=$("#count").val();
      var totaldeposit=$("#totaldeposit").val()
      
      let myarray=[];
      for(var i=1;i<=count;i++){
        var oTable = $('#checktable').dataTable();
        // console.log(oTable);
        var rowcollection =  oTable.$(".checkitemamount"+i, {"page": "all"});
        //console.log(rowcollection);
        rowcollection.each(function(index,elem){
          var checkamount=$(elem).val();
          var checkid=$(elem).data('id');
          //console.log(checkid);

          var checkobj={
            id:checkid,
            amount:checkamount
          }
          myarray.push(checkobj);
        });
      }

      let paystatus = $('input[name="paystatus"]:checked').val();
      let payment_method = $('.payment_method option:selected').val();
      
      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.post("/updateamount",{myarray:myarray,totaldeposit:totaldeposit,paystatus:paystatus,payment_method:payment_method},function(res){
        if(res){
          location.href="{{route('items.index')}}"
        }
      })
    })

    $('.saveBtn').click(function () {
      var count=$("#count").val();
      var totaldeposit=$("#totaldeposit").val()
      //console.log(totaldeposit);

      var myarray=[];
      for(var i=1;i<=count;i++){
        var oTable = $('#checktable').dataTable();
        // console.log(oTable);
        var rowcollection =  oTable.$(".checkitemamount"+i, {"page": "all"});
        //console.log(rowcollection);
        rowcollection.each(function(index,elem){
          var checkamount=$(elem).val();
          var checkid=$(elem).data('id');
          //console.log(checkid);

          var checkobj={
            id:checkid,
            amount:checkamount
          }
          myarray.push(checkobj);
        //console.log(myarray);
          });
      }

      var total=0;
     // console.log(myarray);
      myarray.forEach( function(v, i) {
       total+=parseInt(v.amount);
      });
      //alert(total);

      if(totaldeposit==total){
        $('#depositModal').modal('show');
      }else{
        alert("amounts are not match");
      }

      })

  })
  
</script>
@endsection