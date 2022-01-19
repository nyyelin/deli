@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i>{{ __(" Schedule")}}s</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">{{ __("Schedules")}}</a></li>
      </ul>
    </div>

    <div class="alert alert-success alert_show">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="font-weight-normal">This client is alerdy pickup</h5>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          
          @role('client')
            <h3 class="tile-title d-inline-block">Create Schedule Form</h3>
            <form method="post" action="{{route('schedules.store')}}" enctype="multipart/form-data">
          @endrole
          @role('staff')
            <h3 class="tile-title d-inline-block">{{ __("Create Schedule and Assign")}}</h3>
            <form method="post" action="{{route('schedules.storeandassign')}}" enctype="multipart/form-data">
            <div class="form-group">
              <label for="InputClient">{{ __("Client")}}:</label>
              <select class="form-control" name="client" id="InputClient">
                <optgroup>
                  <option>Choose Client</option>
                  @foreach($clients as $row)
                  <option value="{{$row->id}}">{{$row->clientname}} ({{$row->address}})</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
          @endrole  
            @csrf     
            <div class="form-group">
              <label for="txtDate">{{ __("Date")}}:</label>
              <input class="form-control" id="txtDate" type="date" name="date" required>
              <div class="form-control-feedback text-danger"> {{$errors->first('date') }} </div>
            </div>   
            <div class="form-group">
              <label for="InputRemark">{{ __("Remark")}}:</label>
              <textarea class="form-control" id="InputRemark" name="remark" placeholder="Enter Remark" ></textarea>
              <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
            </div>


            <div class="form-group">
              <label for="file">{{ __("File")}}:</label> 
              <input type="file" id="file" name="file" class="form-control-file">
            </div>

            @role('staff')
            <div class="form-group">
              <input type="checkbox" id="know">
              <label for="know">{{ __("If you know quantity and amount")}}</label> 
            </div>

            <div class="form-group quantity">
              <label for="quantity">{{ __("Quantity")}}:</label>
              <input type="number"  id="quantity" class="form-control" name="quantity">
              <div class="form-control-feedback text-danger"> {{$errors->first('quantity') }} </div>
            </div>


            <div class="form-group amount">
              <label for="amount">{{ __("Amount")}}:</label>
              <input type="number"  id="amount" class="form-control" name="amount">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>
            @endrole

            @role('client')
              <div class="form-group ">
              <label for="quantity">{{ __("Quantity")}}:</label>
              <input type="number"  id="quantity" class="form-control" name="quantity">
              <div class="form-control-feedback text-danger"> {{$errors->first('quantity') }} </div>
            </div>


            <div class="form-group ">
              <label for="amount">{{ __("Amount")}}:</label>
              <input type="number"  id="amount" class="form-control" name="amount">
              <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
            </div>
            @endrole
            
            @role('staff')
            <div class="form-group">
              <label for="InputDeliveryMan">{{ __("Delivery Man")}}:</label>
              <select class="form-control" name="deliveryman" id="InputDeliveryMan">
                <optgroup label="Choose Delivery Man">
                   <option value="0">{{ __("Choose Delivery Man")}}</option>
                 @foreach($deliverymen as $row)
                  <option value="{{$row->id}}">{{$row->deliveryname}}</option>
                  @endforeach
                </optgroup>
              </select>
            </div>

            <div class="form-group saveandassign">
              <button class="btn btn-primary" type="submit" onsubmit="return checkForm(this);">{{ __("Save And Assign")}}</button>
            </div>
            @endrole

            @role('client')
            
            <div class="form-group">
              <button class="btn btn-primary" type="submit">{{ __("Save")}}</button>
            </div>
            @endrole
          </form>
        </div>
      </div>
      
    </div>
  </main>
@endsection 
@section('script')

<script type="text/javascript">
  $(document).ready(function(){
    $('.alert_show').hide();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $(".quantity").hide();
    $(".amount").hide();

      $("#know").click(function(){
        if(this.checked){
          $(".quantity").show();
          $(".amount").show();
        }else{
          $(".quantity").hide();
        $(".amount").hide();

        }
      })




    /*$(".myfile").hide();
    $(".mychangepsw").click(function(){
      if(this.checked){
    $(".myfile").show();
      }else{
      $(".myfile").hide();
      }
    })*/
   

    $('#InputClient').change(function(){
      var client_id = $('#InputClient option:selected').val();
      var date = $('#txtDate').val();
      getfilter(client_id,date);
    })

    $('#txtDate').change(function(){
      var client_id = $('#InputClient option:selected').val();
      var date = $('#txtDate').val();
      getfilter(client_id,date);

    })


      
    function getfilter(client_id,date){
      var url = "{{route('filterclient')}}";
      $.ajax({
        url : url,
        data : {client_id:client_id,date:date},
        type : 'post',
        dataType : 'json',
        success:function(res){
          if(res.length > 0){
            $('.saveandassign').hide();
            $('.alert_show').show();
          }else{
            $('.saveandassign').show();
            $('.alert_show').hide();
          }
        }
      })
      
    }

    function checkForm(form) // Submit button clicked
      {
        //
        // check form input values
        //

        form.myButton.disabled = true;
        form.myButton.value = "Please wait...";
        return true;
      }

    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = day+ '-' +month+ '-' +year;
        //alert(maxDate);
        //console.log(maxDate);
        $('#txtDate').attr('min', maxDate);
    });
  })
</script>
@endsection