


          
          var url = `/incomes/getsuccesswaysbydeliveryman/${deliveryman_id}`;
          var table = $('.incomedata').DataTable();
          table.destroy();
          var total = 0;


          $('.incomedata').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bRetrieve": true,
          "dataSrc": "data",
          "bAutoWidth": true,
          "bStateSave": true,
          "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ -1,0] }
          ],
          "bserverSide": true,
          "bprocessing":true,
          'stateSave': true,

          "ajax": {   
            url: url,
            type: "GET",
            dataType:'json',
          },

          "columns": [

          {"data":'DT_RowIndex'},
          {"data": null,
          render:function(data,row){
            
            if(data.status_code=="001"){
              return `${data.item.codeno}<span class="badge badge-info">{{'success'}}</span>`
            }else if(data.status_code=="002"){
               return `${data.item.codeno}<span class="badge badge-warning">{{'return'}}</span>`
            }else if(data.status_code=="003"){
              return `${data.item.codeno}<span class="badge badge-danger">{{'reject'}}</span>`
            }else{
              return `${data.item.codeno}`
            }
          }
        },
        
        {
          "data":"item.assign_date"
        },
        {
          "data":"item.pickup.schedule.client.user.name"
          
        },
        {
          "data":"item.township.name"
        },
        {
          "data":"item.receiver_name"
          
        },
        
        {
          "data":"item.delivery_fees",
          render:function(data){
            return `${thousands_separators(data)}`
          }
        },

        {
          "data":"item.amount",
          render:function(data){
            return `${thousands_separators(data)}`
          }
        },
        

        {
          "data":"item.other_fees",
          render:function(data){
            return `${thousands_separators(data)}`
          }
        },
        
       ],

       rowCallback: function (row, data) {
            total += data.item.item_price;
            if (data.status_code == '002') {
                $(row).addClass('table-warning');
            }
            
          },
        
       "info":false

        });