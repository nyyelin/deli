@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Schedules")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">{{ __("Schedules")}}</a></li>
      </ul>
    </div>
   <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @role('client')
            <h3 class="tile-title d-inline-block">Edit Schedule Form</h3>
            <form method="post" action="{{route('schedules.update',$schedule->id)}}" enctype="multipart/form-data">
          @endrole
          @role('staff')
            <h3 class="tile-title d-inline-block">{{ __("Edit Schedule and Assign")}}</h3>
            <form method="post" action="{{route('schedules.update',$schedule->id)}}" enctype="multipart/form-data">
            <div class="form-group">
              <label for="InputClient">{{ __("Client")}}:</label>
              <select class="form-control" name="client" id="InputClient">
                <optgroup label="Choose Client">
                  @foreach($clients as $row)
                  <option value="{{$row->id}}" @if($row->id==$schedule->client_id) {{'selected'}} @endif>{{$row->clientname}} ({{$row->address}})</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
          @endrole  
            @csrf 
            @method('PUT')  
            <div class="form-group">
              <label for="txtDate">{{ __("Date")}}:</label>
              <input class="form-control" id="txtDate" type="date" name="date" value="{{$schedule->pickup_date}}" min="">
              <div class="form-control-feedback text-danger"> {{$errors->first('date') }} </div>
            </div>   
            <div class="form-group">
              <label for="InputRemark">{{ __("Remark")}}:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark" >{{$schedule->remark}}</textarea>
              <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __("New file")}}</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __("Old file")}}</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="form-group">
                  <label for="file">{{ __("File")}}:</label>
                  <input type="file"  id="file" name="file">
                </div>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <img src="{{asset($schedule->file)}}" width="300" height="300">
              </div>
            </div>
            
            <div class="form-group quantity">
              <label for="quantity">{{ __("Quantity")}}:</label>
              <input type="number"  id="quantity" class="form-control" name="quantity" value="{{$schedule->quantity}}"> 
              <div class="form-control-feedback text-danger"> {{$errors->first('quantity') }} </div>
            </div>

            <div class="form-group amount">
              <label for="amount">{{ __("Amount")}}:</label>
              <input type="number"  id="amount" class="form-control" name="amount" value="{{$schedule->amount}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>
            
            @role('staff')
            <div class="form-group">
              <label for="InputDeliveryMan">{{ __("Delivery Man")}}:</label>
              <select class="form-control" name="deliveryman" id="InputDeliveryMan">
                <optgroup label="Choose Delivery Man">
                 @foreach($deliverymen as $row)
                  <option value="{{$row->id}}" @if($schedule->pickup->delivery_man_id==$row->id) {{'selected'}} @endif>{{$row->deliveryname}}</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
            @endrole

            <div class="form-group">
              <button class="btn btn-sm btn-primary" type="submit">{{ __("Update")}}</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){

    




    /*$(".myfile").hide();
    $(".mychangepsw").click(function(){
      if(this.checked){
    $(".myfile").show();
      }else{
      $(".myfile").hide();
      }
    })*/


    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate =day+ '-' +month+ '-' +year;
        //alert(maxDate);
        $('#txtDate').attr('min', maxDate);
    });
  })
</script>
@endsection