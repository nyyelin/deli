@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Clients</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('clients.index')}}">Clients</a></li>
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
          <h3 class="tile-title d-inline-block">Clients List</h3>
          <a href="{{route('clients.create')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __('Name')}}</th>
                  <th>{{ __('Phone No')}}</th>
                  <th>{{ __('Address')}}</th>
                  <th>{{ __('Contact_Person')}}</th>
                  <th>{{ __('Township')}}</th>
                  <th>{{ __('Bank Owner and Acccount')}}</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach($clients as $row)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->user->name}}</td>
                  <td>{{$row->phone_no}}</td>
                  <td>{{$row->address}}</td>
                  <td>{{$row->contact_person}}</td>
                  <td>{{$row->township->name}}</td>
                  <td>{{$row->owner}}({{$row->account}})</td>
                  <td>
                    <a href="{{route('clients.edit',$row->id)}}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('clients.destroy',$row->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

                      @csrf
                      @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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

    // Call the dataTables jQuery plugin
    $('#dataTable').DataTable( {
      "lengthMenu": [[10, 25, 50, 100, 200 ], [10, 25, 50, 100, 200]],
      "pageLength": 200,
      "aaSorting": [[1,'asc']]

    });
  })
  
</script>
@endsection