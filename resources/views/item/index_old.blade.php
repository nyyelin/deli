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
          <a href="#" class="btn btn-primary float-right wayassign" id="submit_assign">{{ __("Way Assign")}}</a>

          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#collect">{{ __("In Stock")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#way">{{ __("On Way")}}</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="collect">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Client Name")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Receiver Info")}}</th>
                        <th>{{ __("Expired Date")}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        @foreach($items as $row)
                        <td>
                          <div class="animated-checkbox">
                            <label class="mb-0">
                              <input type="checkbox" name="assign[]" value="{{$row->id}}" data-codeno="{{$row->codeno}}"><span class="label-text"> </span>
                            </label>
                          </div>
                        </td>
                        <td>{{$row->codeno}}</td>
                        <td>{{$row->pickup->schedule->client->user->name}}</td>
                        <td class="text-danger">
                          @if($row->sender_gate_id!=null)
                          {{$row->SenderGate->name}}({{$row->township->name}})
                          @elseif($row->sender_postoffice_id!=null)
                          {{$row->SenderPostoffice->name}}({{$row->township->name}})
                          @else
                          {{$row->township->name}}
                          @endif
                        </td>
                        <td>
                          {{$row->receiver_name}} <span class="badge badge-dark">{{$row->receiver_phone_no}}</span>
                        </td>
                        <td>
                          {{$row->expired_date}}
                          @if($row->error_remark !== null)
                            <span class="badge badge-warning">{{ __("date changed")}}</span>
                          @endif
                        </td>
                        <td>{{number_format($row->amount)}}</td>
                        <td>
                          <a href="#" class="btn btn-primary detail" data-id="{{$row->id}}">{{ __("Detail")}}</a>
                          <a href="{{route('items.edit',$row->id)}}" class="btn btn-warning">{{ __("Edit")}}</a>
                          <form action="{{ route('items.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                           @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger">{{ __("Delete")}}</button>
                        </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="way">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Delivery Man")}}</th>
                        <th>{{ __("Expired Date")}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1;
                      @endphp
                      @foreach($ways as $way) 
                      @php $amount=number_format($way->item->amount) ;  @endphp
                      <tr>
                        <td>
                          {{$i++}}
                        </td>
                        <td>{{$way->item->codeno}}  
                          @if($way->status_code == '001')
                            <span class="badge badge-info">{{'success'}}</span>
                          @elseif($way->status_code == '002')
                            <span class="badge badge-warning">{{'return'}}</span>
                          @elseif($way->status_code == '003')
                            <span class="badge badge-danger">{{'reject'}}</span>
                          @endif
                        </td>
                        <td>
                          {{$way->item->township->name}}
                        </td>
                        <td class="text-danger">
                          {{$way->delivery_man->user->name}} 
                            @foreach($data as $dd)
                            @if($dd->id==$way->id)
                            <span class="badge badge-info seen">seen</span>
                            @endif

                           @endforeach
                        </td>
                        <td>{{$way->item->expired_date}}</td>
                        <td>{{$amount}}</td>
                        <td>
                          <a href="#" class="btn btn-primary detail" data-id="{{$way->item->id}}">{{ __("Detail")}}</a>
                          <a href="#" class="btn btn-warning wayedit" data-id="{{$way->id}}">{{ __("Edit")}}</a>
                          <a href="{{route('deletewayassign',$way->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">{{ __("Delete")}}</a>
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
          <p ><strong >{{ __("Receiver Phone No")}}:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >{{ __("Receiver Address")}}:</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p>
          <p><strong>{{ __("Remark")}}:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>

          <p id="error_remark" class="d-none"></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("OK")}}</button>
        </div>
      </div>
    </div>
  </div>
@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
      setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
      $('.wayassign').click(function () {
        var ways = [];
        $.each($("input[name='assign[]']:checked"), function(){
          let wayObj = {id:$(this).val(),codeno:$(this).data('codeno')};
          ways.push(wayObj);
        });
        var html="";
        for(let way of ways){
          html+=`<input type="hidden" value="${way.id}" name="ways[]"><span class="badge badge-primary mx-2">${way.codeno}</span>`;
        }
        $('#selectedWays').html(html);

        $('#wayAssignModal').modal('show');
      })

      $('.detail').click(function () {
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

      var $submit = $("#submit_assign").hide();
      $cbs = $('input[name="assign[]"]').click(function() {
          $submit.toggle( $cbs.is(":checked") , 2000);
      });

      $(".wayedit").click(function(){
        $('#editwayAssignModal').modal('show');
        var id=$(this).data("id");
        //console.log(id);
        $("#wayid").val(id);
      })


      setTimeout(function(){
      window.location.reload(1);
    }, 90000);

      
    })

   
  </script>
@endsection