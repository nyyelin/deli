@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Post Office")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('senderoffice.index')}}">{{ __("Post Office")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Post Office Create Form</h3>
          
          <form action="{{route('senderoffice.store')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="postoffice">{{ __("Name")}}:</label>
              <input class="form-control" id="postoffice" type="text" placeholder="Enter name" name="name">
               <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
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