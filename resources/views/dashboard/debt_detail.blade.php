@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Reports</h1>
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
          <h3 class="tile-title d-inline-block">{{ __("Debt List")}} ({{$mytime->toFormattedDateString()}})</h3>

          @role('staff|admin')
          
           <div class="row">
              <div class="form-group col-md-3">
                <button class="btn btn-primary fix_debit" type="button">စာရင်းရှင်းမယ်</button>
              </div>

              <div class="form-group col-md-3 ">
                
              </div>

              <div class="form-group col-md-3">
                Bank Account:<span class="font-weight-bold">{{$pickup->schedule->client->account}}</span>
              </div>
              <div class="form-group col-md-3 ">
                Owner:<span class="font-weight-bold">{{$pickup->schedule->client->user->name}}</span>
              </div>
            </div>
          
            


            <h4 class="font-weight-bold my-4">
              ပေးရန် => {{$pickup->schedule->client->user->name}}
            </h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{ __("Pickup Date")}}</th>
                    <th>{{ __("Item Qty")}}</th>
                    <th>{{ __("Total Amount")}}</th>
                    <th>{{ __("Prepaid Amount")}}</th>
                    <th>{{ __("Already Get")}}</th>
                    <th>{{ __("Balance")}}</th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                      @php
                        $total_pay_amount = 0;
                        $pay_amount = 0;
                        $total = 0;
                        $alredy_get_amount = 0;
                        $expense_amount = 0;
                        $amount = 0;

                      @endphp
                      @foreach($pickup->items as $row)

                        @php

                          $total += $row->deposit;

                          if($row->status == 1){
                            $pay_amount += $total - $row->delivery_fees;
                          }
                        @endphp

                        @if($row->way)
                        {{-- reject way --}}
                          @if($row->way->status_code == '003')
                            @if($row->way->refund_date)
                              @php
                                if($row->paystatus == 4 || $row->paystatus == 1 || $row->paystatus == 2){
                                    $alredy_get_amount += $row->deposit;
                                }else{
                                    $alredy_get_amount += 0;
                                }
                              @endphp
                            @endif
                            
                          @else

                            @if($row->expense)
                              @php

                                if($row->expense->status == 2 || $row->expense->status == 1){
                                  if($row->expense->expense_type_id == 1 || $row->expense_type_id == 5){
                                    $expense_amount += $row->expense->amount;
                                  }
                                }
                                
                                @endphp
                              @endif

                            @endif
                          @endif

                           @if($row->status == 1)
                            @if($row->way)
                              @if($row->way->refund_date == null)
                                @php

                                  if($row->paystatus == 4 || $row->paystatus == 1 || $row->paystatus == 2){
                                      $alredy_get_amount += $row->delivery_fees + $expense_amount;
                                  }else{
                                      $alredy_get_amount += 0;
                                  }
                                @endphp
                              @endif
                            @endif
                          @endif

                          @if($row->status == 0 || $row->status == 1)
                            @if($row->expense)
                              @if($row->expense->expense_type_id == 5 && $row->expense->status == 2)
                                @php
                                  $alredy_get_amount += $row->expense->amount;
                                @endphp
                              @endif
                            @endif
                          @endif

                      @endforeach


                     @if($pickup->expense)

                        @php
                        if($pickup->expense->status == 2){

                          if($pickup->expense->expense_type_id == 1){

                            $balance = $total - $pickup->expense->amount - $alredy_get_amount;
                          }else{
                            $balance = $total;
                          }
                        }else{
                            if($pickup->expense->expense_type_id == 1){

                              $balance = $total - $pickup->expense->amount - $alredy_get_amount;
                            }else{
                              $balance = $total;
                            }
                        }
                        @endphp
                      @else
                        @php
                          $balance = $total;
                        @endphp
                      @endif

                      @php
                        $total_pay_amount += $balance;
                      @endphp


                    <td><input type="checkbox" name="expenses[]" class="form-check" value="{{$pickup->id}}" @if($balance < 0 ) data-amount = "0" @else data-amount ="{{$balance}}" @endif></td>

                    <td>{{date('d-m-Y',strtotime($pickup->schedule->pickup_date))}}</td>
                    <td>{{count($pickup->items)}}</td>

                    <td>
                      {{number_format($total)}}
                    </td>
                    <td>
                    @if($pickup->expenses)
                    @foreach($pickup->expenses as $expense)

                      @php
                        if($expense->expense_type_id == 1){
                          $amount += $expense->amount;
                        }else{
                          $amount += 0;
                        }
                        @endphp

                          

                    @endforeach
                    {{number_format($amount)}} 
                    @else
                        {{0}}
                    @endif

                      

                    </td>
                    <td>
                      {{number_format($alredy_get_amount)}} 
                    </td>
                    <td>
                      @if($balance < 0)
                      {{0}}
                      @else
                      {{number_format($balance)}}
                      @endif
                    </td>
                   

                  </tr>
                </tbody>

                <tfoot>
                  <tr>
                    <td colspan="6"></td>
                    <td>
                    @if($total_pay_amount < 0)
                      {{0}}
                    
                    @else
                    {{number_format($total_pay_amount)}} Ks
                    @endif
                  </td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <h4 class="font-weight-bold my-4" >
              ရရန် => {{$pickup->schedule->client->user->name}}
            </h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{ __("#")}}</th>
                    <th>{{ __("Name")}}</th>
                    <th>{{ __("Assign Date")}}</th>
                    <th>{{ __("Delivered Date")}}</th>
                    <th>{{ __("Delivery Fees")}}</th>
                    <th>{{ __("Item Price")}}</th>
                    
                    <th>{{ __("Total Amount")}}</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $total_amount = 0;
                  @endphp



                  @foreach($pickup->items as $item)
                  
                    @php
                      $carryfees = 0;
                    @endphp

                    {{-- normal --}}
                      @if($item->paystatus == 2 || $item->paystatus == 4)
                      <tr>
                         @php
                          if($item->status == 0){
                              $subtotal = $item->delivery_fees;
                              $total_amount += $subtotal;
                            }else{
                                $subtotal = 0;
                                $total_amount += $subtotal;
                            }
                          @endphp
                        <td><input type="checkbox" name="incomes[]" class="form-check" value="{{$item->id}}" data-amount="{{$subtotal}}" @if($item->status == 1) disabled="disabled" @endif></td>
                        <td>{{$pickup->schedule->client->user->name}} - 
                          @if($item->township)
                            {{$item->township->name}}
                          @elseif($item->SenderGate)
                            {{$item->SenderGate->name}}
                          @elseif($item->SenderPostoffice)
                            {{$item->SenderPostoffice->name}}
                          @endif
                          @if($item->paystatus == 2)
                            <span class="badge badge-info">All Paid</span>
                          @elseif($item->paystatus == 3)
                            <span class="badge badge-info">Only Deli</span>
                          @elseif($item->paystatus == 4)
                            <span class="badge badge-info">Only Item Price</span>
                          @endif
                        </td>
                        <td>
                          {{date('d-m-Y',strtotime($item->assign_date))}}
                        </td>

                        <td>
                          @if($item->way)
                            @if($item->way->delivery_date)
                            {{date('d-m-Y',strtotime($item->way->delivery_date))}}
                            @else
                            -
                            @endif
                          @endif
                        </td>

                        <td>
                          {{$item->delivery_fees}}
                        </td>

                        <td>
                          {{0}}
                        </td>

                        <td>
                         
                          {{number_format($subtotal)}} Ks
                        </td>
                        
                      </tr>
                      @endif



                      {{-- carry fees --}}
                      @if($item->expense)

                      @if($item->expense->expense_type_id == 5)
                        @php
                        $carryfees = 0;
                        @endphp
                        @if($item->paystatus == 2 || $item->paystatus == 4)
                        <tr>
                            @if($item->expense)
                              @if($item->expense->expense_type_id == 5 && $item->expense->status != 2)
                              
                                @php
                                
                                  $carryfees += $item->expense->amount;
                                
                                @endphp
                              @endif
                            @endif

                          <td><input type="checkbox" name="carryfees[]" class="form-check" value="{{$item->id}}" data-amount="{{$carryfees}}" @if($item->expense)
                                                        @if($item->expense->expense_type_id==5 && $item->expense->status == 2)
                                                          @if($item->status ==1) disabled="disabled" @endif
                                                        @endif
                                                       @endif
                                                          ></td>
                          <td>{{$pickup->schedule->client->user->name}} - 
                            @if($item->township)
                              {{$item->township->name}}
                            @elseif($item->SenderGate)
                              {{$item->SenderGate->name}}
                            @elseif($item->SenderPostoffice)
                              {{$item->SenderPostoffice->name}}
                            @endif
                            
                              <span class="badge badge-info">Carry fees</span>
                            
                          </td>
                          <td>
                            {{date('d-m-Y',strtotime($item->assign_date))}}
                          </td>

                          <td>
                            @if($item->way->delivery_date)
                            {{date('d-m-Y',strtotime($item->way->delivery_date))}}
                            @else
                            -
                            @endif
                          </td>

                          <td>

                            {{0}}
                          </td>

                          <td>
                            @if($item->expense)
                              @if($item->expense->expense_type_id == 5 && $item->expense->status != 2)
                              
                                @php
                                  
                                  $carryfees = $item->expense->amount;
                                  
                                @endphp
                                {{number_format($item->expense->amount)}}
                              @else
                                {{number_format($item->expense->amount)}}
                              @endif
                            @else
                                {{0}}
                            @endif
                          </td>

                          <td>
                            @php
                              $subtotal = $carryfees ;
                              $total_amount += $subtotal
                            @endphp
                            {{number_format($subtotal)}} Ks
                          </td>
                          
                        </tr>
                        @endif

                        @endif
                      @endif


                      {{-- reject way --}}
                      @if($item->way)
                        @if($item->way->status_code == "003")
                           
                            @if($item->paystatus == 2 || $item->paystatus == 4 || $item->paystatus == 1)
                            <tr>
                              @php
                              if($item->way->refund_date){

                                $subtotal = 0;
                                $total_amount += $subtotal;

                              }elseif(!$item->way->refund_date){
                                $subtotal = $item->deposit;
                                $total_amount += $subtotal;
                              }

                              @endphp
                              <td>

                              <input type="checkbox" name="rejects[]" class="form-check" value="{{$item->id}}" data-amount = "{{$subtotal}}" @if($item->way->refund_date) disabled="disabled" @endif></td>



                              <td>{{$pickup->schedule->client->user->name}} - 
                                @if($item->township)
                                  {{$item->township->name}}
                                @elseif($item->SenderGate)
                                  {{$item->SenderGate->name}}
                                @elseif($item->SenderPostoffice)
                                  {{$item->SenderPostoffice->name}}
                                @endif
                                
                                  <span class="badge badge-danger">reject</span>
                                
                              </td>
                              <td>
                                {{date('d-m-Y',strtotime($item->assign_date))}}
                              </td>

                              <td>
                                @if($item->way->delivery_date)
                                {{ '-' }}
                                @else
                                -
                                @endif
                              </td>

                              <td>

                                {{0}}
                              </td>

                              <td>
                               {{number_format($item->deposit)}}
                              </td>

                              <td>
                                
                                {{number_format($subtotal)}} Ks
                              </td>
                              
                            </tr>
                            
                            @endif
                          @endif
                        @endif
                  
                  @endforeach 

                </tbody>

                <tfoot>
                  <tr>
                    <td colspan="6">Total :</td>
                    
                    <td>{{number_format($total_amount)}} Ks</td>

                  </tr>
                </tfoot>
              </table>
            </div>
         

          @endrole

          @role('client')
            <div class="bs-component">
              <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pay">ပေးရန်</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#get">ရရန်</a></li>
              </ul>
              <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade active show" id="pay">
                  <div class="table-responsive">
                    <table class="table table-bordered dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>{{ __("Name")}}</th>
                          <th>{{ __("Description")}}</th>
                          <th>{{ __("Delivered Date")}}</th>
                          <th>{{ __("Delivery Fees")}}</th>
                          <th>{{ __("Item Price")}}</th>
                          <th>{{ __("Total Amount")}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; $total=0; @endphp
                        @foreach($incomes as $income)
                          @php $delifees = 0; $deposit=0;@endphp
                          @if($income->payment_type_id == 5)
                            @php $delifees = 0; @endphp
                          @else
                            @php $delifees = $income->way->item->delivery_fees; @endphp
                          @endif

                          @if($income->payment_type_id == 6)
                            @php $deposit = 0; @endphp
                          @else
                            @php $deposit = $income->way->item->deposit; @endphp
                          @endif
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$income->way->item->receiver_name}} <span class="badge badge-dark">{{$income->way->item->receiver_phone_no}}</span></td>
                            <td>{{$income->payment_type->name}}</td>
                            <td>{{\Carbon\Carbon::parse($income->created_at)->format('d-m-Y')}}</td>
                            <td>
                              {{number_format($delifees)}}
                            </td>
                            <td>{{number_format($deposit)}}</td>
                            <td>{{number_format($delifees + $deposit)}}</td>
                            @php $total += ($delifees + $deposit); @endphp
                          </tr>
                        @endforeach
                        @foreach($rejects as $reject)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$reject->item->receiver_name}} <span class="badge badge-dark">{{$reject->item->receiver_phone_no}}</span></td>
                            <td>{{'Reject'}}</td>
                            <td>{{number_format(0)}}</td>
                            <td>{{number_format($reject->item->deposit)}}</td>
                            <td>{{number_format(0 + $reject->item->deposit)}}</td>
                            @php $total += (0 + $reject->item->deposit); @endphp
                          </tr>
                        @endforeach
                        @foreach($carryfees as $carryfee)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$carryfee->item->receiver_name}} <span class="badge badge-dark">{{$carryfee->item->receiver_phone_no}}</span></td>
                            <td>{{'Carry Fees'}}</td>
                            <td>{{number_format(0)}}</td>
                            <td>{{number_format($carryfee->amount)}}</td>
                            <td>{{number_format($carryfee->amount)}}</td>
                            @php $total += $carryfee->amount; @endphp
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="6">{{ __("Total")}}:</td>
                          <td>{{number_format($total)}} Ks</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="get">
                  <div class="table-responsive">
                    <table class="table table-bordered dataTable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>{{ __("Description")}}</th>
                          <th>{{ __("Pickup Date")}}</th>
                          <th>{{ __("Item Qty")}}</th>
                          <th>{{ __("Amount")}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=1; $etotal=0; @endphp
                        @foreach($expenses as $expense)
                        @if(count($incomes)>0 || count($rejects)>0 || count($carryfees)>0)
                          @php $amount = $expense->amount; @endphp
                        @else
                          @php $amount = $expense->guest_amount; @endphp
                        @endif
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$expense->description}}</td>
                          <td>
                            @if($expense->pickup)
                              {{\Carbon\Carbon::parse($expense->pickup->created_at)->format('d-m-Y')}}
                            @else
                              {{'-'}}
                            @endif
                          </td>
                          <td>
                            @if(isset($expense->pickup))
                            {{count($expense->pickup->items)}}
                            @else
                            {{'-'}}
                            @endif
                          </td>
                          <td>{{number_format($amount)}}</td>
                          @php $etotal += $amount; @endphp
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="4">{{ __("Total")}}:</td>
                          <td>{{number_format($etotal)}} Ks</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          @endrole
        </div>
       

      </div>
    </div>
  </main>

  <!-- Modal -->
  <div class="modal fade" id="fixDebitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Choose Payment Method:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('fix_debit')}}">
          @csrf
        
        <div class="modal-body">
          <div class="form-row">
            <div class="col-md-4">
              <label>Choose Bank or Cash:</label>
            </div>
            <div class="col-md-8">
              <select class="form-control payment_method" name="payment_method">
                {{-- <option value="" data-amount="0">Choose Bank</option> --}}
                @foreach($banks as $bank)
                <option value="{{$bank->id}}" data-amount="{{$bank->amount}}">{{$bank->name}} ({{$bank->amount}})</option>
                @endforeach
              </select>
            </div>
            <div class="checked_debt_list">
            </div>
          </div>
          <div class="form-row">
            <label class="col-md-4">Pay amount</label>
            <div class="col-md-8">
              <input type="number" name="total_amount" class="form-control"> 
            </div>
          </div>
          
          <input type="hidden" name="client" value="" id="client_id">
          <input type="hidden" name="noti" value="" id="notiid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Fix Debit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    // $('#debits').hide();
    // $('.search_btn').hide();

    // Y/M/D into D/M/Y
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



    // old version

    $('.fix_debit').click(function () {
      let expenses = [];
      let rejects = [];
      let incomes = []; 
      let carryfees = [];

      let expenses_id = [];
      let rejects_id = [];
      let incomes_id = []; 
      let carryfees_id = [];

      $("input:checkbox[name='expenses[]']:checked").each(function() { 
          let expense_obj = {id:$(this).val(),amount:$(this).data('amount')}
          expenses.push(expense_obj);
      });
      $("input:checkbox[name='rejects[]']:checked").each(function() { 
          let reject_obj = {id:$(this).val(),amount:$(this).data('amount')}
          rejects.push(reject_obj);
      });
      $("input:checkbox[name='incomes[]']:checked").each(function() { 
          let income_obj = {id:$(this).val(),amount:$(this).data('amount')}
          incomes.push(income_obj);
      });
      $("input:checkbox[name='carryfees[]']:checked").each(function() { 
          let carryfee_obj = {id:$(this).val(),amount:$(this).data('amount')}
          carryfees.push(carryfee_obj);
      });

      console.log(carryfees);
      // console.log(expenses);
      
      // console.log(expenses)
      let totalexpenses = expenses.reduce((a, c) => (a + c.amount),0)
      let totalincomes = rejects.reduce((a, c) => (a + c.amount),0) + incomes.reduce((a, c) => (a + c.amount),0) + carryfees.reduce((a, c) => (a + c.amount),0)

      // console.log(totalexpenses +'/|/'+ totalincomes);

      if ((totalexpenses+totalincomes) > 0){
        let html = `<input type="hidden" name="expenses" value='${JSON.stringify(expenses)}'>
                <input type="hidden" name="client_id" value="{{$pickup->schedule->client->id}}">
                <input type="hidden" name="rejects" value='${JSON.stringify(rejects)}'>
                <input type="hidden" name="incomes" value='${JSON.stringify(incomes)}'>
                <input type="hidden" name="carryfees" value='${JSON.stringify(carryfees)}'>
                <input type="hidden" name="total_pay_amount" value="${totalexpenses-totalincomes}">
                
                <p>ပေးရန် => ${thousands_separators(totalexpenses)}</p>
                <p>ရရန် => ${thousands_separators(totalincomes)}</p>
                <p>ရှင်းရန်ငွေ => ${thousands_separators(Math.abs(totalexpenses-totalincomes))}`;
        $('.checked_debt_list').html(html);
        $('#fixDebitModal').modal('show');
      }else{
        alert('You Not Select Any Bebt List!');
      }
    })

    $('#InputClient').change(function () {
        var client_id = $(this).val();
        var clientname = $("#InputClient option:selected").text();
        var owner = $("#InputClient option:selected").data('owner');
        var account = $("#InputClient option:selected").data('account');

        var url = `/debit/getdebitlistbyclient/${client_id}`;
        $.get(url,function (response) {
          console.log(response)
          $("#notiid").val(response.rejectnoti);
          if (response.expenses.length > 0 || response.incomes.length > 0 || response.rejects.length > 0 || response.carryfees.length > 0) {
            $('.search_btn').removeClass('d-none');
            $('.account').removeClass('d-none');
            $('.owner').removeClass('d-none');
            $('.account').html(`<p class="mt-5">Bank Account:  <strong>${account}</strong></p>`)
            $('.owner').html(`<p class="mt-5">Owner: <strong>${owner}</strong></p>`)
            $('#client_id').val(client_id)
          }else{
            $('.search_btn').addClass('d-none');
            $('.account').addClass('d-none');
            $('.owner').addClass('d-none');
          }
          var header = `<h4>ပေးရန် => ${clientname}:</h4>`;
          $('#topay').html(header);

          var footer = `<h4>ရရန် => ${clientname}:</h4>`;
          $('#toget').html(footer);

          let i = 1;
          var html = "";
          let total = 0;
          for(let row of response.expenses){
            let allpaid_delivery_fees = 0
            let unpaid_total_item_price = 0
            let pay_amount = 0
            let prepaid_amount = 0

            for(let item of row.items){
              if (item.paystatus==2 && item.status==0) {
                allpaid_delivery_fees += item.delivery_fees
              }else{
                unpaid_total_item_price += Number(item.deposit)
              }
            }
            // console.log(allpaid_delivery_fees)
            // console.log(unpaid_total_item_price)
            // console.log(row.expense)
            if (!row.expense) {
              pay_amount = Number(unpaid_total_item_price)
            }else{
              prepaid_amount = row.expense.amount
              pay_amount = Number(unpaid_total_item_price)-Number(row.expense.amount)
            }

            html +=`<tr>
                    <td>
                      <div class="animated-checkbox">
                        <label class="mb-0">
                          <input type="checkbox" name="expenses[]" value="${row.id}" data-amount="${pay_amount}"><span class="label-text"> </span>
                        </label>
                      </div>
                    </td>`
                    
            let mydate=new Date(row.created_at);
            html+=`<td>${mydate.getDate()}-${mydate.getMonth()+1}-${mydate.getFullYear()}</td>`
                  
            html+=`<td> ${row.items.length}</td>
                    <td> ${thousands_separators(unpaid_total_item_price)} </td>
                    <td> ${thousands_separators(prepaid_amount)} </td>
                   <td>${thousands_separators(pay_amount)} Ks</td>
                  </tr>`;
                  total += Number(pay_amount);
          }
          html +=`<tr>
                    <td colspan="5">Total: </td>
                    <td>${thousands_separators(total)} Ks</td>
                  </tr>`;

          let j=1;
          var html2="";
          let total2=totalreject=totalincome=totalcarryfees=0;
          for(let row of response.rejects){
            // console.log(row)
            let delivery_fees = 0;

            html2 +=`<tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="rejects[]" value="${row.id}" data-amount="${Number(row.item.deposit) + Number(delivery_fees)}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>${row.item.receiver_name}`; 
            if(row.status_code == '003')
                  html2 +=` <span class="badge badge-danger">reject</span>`;
          
            html2 +=`</td>
                      <td>${formatDate(row.item.created_at)}</td>
                      <td>-</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(row.item.deposit)}</td>
                      <td>${thousands_separators(Number(row.item.deposit) + delivery_fees)} Ks</td>
                  </tr>`;
                  totalreject += Number(row.item.deposit) + Number(delivery_fees);
          }

          for(let row of response.incomes){
            let delivery_fees=deposit=0;
            let township_name="";

            if((row.paystatus == 2 || row.paystatus == 4) && row.status == 0){
              delivery_fees = Number(row.delivery_fees);
            }

            if (row.township_id != null) {
              township_name = row.township.name
            }else if(row.sender_gate_id != null){
              township_name = row.sender_gate.name
            }else if(row.sender_postoffice_id != null){
              township_name = row.sender_postoffice.name
            }

            let delivered_date = "-"
            if (row.way && row.way.status_code=="001") {
              mydate = new Date(row.created_at);
              delivered_date = `${mydate.getDate()}-${mydate.getMonth()+1}-${mydate.getFullYear()}`
            }
            
            html2 +=`<tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="incomes[]" value="${row.id}" data-amount="${Number(delivery_fees)+Number(deposit)}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>${row.receiver_name} - ${township_name}`;

            if(row.paystatus == 2){
              html2 +=` <span class="badge badge-info">All Paid</span>`;
            }else if(row.paystatus == 3){
              html2 +=` <span class="badge badge-info">Only Deli</span>`;
            }else if(row.paystatus == 4){
              html2 +=` <span class="badge badge-info">Only Item Price</span>`;
            }

            html2 +=`</td>
                      <td>${formatDate(row.created_at)}</td>
                      <td>${delivered_date}</td>
                      <td>${thousands_separators(delivery_fees)}</td>
                      <td>${thousands_separators(deposit)}</td>
                      <td>${thousands_separators(delivery_fees+deposit)} Ks</td>
                    </tr>`;
                  totalincome += Number(delivery_fees) + Number(deposit);
          }

          for(let row of response.carryfees){
            // console.log(row)
            var bus_gate_or_post_office = "";
            if (row.item.sender_gate != null) {
              bus_gate_or_post_office = row.item.sender_gate.name;
            }else if(row.item.sender_postoffice != null){
              bus_gate_or_post_office = row.item.sender_postoffice.name;
            }
            html2 +=`<tr>
                      <td>
                        <div class="animated-checkbox">
                          <label class="mb-0">
                            <input type="checkbox" name="carryfees[]" value="${row.id}" data-amount="${row.amount}"><span class="label-text"> </span>
                          </label>
                        </div>
                      </td>
                      <td>${row.item.receiver_name} - ${bus_gate_or_post_office} <span class="badge badge-info">carryfees</span></td>
                      <td>${formatDate(row.item.created_at)}</td>
                      <td>-</td>
                      <td>${0}</td>
                      <td>${thousands_separators(row.amount)}</td>
                      <td>${thousands_separators(row.amount)} Ks</td>
                  </tr>`;
                  totalcarryfees += Number(row.amount);
          }

          total2  = Number(totalreject)+Number(totalincome)+Number(totalcarryfees);

          html2 +=`<tr>
                    <td colspan="6">Total: </td>
                    <td>${thousands_separators(total2)} Ks</td>
                  </tr>`;

          $('#debits').show();
          $('#debit_list').html(html);
          $('#reject_list').html(html2);
        })
      })
  })
</script>
@endsection
