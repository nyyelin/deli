@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Expenses")}} </h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('expenses.index')}}">{{ __("Expenses")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Expense Edit Form</h3>
          
          <form action="{{route('expenses.update',$expense->id)}}" method="POST">
            @csrf
            @method('put')
          <div class="form-group">
              <label for="description">{{ __("Description")}}:</label>
              <textarea class="form-control" id="description" name="description"type="text" placeholder="Enter description">{{$expense->description}}</textarea>
              <div class="form-control-feedback text-danger"> {{$errors->first('description') }} </div>
            </div>

            <div class="form-group">
              <label for="amount">{{ __("Amount")}}:</label>
              <input class="form-control" id="amount" name="amount" type="number" placeholder="Enter amount" value="{{$expense->amount}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>

            <div class="form-group">
              <label for="expensetype">{{ __("Expense Types")}}</label>
              <select class="form-control" id="expensetype" name="expensetype">
                <option>Choose Expense Type</option>
                @foreach($expensetypes as $row)
                <option value="{{$row->id}}"  @if($expense->expense_type_id==$row->id) selected @endif>{{$row->name}}</option>
                @endforeach
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('expensetype') }} </div>
            </div>


             <div class="form-group cityname">
              <label for="bank">{{ __("Banks")}}:</label>
              <select class="form-control" id="bank" name="bank">
                <option value="">Choose Bank</option>
                @foreach($banks as $row)
                <option value="{{$row->id}}">{{$row->name}}({{$row->amount}})</option>
                @endforeach
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('bank') }} </div>
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