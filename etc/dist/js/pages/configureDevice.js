$( "#generateKey" ).click(function() {
	getsecurityKey();
});
var formArr=new Array();
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
function get_deviceDetails(Device_id)
{
	$.ajax({
	type: "POST",
	url: site_url+"/etc/updateDB.php?route=configureDevice&step=0",
	data:{vars:Device_id},
	success: function(data) {
		var mydata = new Array();
		$.each(data, function (index, value) 
		{
			$.each(value, function (key, val) 
			{
				mydata[key]=val;
			});
		});
		formArr=mydata;
		$( "#deviceid" ).val(mydata['Device_id']);
		$( "#devicekey" ).val(mydata['securityKey']);
		$( "#username" ).val(mydata['Name']);
		$( "#useremail" ).val(mydata['Email']);
		$( "#userphone" ).val(mydata['Phone']);
		$("#dummey"+mydata['vendor_id']).css("display","block");
		$( "#userpassword"+mydata['vendor_id'] ).val(mydata['password']);
		$( "#vendor_id" ).val(mydata['vendor_id']);
		$( "#User_id" ).val(mydata['User_id']);
		$("#product").val(mydata['product']);
		$("#noofproduct").val(mydata['noofproduct']);
	},
	error: function (error) {
		alert("error:"+error)
	}
	});
}
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
	queryVal['User_id']=$( "#User_id" ).val();
	queryVal['Address']="";queryVal['city']="";
	if(formArr['Device_id']==queryVal['Device_id'] && 
		formArr['securityKey']==queryVal['securityKey'] &&
		formArr['Name']==queryVal['Name'] &&
		formArr['Email']==queryVal['Email'] &&
		formArr['Phone']==queryVal['Phone'] &&
		formArr['password']==queryVal['Password'] )
	{
		//skipped
		step2();
	}
	else
	{
		$("#deviceRegisterBtn").val("Please wait...");
		$('#deviceRegisterBtn').prop('disabled', true);
		$.ajax({
		type: "POST",
		url: site_url+"/etc/updateDB.php?route=configureDevice&step=1",
		data:{vars:queryVal},
		success: function(data) 
		{
			console.log(data);
			if(data>0)
			{
				step2();
				$("#deviceRegisterBtn").val("Next");
				$('#deviceRegisterBtn').prop('disabled', false);
			}
			else
			{
				$("#deviceRegister-success").html("")
				$("#deviceRegister-error").html("Email or Device id already avaliable");
				$("#deviceRegister-error1").css("display","grid");
				$("#deviceRegisterBtn").val("Next");
				$('#deviceRegisterBtn').prop('disabled', false);

			}
		},
		error: function (error) {
			alert("error:"+error)
		}
			});

	}
}
function step2()
{
	$("#step1").css("display","none");
	$("#step2").css("display","block");
}
// $( "#deviceRegisterBtn" ).click(function() {
// 	submit_deviceRegister();
// });
function getProductID(s)
{
	var n=s.substring(s.indexOf("product_id")+11,s.length);
	if(n.indexOf('#')>=0)
	{
		 n=n.substring(0,n.indexOf("#"));
	}
	else if(n.indexOf('&')>=0)
	{
		 n=n.substring(0,n.indexOf("&"));
	}
	$("#product").val(n);
	
}
$( "#productURL" ).blur(function() {
  getProductID($("#productURL").val())
});
function submit_productRegister()
{
	var queryVal={};
	queryVal['product']=$( "#product" ).val();
	queryVal['noofproduct']=$( "#noofproduct" ).val();
	queryVal['Device_id']=$("#deviceid").val();
		
		$.ajax({
		type: "POST",
		url: site_url+"/etc/updateDB.php?route=configureDevice&step=2",
		data:{vars:queryVal},
		success: function(data) {
			if(data>0)
			{
				$("#productRegister-success").html("Configuration complete")
				$("#productRegister-error").html("");
				$("#productRegister-error1").css("display","grid");
				
			}
			else
			{
				$("#productRegister-success").html("")
				$("#productRegister-error").html("Error while updating value");
				$("#productRegister-error1").css("display","grid");

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
$('#productRegister').on('submit', function(e){
        e.preventDefault();
        submit_productRegister();
    });
