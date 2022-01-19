@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Reports")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">{{ __("Success List")}} ({{$mytime->toFormattedDateString()}})</h3>

          <form  method="post" class="myform">
            @csrf
            <button class="btn btn-info float-right generate">{{ __("Generate Report")}}</button>
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                <input type="date" name="start_date" class="form-control start-date">
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                <input type="date" name="end_date" class="form-control end-date">
              </div>
              <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 my-2">
                <button class="btn btn-success search">{{ __("Search")}}</button>
              </div>
            </div>
          </form>
          
          <div class="table-responsive">
            <table class="table table-bordered w-100" id="waystable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Delivery man")}}</th>
                  <th>{{ __("pickups")}}</th>
                  <th>{{ __("ways")}}</th>
                  <th>{{ __("gate ways")}}</th>
                  <th>{{ __("Postoffice ways")}}</th>
                  <th>{{ __("Total")}}</th>
                </tr>
              </thead>
              <tbody>
                
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

    $(".search").click(function(e){
      e.preventDefault();
      var start_date = $('.start-date').val();
      var end_date = $('.end-date').val();
      //alert("ok");
      var month=$("#InputMonth").val();
      var deliveryman=$("#InputDeliveryMan").val();
      //console.log(month);
      $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
     /* var gatecount=[];
      var postofficecount=[];*/
      var url="{{route('waysreport')}}";
        $('#waystable').DataTable( {
        "processing": true,
        "serverSide": true,
        "lengthMenu": [[10, 25, 50, 100, 200 , 300 , 400 , 500], [10, 25, 50, 100, 200 , 300 , 400 , 500]],
        "pageLength": 500,
        destroy:true,
        "sort":false,
        "stateSave": true,
        "ajax": {
            url: url,
            type: "POST",
            data:{start_date:start_date,end_date:end_date},
            dataType:'json',
        },
        "columns": [
         {"data":'DT_RowIndex'},
        { "data": "user.name"},
        {
          "data": "pickups",
          render:function(data){
                    return data.length;
                  }
          },
          {
          "data": "ways",
          render:function(data){
            var mycount=0
          
             data.forEach( function(v, i) {
              if(v.item.sender_gate_id==null && v.item.sender_postoffice_id==null && v.status_code=="001"){
                //alert("ok");
                //myarray.push(v);
               mycount++

              }
             });
            // console.log(myway);
              return mycount;
                  }
          },
          {
            "data":"ways",
            render:function(data){
              var gatearray=[];
              data.forEach( function(v, i) {
                if(v.item.sender_gate_id!=null && v.status_code=="001"){
                //console.log(mydate.toLocaleDateString());
                 var gateobj={
                    id:v.item.sender_gate_id,
                    date:v.delivery_date,
                  }
                  //console.log(gateobj);
                  if(gatearray.length==0){
                    gatearray.push(gateobj)
                  }else{
                      $.each(gatearray,function(k,e){
                        if(e.id!=gateobj.id){
                          gatearray.push(gateobj)
                          return false
                        }else if(e.id==gateobj.id && e.date!=gateobj.date){
                          gatearray.push(gateobj)
                          return false
                        }
                        // else if(e.date==gateobj.date){
                        //   gatearray.push(gateobj)
                        // }
                      })
                  }
                }
                // statements
              });
             console.log(gatearray);
              return gatearray.length;
          }
        },
        {
            "data":"ways",
           render:function(data){
              var postarray=[];
              data.forEach( function(v, i) {
                if(v.item.sender_postoffice_id!=null && v.status_code=="001"){
                //var mydate=new Date(v.created_at);
                //console.log(mydate.toLocaleDateString());
                 var postobj={
                    id:v.item.sender_postoffice_id,
                    date:v.delivery_date,
                  }
                 // console.log(postobj);
                  if(postarray.length==0){
                    postarray.push(postobj)
                  }else{
                      $.each(postarray,function(k,e){
                         if(e.id!=postobj.id){
                          postarray.push(postobj)
                          return false
                        }else if(e.id==postobj.id && e.date!=postobj.date){
                          postarray.push(postobj)
                          return false
                        }
                      })
                  }
                }
                // statements
              });
              //console.log(gatearray);
              return postarray.length;
          }
        },
          {
            "data": null,
            "render": function(data, type, full, meta){
              var gatearray=[];
              var postarray=[];
              var count=0;
              full["ways"].forEach( function(v, i) {
                if(v.item.sender_gate_id!=null && v.status_code=="001"){

                
                //console.log(mydate.toLocaleDateString());

                 var gateobj={
                    id:v.item.sender_gate_id,
                   date:v.delivery_date,
                  }
                 // console.log(gateobj);

                  if(gatearray.length==0){
                    gatearray.push(gateobj)
                  }else{
                      $.each(gatearray,function(k,e){
                        if(e.id!=gateobj.id){
                          gatearray.push(gateobj)
                          return false
                        }else if(e.id==gateobj.id && e.date!=gateobj.date){
                          gatearray.push(gateobj)
                          return false
                        }
                      })
                  }
                }else if(v.item.sender_postoffice_id!=null && v.status_code=="001"){
                  
                //console.log(mydate.toLocaleDateString());

                 var postobj={
                    id:v.item.sender_postoffice_id,
                    date:v.delivery_date,
                  }
                 // console.log(postobj);

                  if(postarray.length==0){
                    postarray.push(postobj)
                  }else{
                      $.each(postarray,function(k,e){
                         if(e.id!=postobj.id){
                          postarray.push(postobj)
                          return false
                        }else if(e.id==postobj.id && e.date!=postobj.date){
                          postarray.push(postobj)
                          return false
                        }
                      })
                  }
                }else if(v.item.sender_gate_id==null && v.item.sender_postoffice_id==null && v.status_code=="001"){
                  count++;
                }
                // statements
              }); 


             var mydata=count+postarray.length+gatearray.length+full["pickups"].length;
             return mydata;
            }
         }

        ],
        "info":false
    } );
    })

    $(".generate").click(function(e){
      $(".myform").attr('action',"{{route('successreport')}}")
    })

  })
</script>
@endsection