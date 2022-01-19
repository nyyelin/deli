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
          <h3 class="tile-title d-inline-block">{{ __("Total Deposit Amount")}}: {{number_format($items[0]->pickup->schedule->amount)}} Ks</h3>
          @php $i=1;$j=1;  @endphp
          <div class="bs-component">
            <div class="table-responsive">
              <table class="table table-bordered dataTable">
                <thead>
                  <tr>
                    <th>{{ __("#")}}</th>
                    <th>{{ __("Codeno")}}</th>
                    <th>{{ __("Assign Date")}}</th> 
                    <th>{{ __("Client Name")}}</th> 
                    <th>{{ __("Customer Name")}}</th>
                    <th>{{ __("Township")}}</th>
                    <th>{{ __("Delivery Man")}}</th> 
                    <th>{{ __("Item Price")}}</th> 
                    <th>{{ __("Deli Fees")}}</th> 
                    <th>{{ __("Actions")}}</th>
                  </tr>
                </thead>
                <tbody class="mytbody">
                  @php $i=1; $item_price_total=0; $delivery_total=0; 
                  
                  $count_data = count($items); 
                  $amount = 0;

                  @endphp
                  @foreach($items as $row)
                  @php
                  $assign_date = date('d-m-Y',strtotime($row->assign_date));
                  @endphp
                  <tr>
                    <td class="align-middle">{{$i++}}</td>
                    <td class="align-middle">
                      <span class="d-block">{{$row->codeno}}</span>
                      @if($row->paystatus == "1")
                      <span class="badge badge-dark">unpaid</span>
                      @elseif($row->paystatus == "2")
                      <span class="badge badge-dark">allpaid</span>
                      @elseif($row->paystatus == "3")
                      <span class="badge badge-dark">only deli</span>
                      @elseif($row->paystatus == "4")
                      <span class="badge badge-dark">only item price</span>
                      @endif
                    </td>
                    <td class="align-middle">{{$assign_date}}</td>
                    <td class="align-middle">{{$row->pickup->schedule->client->user->name}}</td>
                    <td class="align-middle">{{$row->receiver_name}}</td>
                    @if($row->township)
                    <td class="align-middle">{{$row->township->name}}</td>
                    @elseif($row->SenderGate)
                    <td class="align-middle">{{$row->SenderGate->name}}</td>
                    @else
                    <td class="align-middle">{{$row->SenderPostoffice->name}}</td>
                    
                    @endif
                    <td class="align-middle">
                      @if(isset($row->way))
                      {{$row->way->delivery_man->user->name}}
                      @else
                      {{'-'}}
                      @endif
                    </td>
                    <td class="align-middle">
                      @if($row->paystatus == 1)
                      {{number_format($row->deposit)}}
                      @php
                        $amount += $row->deposit;
                      @endphp

                      @elseif($row->paystatus == 2)
                      0
                      @php
                        $amount += 0;
                      @endphp
                      @elseif($row->paystatus == 3)
                      0
                      @php
                        $amount += 0;
                      @endphp
                      @elseif($row->paystatus == 4)
                      {{number_format($row->deposit)}}
                      @php
                        $amount += $row->deposit ;
                      @endphp
                      @endif
                    </td>
                    <td class="align-middle">
                      @if($row->paystatus == 1)
                      {{number_format($row->delivery_fees)}}
                      @php
                        $delivery_total += $row->delivery_fees;
                      @endphp

                      @elseif($row->paystatus == 2)
                      {{0}}
                      @php
                        $delivery_total += 0;
                      @endphp

                      @elseif($row->paystatus == 3)
                      {{number_format($row->delivery_fees)}}
                      @php
                        $delivery_total += $row->delivery_fees;
                      @endphp

                      @elseif($row->paystatus == 4)
                      {{0}}
                      @php
                        $delivery_total += 0 ;
                      @endphp


                      @endif

                    <td class="align-middle">
                      
                        <a href="{{route('items.edit',$row->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                        @if(isset($row->way))
                        <a href="{{route('deletewayassign',$row->way->id)}}" class="btn btn-sm btn-danger " onclick="return confirm('Are you sure?')">{{ __("Delete")}}</a>
                        @endif
                    </td>
                    {{-- @php 
                      $item_price_total += $row->deposit;
                      $delivery_total += $row->delivery_fees;
                    @endphp --}}
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                   <tr>
                    <td class="align-middle">{{$count_data}}</td>
                    <td colspan="6" class="align-middle">Total Amount:</td>
                    <td class="align-middle">{{number_format($amount)}} Ks</td>
                    <td class="align-middle">{{number_format($delivery_total)}} Ks</td>
                    <td class="align-middle">

                      {{-- <form action="{{route('checkitem_confirm',$id)}}" method="post" >
                      @csrf --}}
                      <input type="hidden" name="id" value="{{$id}}" class="pickup_id">
                      <input type="hidden" name="qty" class="qty" value="{{$count_data}}">
                      <input type="hidden" name="amount" class="amount" value="{{$amount}}">
                      <input id="InputDeliveryFees" type="hidden" name="delivery_fees" value="{{$delivery_total}}">

               
                      @if($pickup->status != 4)
                      <button type="submit" class="btn btn-sm btn-info" id="checkbtn" >{{ __("Completed")}}</button>
                      @endif
                      {{-- </form> --}}
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


{{-- deposit modal --}}
  <form action="{{route('checkitem_confirm')}}" method="post">
    @csrf

    <input type="hidden" name="pickup_id" class="id">
    <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Claim Amount: <span id="depositamount"></span>
              <input type="hidden" name="depositamount" class="depositamount">
            </h5>
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
                   {{ __("Prepaid")}}
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
              <div class="col-md-12 mt-3">
                <div class="form-group myknow">
                  <input type="checkbox" id="know">
                  <label for="know">{{ __("If you do not paid total amount")}}</label> 
                </div>
              </div>
            </div>
            
            <div class="row mt-3 paidamount">
              <div class="form-row col-md-12">
                <div class="col-md-4">
                  <label>Paid Amount:</label>
                </div>
                <div class="col-md-8">
                  <input type="number" name="paidamount" class="form-control" id="paidamount">
                </div>
                <div class="col-md-12">
                  <span class="d-none text-danger amounterrormsg">Prepaid amount less then or equal to claim amount!</span>
                </div>
              </div>
            </div>

            <div class="row mt-3 bank">
              <div class="form-row col-md-12 bankinfo">
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
            <button type="submit" class="btn btn-primary confirm_and_save">Confirm and Save</button>
          </div>
        </div>
      </div>
    </div>
  </form>



  </main>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('#checktable').dataTable({
        // "pageLength": 100,
        // "bPaginate": true,
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

    $(".paidamount").hide();
     $("#know").click(function(){
        if(this.checked){
          $(".paidamount").show();
        }else{
          $(".paidamount").hide();

        }
      })

     $('input[name="paystatus"]').click(function(){
      var inputValue = $(this).val();
      if(inputValue == 1){
        $('.bank').show();
        $('.myknow').show();
      }else{
        $('.bank').hide();
        $('.myknow').hide();
        $('.confirm_and_save').prop('disabled',false);
      }
    });

    $("#checkbtn").click(function(e){
      e.preventDefault();
      // console.log(Number($("#InputDeposit").val()))
      var pickup_id = $(".pickup_id").val();
      var amount = $('.amount').val();
      var qty = $('.qty').val();

      if($(".paystatus option:selected").val() == 2){
        var notallpaid_deposit = 0;
        var allpaid_delivery_fees = Number($("#InputDeliveryFees").val());
      }else{
        var notallpaid_deposit=amount;
        var allpaid_delivery_fees = 0;
      }

      var url="{{route('lastitem')}}";
      $.get(url,{pickup_id,pickup_id},function(res){
        let depositamount = Number(res) + allpaid_delivery_fees
        $('#depositamount').html(`${depositamount} Ks`);
        $('.depositamount').val(depositamount)
        $("#depositModal").modal('show');
        $('.id').val(pickup_id);
      })
      
    })


  })
</script>
@endsection
