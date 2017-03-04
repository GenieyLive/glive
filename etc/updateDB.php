<?php
try {
	require_once('db.php');
} catch (Exception $e) {
	echo "Database connectivity Error";
	http_response_code(403);
}
try
{
	if(isset($_GET['route'])&& isset($_POST['vars']))
	{
		$func=$_GET['route'];
		$vars=$_POST['vars'];
		$func($vars);
	}
	else if(isset($_GET['route'])&& isset($_GET['vars']))
	{
		$func=$_GET['route'];
		$vars=$_GET['vars'];
		$func($vars);
	}
	else
	{
		echo "402 : Invalid access";
		http_response_code(402);
	}
}
catch (Exception $e) {
	echo "Bad request";
	http_response_code(403);
}
 function addDevice($vars)
{
	if($vars['Email']==''||$vars['Email']==null)
	{
			$query="INSERT INTO `g_device`(`Device_id`, `User_id`, `securityKey`) VALUES ";
			$query=$query." ('".$vars['Device_id']."','0','".$vars['securityKey']."')";
			$res=mysql_query($query);
			if($res)
				{
					echo "yes";
				}
				else
				{
					echo "no";
				}
	}
	else
	{
		$query="INSERT INTO `g_user`( `Name`, `Email`, `Phone`, `Address`, `city`) VALUES";
		$query=$query." ('".$vars['Name']."','".$vars['Email']."','".$vars['Phone']."','".$vars['Address']."','".$vars['city']."')";
		mysql_query($query);
		$userid=mysql_insert_id(); 
		if($userid==0)
		{
			$query="select User_id from g_user where Email='".$vars['Email']."'";
			$res=mysql_query($query);
			if($row=mysql_fetch_array($res))
			{
				$userid=$row['User_id'];
			}
		}
		if($userid>0)
		{
			$query="INSERT INTO `g_device`(`Device_id`, `User_id`, `securityKey`,`password`,`vendor_id`) VALUES ";
			$query=$query." ('".$vars['Device_id']."','".$userid."','".$vars['securityKey']."','".$vars['Password']."','".$vars['vendor_id']."')";
			mysql_query($query);
		}
		DeviceConfigMail($vars['Email'],$vars['Name'],$vars['Device_id'],$vars['securityKey']);
		echo $userid;
	}
	
	http_response_code(201);
}

function viewDevice($vars)
{
	$query="select User_id,Device_id,g_device.Status,Name,Email,Phone from g_device left join g_user using(User_id)";
	if($vars>0)
	{
		$query="select * from g_device left join g_user using(User_id) where Device_id='".$vars."'";
	}
	$result=mysql_query($query);
	$rows=array();
	while($r=mysql_fetch_assoc($result))
	{ 
	$rows[]=$r;
	}
	header("Content-type:application/json"); 
	echo json_encode($rows);

}
function viewLogs($vars)
{
	$query="SELECT 	req_id,Device_id,g_log.status,Name,Email,req_id as req_id_dup FROM `g_log` join g_device using(Device_id) left join g_user on g_log.User_id=g_user.User_id order by req_id desc";
	$result=mysql_query($query);
	$rows=array();
	while($r=mysql_fetch_assoc($result))
	{ 
	$rows[]=$r;
	}
	header("Content-type:application/json"); 
	echo json_encode($rows);

}
function viewDLogs($vars)
{
	$query="SELECT * FROM `g-logs` where req_id=$vars order by update_time desc";
	$result=mysql_query($query);
	$rows=array();
	while($r=mysql_fetch_assoc($result))
	{ 
	$rows[]=$r;
	}
	header("Content-type:application/json"); 
	echo json_encode($rows);

}
function configureDevice($vars)
{
	if(isset($_GET['step']))
	{
		if($_GET['step']==0)
		{
			$query="select * from g_device left join g_user using(User_id) where Device_id='$vars'";
			$result=mysql_query($query);
			$rows=array();
			while($r=mysql_fetch_assoc($result))
			{ 
			$rows[]=$r;
			}
			header("Content-type:application/json"); 
			echo json_encode($rows);
		}
		else if($_GET['step']==1)
		{
			if($vars['User_id']>0)
			{
			$query="UPDATE `g_user` SET `Name`='".$vars['Name']."',`Email`='".$vars['Email']."',`Phone`='".$vars['Phone']."' where User_id=".$vars['User_id'];
			$res=mysql_query($query);
				if (!$res) 
				{
					echo "0";
				}
				else
				{
					$query="UPDATE  `g_device` SET `vendor_id`='".$vars['vendor_id']."', `password`='".$vars['Password']."' where Device_id='".$vars['Device_id']."'";
					mysql_query($query);
					echo $vars['User_id'];
					
				}
			}
			else if($vars['User_id']==0)
			{
				$query="INSERT INTO `g_user`( `Name`, `Email`, `Phone`, `Address`, `city`) VALUES";
				$query=$query." ('".$vars['Name']."','".$vars['Email']."','".$vars['Phone']."','".$vars['Address']."','".$vars['city']."')";
				mysql_query($query);
				$userid=mysql_insert_id(); 
				if($userid<=0)
				{
					$query="select User_id from g_user where Email='".$vars['Email']."'";
					$res=mysql_query($query);
					if($row=mysql_fetch_array($res))
					{
						$userid=$row['User_id'];
					}
				}
				$query="UPDATE  `g_device` SET `User_id`='".$userid."', `securityKey`='".$vars['securityKey']."', `vendor_id`='".$vars['vendor_id']."', `password`='".$vars['Password']."' where Device_id='".$vars['Device_id']."'";
				mysql_query($query);
			}
			DeviceConfigMail($vars['Email'],$vars['Name'],$vars['Device_id'],$vars['securityKey']);
		}
		else if($_GET['step']==2)
		{
			$query="UPDATE `g_device` SET product='".$vars['product']."' ,noofproduct=".$vars['noofproduct']." where Device_id='".$vars['Device_id']."'";
			$res=mysql_query($query);
			if(!$res)
			{
				echo "0";
			}
			else
			{
				echo "1";
			}
		}	
		http_response_code(201);
	}
	else
	{
		http_response_code(401);
	}
}
// if($route=="insert")
// {
// 	$table=$_GET['table'];
// 	$queryVal=$_POST["queryVal"];
// 	$col=array();$colVal=array();
// 	foreach($queryVal as $x=>$x_value)
// 	  {
// 	  	array_push($col,$x);
// 	  	array_push($colVal,"'".$x_value."'");
// 	  }
// 	  $query="insert into ".$table."(".implode(",",$col).") values (".implode(",",$colVal).")";
// 	  echo $query;
// }
function toggleStatus($vars)
{
	$query="UPDATE `g_device` SET Status='".$vars['Status']."' where Device_id='".$vars['Device_id']."'";
	$result=mysql_query($query);
	if($result)
	{
		echo $vars['Status'];
	}
	else
	{
		echo  "0";
	}
}
function DeviceConfigMail($Email,$Name,$Device_id,$securityKey)
{
		include("mail/mail.php");
		sendMail($Email,"Your device configured successfully","Hi ".$Name.",<br /><br />This is to inform you that your device <b>".$Device_id."</b> has been configured .Please use the below Security key for your deive configuration.<br/><br /><b>Security key </b> : ".$securityKey."<br /><br />Redards,<br /> Team Geniey.");

}
function configureAPI($vars)
{
	if($_GET['step']==0)
	{
		$query="SELECT * FROM `g_api` ";
	$result=mysql_query($query);
	$rows=array();
	while($r=mysql_fetch_assoc($result))
	{ 
	$rows[]=$r;
	}
	header("Content-type:application/json"); 
	echo json_encode($rows);
	}
	else if($_GET['step']==1)
	{
		if($vars['vendor_id']==1)
		{
		$query1="UPDATE `g_api` SET vals='".$vars['cart']."' where keyss='cart'";
		$query2="UPDATE `g_api` SET vals='".$vars['login']."' where keyss='login'";
		$query3="UPDATE `g_api` SET vals='".$vars['logout']."' where keyss='logout'";
		$query4="UPDATE `g_api` SET vals='".$vars['payaddress']."' where keyss='payaddress'";
		$query5="UPDATE `g_api` SET vals='".$vars['payconfirm']."' where keyss='payconfirm'";
		$query6="UPDATE `g_api` SET vals='".$vars['paymethods']."' where keyss='paymethods'";
		$query7="UPDATE `g_api` SET vals='".$vars['Session']."' where keyss='Session'";
		$query8="UPDATE `g_api` SET vals='".$vars['shipaddress']."' where keyss='shipaddress'";
		$query9="UPDATE `g_api` SET vals='".$vars['shipmethds']."' where keyss='shipmethds'";
		$query10="UPDATE `g_api` SET vals='".$vars['empty_cart']."' where keyss='empty_cart'";
			$res1=mysql_query($query1);
			$res2=mysql_query($query2);
			$res3=mysql_query($query3);
			$res4=mysql_query($query4);
			$res5=mysql_query($query5);
			$res6=mysql_query($query6);
			$res7=mysql_query($query7);
			$res8=mysql_query($query8);
			$res9=mysql_query($query9);
			$res10=mysql_query($query10);
			if(!$res1 && !$res2 && !$res3 && !$res4 && !$res5 && !$res6 && !$res7 && !$res8 && !$res9 && !$res10)
			{
				echo "0";
			}
			else
			{
				echo "1";
			}
		}
		if($vars['vendor_id']==2)
		{
			$query1="UPDATE `g_api` SET vals='".$vars['api']."' where keyss='api'";
			$res1=mysql_query($query1);
			if(!$res1)
			{
				echo "0";
			}
			else
			{
				echo "1";
			}
		}
	}
}
function updateDeviceStatus($vars)
{
	if(!isset($vars['GPS']))
	{
		$vars['GPS']="";
	}
	if(!isset($vars['RSSI']))
	{
		$vars['RSSI']="";
	}
	if(!isset($vars['heap']))
	{
		$vars['heap']="";
	}
	if(!isset($vars['message']))
	{
		$vars['message']="";
	}
	if(!isset($vars['voltage']))
	{
		$vars['voltage']="";
	}
	if(!isset($vars['wificonfig']))
	{
		$vars['wificonfig']="";
	}
	if(!isset($vars['others']))
	{
		$vars['others']="";
	}
	$others=$vars['others'];
	// $others=str_replace('"', '', $others);
	$query="INSERT INTO `g_device_status`( `Device_id`, `GPS`, `RSSI`, `heap`, `message`, `voltage`, `wificonfig`, `others`,`lastUpdated`) VALUES ";
	$query=$query."('".$vars['Device_id']."','".$vars['GPS']."','".$vars['RSSI']."','".$vars['heap']."','".$vars['message']."','".$vars['voltage']."','".$vars['wificonfig']."','".$others."','".$vars['lastUpdated']."')";
	$result=mysql_query($query);
	echo $query;
	echo $result;
}
function registeruser($vars)
{
	$digits = 4;
	$Password=rand(pow(10, $digits-1), pow(10, $digits)-1);
	$query="INSERT INTO `g_user`( `Email`, `Password`) VALUES";
		$query=$query." ('".$vars."','".$Password."')";
		mysql_query($query);
		$userid=mysql_insert_id(); 
		if($userid==0)
		{
			$query="update g_user set Password='".$Password."'  where Email='".$vars."'";
			$res=mysql_query($query);
			echo "1";
		}
		else
		{
			echo "1";
		}
}
function updatePIN($vars)
{
	$digits = 4;
	$Password=rand(pow(10, $digits-1), pow(10, $digits)-1);
	$query="select Email from `g_user` where Email='".$vars['Email']."' and `Password`='".$vars['old_Password']."'";
		mysql_query($query);
		$userid=mysql_insert_id(); 
		if($userid==0)
		{
			$query="update g_user set Password='".$vars['Password']."'  where Email='".$vars['Email']."'";
			$res=mysql_query($query);
			echo "1";
		}
		else
		{
			echo "0";
		}
}
function checkProfile($vars)
{
	$query="SELECT * FROM `g_user` where Status='INACTIVE' and Email='$vars'";
	$res=mysql_query($query);
	if(mysql_fetch_array($res))
	{
		echo "1";
	}
	else
	{
		echo "0";
	}
}
function checkProfile1($vars)
{
	$query="SELECT * FROM `g_user` where Status='INACTIVE' and Email='".$vars['Email']."' and Password='".$vars['Password']."'";
	$res=mysql_query($query);
	if(mysql_fetch_array($res))
	{
		echo "1";
	}
	else
	{
		echo "0";
	}
}
function Updateprofile($vars)
{
	$query="UPDATE `g_user` set Name='".$vars['Name']."',Phone='".$vars['Phone']."',Address='".$vars['Address']."',city='".$vars['city']."',Status='ACTIVE' where Email='".$vars['Email']."'";
	$res=mysql_query($query);
	if($res)
	{
		echo "1";
	}
}
?>