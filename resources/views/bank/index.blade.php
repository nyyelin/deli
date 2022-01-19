@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Banks")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('banks.index')}}">{{ __("Banks")}}</a></li>
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
          <h3 class="tile-title d-inline-block">{{ __("Banks List")}}</h3>
          <a href="{{route('banks.create')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> {{ __("Add New")}}</a>
          <div class="table-responsive">
            <table class="table table-bordered dataTable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Name")}}</th>
                  <th>{{ __("Amount")}}</th>
                  <th>{{ __("Actions")}}</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                 @foreach($banks as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->name}}</td>
                  <td>{{number_format($row->amount)}}</td>
                  <td>
                    <a href="{{route('banks.edit',$row->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-info add_amount" data-id = "{{$row->id}}" data-name = "{{$row->name}}">Add Amount</a>
                    <form action="{{ route('banks.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

                      @csrf
                      @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">{{ __("Delete")}}</button>
                  </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>



    {{-- add amount model --}}
    <div class="modal fade" id="addmountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form action="{{route('bank.addamount')}}" method="post">
        @csrf
        <div class="modal-dialog modal-dialog-centered">
        
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Amount to <span class="bank_type text-danger"></span>
                <input type="hidden" name="id" class="id">
                
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="row form-group">
                <label class="col-md-3 form-control-label" id="amount">Amount :</label>
                <div class="col-md-9">
                  <input type="number" name="amount" class="form-control">
                </div>
              </div>
              
              

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        
        </div>
      </form>
    </div>

  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    //alert("ok");
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);

    $('.add_amount').click(function(){
      var id = $(this).data('id');
      var name = $(this).data('name');
      $('.id').val(id);
      $('.bank_type').text(name);
      $('#addmountModal').modal('show');
    })
  })
  
</script>
@endsection