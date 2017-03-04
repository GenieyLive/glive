var row_id=0;
function getDLogs(id)
{	
		$.ajax({
	type: "POST",
	url: site_url+"/etc/updateDB.php?route=viewDLogs&table=ok",
	data:{vars:id},
	success: function(data) {
		var mydata = eval(data);
		var table = $.makeTable(mydata);
		$("#example1").html(table);
        $('#example1').DataTable( {
                "bAutoWidth": false
        } );
        fixtable();
	},
	error: function (error) {
		alert("error:"+error);
	}
	});
}
function aligndata(str)
{
    // var str='{"success":true,"data":{"customer_id":"39","store_id":"0","username":"7299040692","firstname":"Naveenkumar","lastname":"P","email":"naveen.ccmsd@gmail.com","telephone":"07299040692","fax":"","salt":"498a07946","cart":"a:1:{s:6:"5081::";i:1;}","wishlist":"a:0:{}","newsletter":"0","address_id":"41","customer_group_id":"1","ip":"103.199.144.6","status":"1","approved":"1","token":"","date_added":"2016-01-28 20:36:00","session":"a911c0f508f6004890e1983c7362322f"}}';
    var res="";
    var i;
    for (i = 0; i <=str.length; i=i+100) 
    {
        console.log(str.substring(i,i+100));  
        res=res+"<br />"+str.substring(i,i+100);
    }
    return  res;
}
function fixtable()
{
    for(var i=0;i<row_id;i++)
    {
        try 
        {
            var s =$("#logs"+i).html();
            s=aligndata(s);
            $("#logs"+i).html(s);
        }
        catch (exc) 
        {
            // console.log(exc);
        }
    }
}
$.makeTable = function (mydata) {
    var table = "";
    var tblHeader = "<thead><tr>";
    for (var k in mydata[0])
    {
    	if(k=="User_id")
    	{
    		tblHeader += "<th> Configure Device</th>";
    	}
        else if(k=='req_id')
        {
            //
        }
    	else
    	{
    		tblHeader += "<th>" + k + "</th>";
    	} 
 	}
    tblHeader += "</tr></thead><tbody>";
	table=table+tblHeader;
    $.each(mydata, function (index, value) {
        var TableRow = "<tr id='rows"+row_id+"'>";
        $.each(value, function (key, val) {
        	if(key=="req_id")
        	{
        		//
        	}
            else if(key=="req_id_dup")
            {
                TableRow += "<td><a href='viewDLogs.php?id=" + val +"'><button class='btn btn-xs bg-green margin'>View</button><a></td>";
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