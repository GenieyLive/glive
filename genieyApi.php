<?php
require_once('etc/db.php');
$req_id=0;
$QUERY_STRING= $_SERVER['QUERY_STRING'];
parse_str($QUERY_STRING, $output);
// echo $QUERY_STRING;
updateDeviceStatus($output);
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
     ?><script type="text/javascript">console.log("vendor Id: <?php echo $vendor_id; ?>");</script>  <?php
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
       $sub=$req_id . " : "."Thank you for your Request - ".$GLOBALS['device_id'];
       $body= file_get_contents('etc/mail/completeRequest.html');
       $body = str_replace('$device_id',$GLOBALS['device_id'], $body);
       $body = str_replace('$req_id', $req_id, $body);
       $body = str_replace('$order_id', $order_id, $body);
       sendMail($GLOBALS['Email'],$sub,$body);
       updateStatus("Request has been processed successfully",$req_id);
    }
    else
    {
       $sub=$req_id . " : "."Sorry problem with your Request - ".$GLOBALS['device_id'];
        $sub1=$req_id . " : "."Problem with my Request - ".$GLOBALS['device_id'];
       $body= file_get_contents('etc/mail/completeRequest_fail.html');
       $body = str_replace('$device_id', $GLOBALS['device_id'], $body);
       $body = str_replace('$req_id', $req_id, $body);
       $body = str_replace('$order_id', $order_id, $body);
       $body = str_replace('$Email', $GLOBALS['Email'], $body);
        $body = str_replace('$sub', $sub1, $body);
       sendMail($GLOBALS['Email'],$sub,$body);
       updateStatus("Unable to process your request",$req_id);
    }
}
function alertuser($device_id)
{
        require('etc/mail/mail.php');
        $query="select User_id,Email,g_user.Password as Password,product,noofproduct from g_device join g_user using (User_id) where Device_id='$device_id' ";
        $res=mysql_query($query);
        if($row=mysql_fetch_array($res))
        {
           $User_id=$row['User_id'];
           $Email=$row['Email'];
           $sub="Suspicious attempt detected on Iot Device : $device_id";
           $body= file_get_contents('etc/mail/alertuser.html');
           $body = str_replace('$device_id', $device_id, $body);
           // $body = str_replace('$req_id', $req_id, $body);
           sendMail($Email,$sub,$body);
        }
}
function updateStatus($status,$req_id)
{
    $query="UPDATE `g_log` SET `status`='$status' WHERE `req_id`=$req_id";
    $res=mysql_query($query);
    // echo $status;
}
//update the  device status into server
function updateDeviceStatus($deviceDetails)
{
    if(isset($deviceDetails['device_id']))
    {
        // $data_string = "{";   
        // foreach ($deviceDetails as $key => $value) {
        //       $data_string.= "\"$key\":\"$value\",";
        //     }
        // $data_string.="\"Test\":\"test\"}";
        // echo $data_string;
        $data_string['Device_id']= @$deviceDetails['device_id'];unset($deviceDetails['device_id']);
        $data_string['GPS']= @$deviceDetails['GPS'];unset($deviceDetails['GPS']);
        $data_string['RSSI']= @$deviceDetails['RSSI'];unset($deviceDetails['RSSI']);
        $data_string['heap']= @$deviceDetails['heap'];unset($deviceDetails['heap']);
        $data_string['message']= @$deviceDetails['message'];unset($deviceDetails['heap']);
        $data_string['voltage']= @$deviceDetails['voltage'];unset($deviceDetails['voltage']);
        $data_string['wificonfig']= @$deviceDetails['wificonfig'];unset($deviceDetails['wificonfig']);
        $data_string['lastUpdated']=date('D M d Y H:i:s T O');unset($deviceDetails['password']);
        $data_string['others']=json_encode($deviceDetails);

        
        include("etc/JsConfig.php");
?>
     <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="dist/js/firebase.js"></script>
    <script type="text/javascript">
    $.ajax({
    type: "GET",
    url: site_url+"/etc/updateDB.php?route=updateDeviceStatus&table=ok",
    data:{vars:<?php print json_encode($data_string); ?>},
    success: function(data) {
        console.log(data);
    }
    });
    </script>

<?php
    }
}
?>
