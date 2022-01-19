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
        <div class="tile">
          <h3 class="tile-title d-inline-block">Bank Edit Form</h3>
          
          <form action="{{route('banks.update',$bank->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="bank">Bank {{ __("Name")}}:</label>
              <input class="form-control" id="bank" type="text" placeholder="Enter name" name="name" value="{{$bank->name}}">
               <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
            </div>
            <div class="form-group amount">
              <label for="amount">{{ __("Amount")}}:</label>
              <input type="number"  id="amount" class="form-control" name="amount" value="{{$bank->amount}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">{{ __("Save")}}</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 