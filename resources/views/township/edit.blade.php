@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Townships")}} Edit</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('townships.index')}}">{{ __("Townships")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Township Edit Form</h3>
          
          <form action="{{route('townships.update',$township->id)}}" method="POST">
            @csrf
            @method('put')
            {{-- <div class="row my-3">
              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rcity" id="incity" value="1" @if($township->status==1) checked @endif>
                  <label class="form-check-label" for="incity">
                    {{ __("In city")}}
                  </label>
                </div>
              </div>

              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rcity" id="gate" value="2" @if($township->status==2) checked @endif>
                  <label class="form-check-label" for="gate">
                    {{ __("Gate")}}
                  </label>
                </div>
              </div>

              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="rcity" id="post" value="3" @if($township->status==3) checked @endif>
                  <label class="form-check-label" for="post">
                    {{ __("Post Office")}}
                  </label>
                </div>
              </div>
              <div class="form-control-feedback text-danger"> {{$errors->first('rcity') }} </div>
            </div> --}}

            <div class="form-group">
              <label for="InputCityName">{{ __("Name")}}:</label>
              <input class="form-control" id="InputCityName" type="text" placeholder="Enter name" name="name" value="{{$township->name}}">
               <div class="form-control-feedback text-danger"> {{$errors->first('name') }} </div>
            </div>

            <div class="form-group">
              <label for="delifee">{{ __("Delivery Fees")}}:</label>
              <input class="form-control" id="delifee" type="text" placeholder="Enter Delivery Fees" name="delifee" value="{{$township->delivery_fees}}">
               <div class="form-control-feedback text-danger"> {{$errors->first('delifee') }} </div>
            </div>

            {{-- <div class="form-group">
              <label for="city">{{ __("City")}}</label>
              <select class="form-control" id="city" name="city">
                <option>Choose City</option>
                @foreach($cities as $row)
                <option value="{{$row->id}}_{{$row->name}}" @if($township->city_id==$row->id) selected @endif>{{$row->name}}</option>
                @endforeach
              </select>
            </div> --}}

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
    //alert("ok");
    $("#incity").click(function(){
      if ($(this).is(':checked'))
      {
        $(".townshipname").show();
        $(".deliveryfee input").val("");
        $(".deliveryfee").show();
        $(".cityname").show();
      }
    });

    $("#gate").click(function(){
      if ($(this).is(':checked'))
      {
        $(".townshipname").hide();
        $(".deliveryfee input").val(1000);
        $(".deliveryfee").show();
        $(".cityname").show();
      }
    });

    $("#post").click(function(){
      if ($(this).is(':checked'))
      {
        $(".townshipname").hide();
        $(".deliveryfee input").val(1000);
        $(".deliveryfee").show();
        $(".cityname").show();
      }
    });
  })
</script>
@endsection