function changeVendor()
{
	var ven=$("#vendor_id").val();
	if(ven==1)
	{
		$("#dummey1").css("display","block");
		$("#dummey2").css("display","none");
	}
	else if(ven==2)
	{
		$("#dummey1").css("display","none");
		$("#dummey2").css("display","block");
	}
}
function get_APIDetails()
{
	var vars=0;
	$.ajax({
	type: "POST",
	url: site_url+"/etc/updateDB.php?route=configureAPI&step=0",
	data:{vars:vars},
	success: function(data) {
		var mydata = new Array();
		$.each(data, function (index, value) 
		{
			var key1,val1;
			$.each(value, function (key, val) 
			{
				if(key=="keyss")
				{
					key1=val;
				}
				else if(key=="vals")
				{
					val1=val;
				}
			});
			mydata[key1]=val1;
		});
		formArr=mydata;
		$( "#cart" ).val(mydata['cart']);
		$( "#login" ).val(mydata['login']);
		$( "#logout" ).val(mydata['logout']);
		$( "#payaddress" ).val(mydata['payaddress']);
		$( "#payconfirm" ).val(mydata['payconfirm']);
		$( "#paymethods" ).val(mydata['paymethods']);
		$( "#Session" ).val(mydata['Session']);
		$("#shipaddress").val(mydata['shipaddress']);
		$("#shipmethds").val(mydata['shipmethds']);
		$("#empty_cart").val(mydata['empty_cart']);
		$("#api").val(mydata['api']);
	},
	error: function (error) {
		alert("error:"+error)
	}
	});
}
function submit_deviceRegister()
{
	var queryVal={};
	queryVal['vendor_id']=$( "#vendor_id" ).val();
	queryVal['cart']=$( "#cart" ).val();
	queryVal['login']=$( "#login" ).val();
	queryVal['logout']=$("#logout").val();
	queryVal['payaddress']=$( "#payaddress" ).val();
	queryVal['payconfirm']=$( "#payconfirm" ).val();
	queryVal['paymethods']=$( "#paymethods" ).val();
	queryVal['Session']=$( "#Session" ).val();
	queryVal['shipaddress']=$( "#shipaddress" ).val();
	queryVal['shipmethds']=$( "#shipmethds" ).val();
	queryVal['empty_cart']=$( "#empty_cart" ).val();
	queryVal['api']=$( "#api" ).val();
	
		$.ajax({
		type: "POST",
		url: site_url+"/etc/updateDB.php?route=configureAPI&step=1",
		data:{vars:queryVal},
		success: function(data) {
			if(data>0)
			{
				
				$("#deviceRegister-success").html("Updated successfully")
				$("#deviceRegister-error").html("");
				$("#deviceRegister-error1").css("display","grid");

			}
			else
			{
				$("#deviceRegister-success").html("")
				$("#deviceRegister-error").html("Unable to update");
				$("#deviceRegister-error1").css("display","grid");

			}
		},
		error: function (error) {
			alert("error:"+error)
		}
			});
}

$('#deviceRegister').on('submit', function(e){
        e.preventDefault();
        submit_deviceRegister();
    });
