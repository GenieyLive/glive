$( "#generateKey" ).click(function() {
	getsecurityKey();
});
getsecurityKey();
function getsecurityKey()
{
	$.ajax({
	type: "GET",
	url: site_url+"/etc/unique.php",
	data:{id:new Date()},
	success: function(data) {
		$("#devicekey").val(data);
	// $("#event_show").html(data); 
	}
	});
}
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
// $( "#deviceRegisterBtn" ).click(function() {
// 	submit_deviceRegister();
// });
function submit_deviceRegister()
{
	var queryVal={};
	queryVal['Device_id']=$( "#deviceid" ).val();
	queryVal['securityKey']=$( "#devicekey" ).val();
	queryVal['Name']=$( "#username" ).val();
	queryVal['Email']=$( "#useremail" ).val();
	queryVal['Phone']=$( "#userphone" ).val();
	queryVal['vendor_id']=$( "#vendor_id" ).val();
	queryVal['Password']=$( "#userpassword"+queryVal['vendor_id'] ).val();
	// alert(queryVal['Password']);
	queryVal['Address']="";
	queryVal['city']="";
	$("#deviceRegister-error").html("");
	$("#deviceRegister-success").html("");
	$.ajax({
	type: "POST",
	url: site_url+"/etc/updateDB.php?route=addDevice&table=ok",
	data:{vars:queryVal},
	success: function(data) {
		if(data>0)
		{
			$("#deviceRegister-error").html("");
			$("#deviceRegister-success").html("Device "+queryVal['Device_id']+" has been sucessfully created . Userid : "+data);
			$("#deviceRegister-success1").css("display","grid");
			$("#deviceRegister")[0].reset();
			getsecurityKey();
		}
		else if(data=='yes')
		{
			$("#deviceRegister-error").html("");
			$("#deviceRegister-success").html("Device "+queryVal['Device_id']+" has been sucessfully created . ");
			$("#deviceRegister-success1").css("display","grid");
			$("#deviceRegister")[0].reset();
			getsecurityKey();
		}
		else if(data=='no')
		{
			$("#deviceRegister-success").html("");
			$("#deviceRegister-error").html("Device Id"+queryVal['Device_id']+" already registred ");
			$("#deviceRegister-error1").css("display","grid");
			$("#deviceRegister")[0].reset();
			getsecurityKey();
		}
		else
		{
			$("#deviceRegister-success").html("");
			$("#deviceRegister-error").html("Something went wrong..contact Admin.");
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
