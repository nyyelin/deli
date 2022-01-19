@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Staff")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('staff.index')}}">{{ __("Staff")}}</a></li>
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
          <h3 class="tile-title d-inline-block">{{ __("Staff List")}}</h3>
          <a href="{{route('staff.create')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> {{ __("Add New")}}</a>
          <div class="table-responsive">
            <table class="table dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __("Name")}}</th>
                  <th>{{ __("Phone No")}}</th>
                  <th>{{ __("Address")}}</th>
                  <th>{{ __("Designation")}}</th>
                  <th>{{ __("Joined Date")}}</th>
                  <th>{{ __("Actions")}}</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach($staff as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->user->name}}</td>
                  <td>{{$row->phone_no}}</td>
                  <td>{{$row->address}}</td>
                  <td>{{$row->designation}}</td>
                  <td>{{$row->joined_date}}</td>
                  <td>
                    {{-- <a href="{{route('staff.show',$row->id)}}" class="btn btn-sm btn-primary">{{ __("Detail")}}</a> --}}
                    <a href="{{route('staff.edit',$row->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                    <form action="{{ route('staff.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

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