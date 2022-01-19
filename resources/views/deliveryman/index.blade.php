@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Delivery Men")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('delivery_men.index')}}">{{ __("Delivery Men")}}</a></li>
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
          <h3 class="tile-title d-inline-block">{{ __("Delivery Men List")}}</h3>
          <a href="{{route('delivery_men.create')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> {{ __("Add New")}}</a>
          <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Name")}}</th>
                  <th>{{ __("Phone No")}}</th>
                  <th>{{ __("Address")}}</th>
                  <th>{{ __("Townships")}}</th>
                  <th>{{ __("Actions")}}</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach($DeliveryMen as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->user->name}}</td>
                  <td>{{$row->phone_no}}</td>
                  <td>{{$row->address}}</td>
                  <td>
                    @foreach($row->townships as $township)
                      <span class="badge badge-info">{{$township->name}}</span>
                    @endforeach
                  </td>
                  <td>
                    <a href="{{route('delivery_men.edit',$row->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                    <form action="{{ route('delivery_men.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

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
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    //alert("ok");
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
  })
  
</script>
@endsection