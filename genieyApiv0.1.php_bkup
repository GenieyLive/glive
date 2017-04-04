<?php
require_once('etc/db.php');
$req_id=0;
if(isset($_GET['device_id']) && isset($_GET['password']))
{
   
    $device_id = $_GET['device_id'];
    $securityKey = $_GET['password'];
    $User_id=0;$product='0';$noofproduct=0;
    $Auth_query="select User_id,Email,g_device.password,product,noofproduct,vendor_id from g_device join g_user using (User_id) where Device_id='$device_id' and securityKey='$securityKey'";
    $Auth_res=mysql_query($Auth_query);
    if($row=mysql_fetch_array($Auth_res))
    {
        $device_status="select * from g_device  where Device_id='$device_id' and Status='ACTIVE'";
        $device_status_res=mysql_query($device_status);
        if($device_status_res_row=mysql_fetch_array($device_status_res))
        {
          $User_id=$row['User_id'];
          $Email=$row['Email'];
          $Password=$row['password'];
          $product=$row['product'];
          $noofproduct=$row['noofproduct'];
          $vendor_id=$row['vendor_id'];
          storeLogs("User Authenticated : ",$Email,$User_id,$device_id);
        }
        else
        {
            storeLogs("Response Device status : Device INACTIVE","",$User_id,$device_id);
            echo "Device not in active status";
            exit;
        }
        $req_id=getReqId($_GET['device_id'],$User_id);
    }
    else
    {
      storeLogs("Response Login :User Authentication Failed","",$User_id,$device_id);
      alertuser($device_id);
       echo "User Authentication Failed";
     exit;
    }

    $API_query="select * from g_api";
    $API_res=mysql_query($API_query);
    $api_url=array();
    while($API_row=mysql_fetch_array($API_res))
    {
        $key=$API_row['keyss'];
        $val=$API_row['vals'];
        $api_url[$key]=$val;
    }
      echo "vendor Id:".$vendor_id;
        if($vendor_id==1)
        {
        include_once("shopyco.php");
        completeRequest($orderResponse,$order_id,$req_id);
        }
        if($vendor_id==2)
        {
        include_once("snapdeal.php");
        $orderResponse="Processed sucessfully";
        $order_id=" ";
        completeRequest($orderResponse,$order_id,$req_id);
        }
}
else
{
  echo "404 Bad gateway";
}

function storeLogs($head_logs,$logs,$User_id,$device_id)
{
  $req_id= $GLOBALS['req_id'];
  $query="INSERT INTO `g-logs`(`logs`,head_logs,`req_id`) VALUES ('$logs','$head_logs',$req_id)";
  mysql_query($query);
  if(isset($_GET['admin']))
  {
    echo "<b>".$head_logs."</b>";
    echo strip_tags($logs,"<b>");
    echo "<br />";
  }
}
function getReqId($device_id,$User_id)
{
    $query="INSERT INTO `g_log`( `User_id`, `Device_id`) VALUES ('$User_id','$device_id')";
    mysql_query($query);
    $userid=mysql_insert_id(); 
    return $userid;
}
function completeRequest($orderResponse,$order_id,$req_id)
{
    require('etc/mail/mail.php');
    echo $orderResponse;
    if($orderResponse)
    {
       $sub=$req_id . " : "."Your request has been reveived from Iot Device ".$GLOBALS['device_id'];
       $bod=" We received your request from IoT device and order has been placed for the same. <br> Order Id :".$order_id;
       $bod=$bod."<br /><br/>Regards,<br /> Admin";
       sendMail($GLOBALS['Email'],$sub,$bod);
       updateStatus("Request has been processed successfully",$req_id);
    }
    else
    {
       $sub=$GLOBALS['req_id'] . " : "."Your request has been reveived from Iot Device ".$GLOBALS['device_id'];
       $bod=" We are unable to process your request. Please reply to this mail if your attempted valid request,we will will get back to you shortly";
       $bod=$bod."<br /><br/>Regards,<br /> Admin";
       sendMail($GLOBALS['Email'],$sub,$bod);
       updateStatus("Unable to process your request",$req_id);
    }
}
function alertuser($device_id)
{
        require('etc/mail/mail.php');
        $query="select User_id,Email,Password,product,noofproduct from g_device join g_user using (User_id) where Device_id='$device_id' ";
        $res=mysql_query($query);
        if($row=mysql_fetch_array($res))
        {
           $User_id=$row['User_id'];
           $Email=$row['Email'];
           $sub="suspicious device attempt has been detected on Iot Device : $device_id";
           $bod="Someone accessed your Iot device with wrong configuraion. Please confiure your IoT device with valid data if your accessed your device.";
           $bod=$bod."<br /><br/>Regards,<br /> Admin";
           sendMail($Email,$sub,$bod);
        }
}
function updateStatus($status,$req_id)
{
    $query="UPDATE `g_log` SET `status`='$status' WHERE `req_id`=$req_id";
    $res=mysql_query($query);
    echo $status;
}
?>
