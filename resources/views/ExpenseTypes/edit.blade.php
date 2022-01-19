@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Expense Types")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('expense_types.index')}}">{{ __("Expense Types")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Expense Types Edit Form</h3>
          
          <form action="{{route('expense_types.update',$expenseType->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="expense_types">{{ __("Expense_types Name")}}:</label>
              <input class="form-control" id="expense_types" type="text" placeholder="Enter name" name="name" value="{{$expenseType->name}}">
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