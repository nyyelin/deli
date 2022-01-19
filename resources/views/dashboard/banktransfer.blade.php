@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Banks Transfer")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('banktransfer')}}">{{ __("Banks Transfer")}}</a></li>
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
          <h3 class="tile-title d-inline-block">Banks Transfer</h3>
          
          <form action="{{route('transfer.store')}}" method="POST">
            @csrf
            
            <div class="form-group cityname">
              <label for="frombank">{{ __("From")}}:</label>
              <select class="form-control" id="frombank" name="frombank">
                <option value="">Choose Bank</option>
                @foreach($banks as $row)
                <option value="{{$row->id}}">{{$row->name}}({{$row->amount}})</option>
                @endforeach
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('frombank') }} </div>
            </div>

            <div class="form-group cityname">
              <label for="tobank">{{ __("To")}}:</label>
              <select class="form-control" id="tobank" name="tobank">
                <option value="">Choose Bank</option>
                @foreach($banks as $row)
                <option value="{{$row->id}}">{{$row->name}}({{$row->amount}})</option>
                @endforeach
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('tobank') }} </div>
            </div>

            <div class="form-group">
              <label for="amout">{{ __("Amount")}}:</label>
              <input class="form-control" id="amount" type="number" placeholder="Enter amount" name="amount">
               <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
    
    <div class="row">
      <div class="col-12">
         <div class="table-responsive tile">
                  <table class="table">
                    <thead>
                      <tr>  
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Banks")}}</th>
                        <th>{{ __("Amount")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1; @endphp
                      @foreach($banks as $row)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$row->name}}</td>
                        <td>{{number_format($row->amount)}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
      </div>
     
    </div>
  </main>
@endsection 
@section('script')

@endsection