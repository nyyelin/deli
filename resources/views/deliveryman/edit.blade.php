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
        <div class="tile">
          <h3 class="tile-title d-inline-block">Delivery Men Edit Form</h3>
          
          <form action="{{route('delivery_men.update',$deliveryMan->id)}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="oldpassword" value="{{$deliveryMan->user->password}}">
           <div class="form-group">
              <label for="InputCityName">{{ __("Name")}}:</label>
              <input class="form-control" id="InputCityName" type="text" placeholder="Enter name" name="name" value="{{$deliveryMan->user->name}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">{{ __("Email address")}}</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email"value="{{$deliveryMan->user->email}}">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              <div class="form-control-feedback text-danger"> {{$errors->first('email') }} </div>
            </div>

            <div class="form-group">
              <input type="checkbox" class="mychangepsw" id="cpassw">
              <label for="cpassw">{{ __("Want to change password?")}}</label>
            </div>

            <div class="form-group psw">
              <label for="exampleInputPassword1">{{ __("Password")}}</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter Password">
              <div class="form-control-feedback text-danger"> {{$errors->first('password') }} </div>
            </div>

            <div class="form-group cpsw">
              <label for="password-confirm">{{ __("Confirm Password")}}</label>
               <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
              
            </div>

            <div class="form-group">
              <label for="phone">{{ __("Phone No")}}:</label>
              <input class="form-control" id="phone" type="text" placeholder="Enter Phone No" name="phone" value="{{$deliveryMan->phone_no}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('phone') }} </div>
            </div>

            <div class="form-group">
              <label for="address">{{ __("Address")}}:</label>
              <input class="form-control" id="address" type="text" placeholder="Enter Address" name="address" value="{{$deliveryMan->address}}">
              <div class="form-control-feedback text-danger"> {{$errors->first('address') }} </div>
            </div>

            <div class="form-group">
              <input type="checkbox" name="agent" class="agent" id="agentcheck" @if($deliveryMan->city->name != "Yangon") checked="" @endif>
              <label for="agentcheck">For agent?</label>
            </div>

            
            <div class="form-group citydiv">
                <label for="township">{{ __("City")}}:</label>
                <select class="js-example-basic-multiple form-control" name="city" >
                  <option>{{{ __("Choose City")}}}</option>
                  @foreach($cities as $row)
                  @if($row->name != "Yangon")
                  <option value="{{$row->id}}" @if($deliveryMan->city_id == $row->id) selected="selected" @endif>{{$row->name}}</option>
                  @endif
                  @endforeach
                   
                </select>
            </div>

            <div class="form-group">
              <input type="checkbox" name="car" class="car" id="carcheck" @if($deliveryMan->status == 1) checked="" @endif>
              <label for="carcheck">For Car?</label>
            </div>

            <div class="form-group mytownship">
              <label for="township">{{ __("Delivery Townships")}}:</label>
              @php
              $v = $deliveryMan->townships;
              @endphp
              <select class="js-example-basic-multiple form-control" name="township[]" multiple="multiple" id="township">
                <option>{{ __("Choose township")}}</option>
                @foreach($townships as $row)
                <option value="{{$row->id}}"  @foreach($v as $key=> $value)

                  @if($row->id==$value->pivot->township_id) {{"selected"}} @endif 
                  @endforeach>{{$row->name}}</option>
                @endforeach
                 
              </select>
              <div class="form-control-feedback text-danger"> {{$errors->first('townships') }} </div>
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
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    $(".psw").hide();
    $(".cpsw").hide();
    $(".mychangepsw").click(function(){
      if(this.checked){
    $(".psw").show();
    $(".cpsw").show();
      }else{
      $(".psw").hide();
    $(".cpsw").hide();
      }
    })


     if ($('.agent').is(":checked"))
      {
        $('.citydiv').show();
      }else{
        $('.citydiv').hide();
      }


    $('.agent').click(function(){
        if ($('.agent').is(":checked"))
        {
          $('.citydiv').show();
        }else{
          $('.citydiv').hide();
        }
      })

    if ($('.car').is(":checked"))
      {
        $('.mytownship').hide();
      }else{
        $('.mytownship').show();
      }


    $('.car').click(function(){
        if ($('.car').is(":checked"))
        {
          $('.mytownship').hide();
        }else{
          $('.mytownship').show();
        }
      })


  })
</script>
@endsection