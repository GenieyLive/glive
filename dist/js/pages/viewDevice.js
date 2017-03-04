getDeviceDetails();
function getDeviceDetails()
{
		var id=0;	
		$.ajax({
	type: "POST",
	url: site_url+"/etc/updateDB.php?route=viewDevice&table=ok",
	data:{vars:id},
	success: function(data) {
		var mydata = eval(data);
		var table = $.makeTable(mydata);
		$("#example1").html(table);
        enableSwitch();
        $("#example1")
        .on( 'page.dt',   function () { enableSwitch(); } )
        .DataTable();
	},
	error: function (error) {
		alert("error:"+error);
	}
	});
}
$.makeTable = function (mydata) {
    var table = "";
    var tblHeader = "<thead><tr>";
    for (var k in mydata[0])
    {
    	if(k=="User_id")
    	{
    		tblHeader += "<th style='text-align:center'>Do with IoT</th>";
    	}
    	else
    	{
    		tblHeader += "<th>" + k + "</th>";
    	} 
 	}
    tblHeader += "</tr></thead><tbody>";
	table=table+tblHeader;
    var row_id=0;
    $.each(mydata, function (index, value) {
        var TableRow = "<tr id='rows"+row_id+"'>";
        $.each(value, function (key, val) {
        	if(key=="User_id")
        	{
        		//
        	}
            else if(key=="Device_id")
            {
                TableRow += "<td><a href='configureDevice.php?id=" + val +"'><button class='btn btn-xs bg-orange margin'>Configure</button><a>";
                    TableRow +="<a href='DeviceStatus.php?id=" + val +"'><button class='btn btn-xs bg-green margin'>Status</button></td>";
                TableRow += "<td id='"+key+row_id+"'>" + val + "</td>";
            }
            else if(key=="Status")
            {
                TableRow += "<td style='width:160px'><div style='float:left;width: 80px;' id=switch"+row_id+">" + val+"</div>&nbsp" ;
                TableRow+="<input type='checkbox' name='my-checkbox' class='switch"+row_id+"' data-size='mini' ";
                if(val=="ACTIVE")
                {
                TableRow+="checked";
                }
                TableRow+=" /> </td>";

            }
        	else
        	{
                val=val+"";
                if(val=="null")
                { 
                    val=" ";
                }
        		TableRow += "<td id='"+key+row_id+"'>" + val + "</td>";
        	}
            
        });
        TableRow += "</tr>";
        table=table+TableRow;
        row_id++;
    });
    table=table+"</tbody>"
    return table;
};

function enableSwitch()
{
    $("[name='my-checkbox']").bootstrapSwitch();
    $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
      var row_id=this.className.replace("switch",'');
      if($("#Email"+row_id).html().trim()=="")
      {
            $("#rows"+row_id+" .bootstrap-switch-handle-on").click();
            alert("Please Map user to Device");
            exit;
      }
      else
      {
          $("#switch"+row_id).html("Please wait ...");
          var status="INACTIVE";
          if(state)
          {
            status="ACTIVE";
          }
          var queryVal={};
          queryVal['Status']=status;
          queryVal['Device_id']=$("#Device_id"+row_id).html().trim();
              $.ajax({
            type: "POST",
            url: site_url+"/etc/updateDB.php?route=toggleStatus&table=ok",
            data:{vars:queryVal},
            success: function(data) {
                if(data=="ACTIVE" || data=="INACTIVE")
                {
                $("#switch"+row_id).html(data);
                }
                else
                {
                    $("#switch"+row_id).html("error");
                }
            },
            error: function (error) {
                alert("error:"+error);
            }
            });
        }
    });
}