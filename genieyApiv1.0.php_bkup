<?php
require_once('etc/db.php');
$req_id=0;

$QUERY_STRING= $_SERVER['QUERY_STRING'];
parse_str($QUERY_STRING, $output);
echo $QUERY_STRING;
updateDeviceStatus($output);
if(isset($_GET['device_id']) && isset($_GET['password']))
{
   
    $device_id = $_GET['device_id'];
    $securityKey = $_GET['password'];
    $User_id=0;$product='0';$noofproduct=0;
    $Auth_query="select User_id,Email,g_user.Password as Password,product,noofproduct from g_device join g_user using (User_id) where Device_id='$device_id' and securityKey='$securityKey'";
    $Auth_res=mysql_query($Auth_query);
    if(mysql_num_rows($Auth_res)>0)
    {
        $device_status="select * from g_device  where Device_id='$device_id' and Status='ACTIVE'";
        $device_status_res=mysql_query($device_status);
        if($device_status_res_row=mysql_fetch_array($device_status_res))
        {
          $User_id=$row['User_id'];
          $Email=$row['Email'];
          $Password=$row['Password'];
          $product=$row['product'];
          $noofproduct=$row['noofproduct'];
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
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);
    $secret = $api_url['secret']; 

    $ch = curl_init($api_url['Session']);
    		
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	"X-Oc-Merchant-Id: ".$secret
    ));

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $data = json_decode($response, true);
    $sessionid = $data['data']['session'];
    storeLogs("Session generated : ",$sessionid,$User_id,$device_id);
    curl_close($ch);
         
    $data_string = "{\"email\":\"".$Email."\",\"password\":\"".$Password."\"}";                                                                                   
    $ch = curl_init($api_url['login']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                             
        'Content-Length: ' . strlen($data_string))                                                                       
    );           

    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Response Login : ",$data,$User_id,$device_id);
    curl_close($ch);
                                                                                   
    $ch = curl_init($api_url['empty_cart']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid)                                                                                                                                               
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true); 
    $data=json_encode($data);
    storeLogs("Request Clear cart : ",$data_string,$User_id,$device_id);
    storeLogs("Response Clear cart : ",$data,$User_id,$device_id);
    curl_close($ch);

    
    $data_string = "{\"product_id\": \"".$product."\",\"quantity\": \"".$noofproduct."\"}";                                                                                   
    $ch = curl_init($api_url['cart']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                          
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Request Add cart : ",$data_string,$User_id,$device_id);
    storeLogs("Response Add cart : ",$data,$User_id,$device_id);
    curl_close($ch);



    $ch = curl_init($api_url['payaddress']);
    		
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid   
    ));

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $data = json_decode($response, true);	
    foreach($data as $value){
    $addressid=$value['address_id'];
    }
    $data=json_encode($data);
    storeLogs("Response getpay Address : ",$data,$User_id,$device_id);
    curl_close($ch);

    $address = array("payment_address"=>"existing", "address_id"=> $addressid);
    $data_string = json_encode($address);                                                                                   
    $ch = curl_init($api_url['payaddress']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Request Setpay address : ",$data_string,$User_id,$device_id);
    storeLogs("Response SetPay Address : ",$data,$User_id,$device_id);
    curl_close($ch);
     
     
    $shipaddress = array("shipping_address"=>"existing", "address_id"=> $addressid);
    $data_string = json_encode($shipaddress);                                                                                   
    $ch = curl_init($api_url['shipaddress']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Request SetShip Address : ",$data_string,$User_id,$device_id);
    storeLogs("Response SetShip  Address : ",$data,$User_id,$device_id);
    curl_close($ch); 
     

    $ch = curl_init($api_url['paymethods']);
    		
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid   
    ));

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Response get Paymenthods   : ",$data,$User_id,$device_id);
    curl_close($ch);

     
    $paymentmethod= array("payment_method"=>"cod", "agree"=>"1", "comment"=>"Order from Linkit One MCU");
    //var = "{\"payment_method\": \"cod\",\"agree\": \"1\",	\"comment\": \"Order from Linkit One MCU\"}";
    $data_string = json_encode($paymentmethod);                                                                                   
    $ch = curl_init($api_url['paymethods']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
     $data=json_encode($data);
    storeLogs("Response Set Paymenthods Address : ",$data,$User_id,$device_id);
    curl_close($ch); 

     

    $ch = curl_init($api_url['shipmethds']);  		
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid   
    ));

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Response get shipmethds : ",$data,$User_id,$device_id);
    curl_close($ch); 


     
    $paymentmethod= array("shipping_method"=>"flat.flat", "comment"=>"Order From IOT device ID: ".$device_id);
    // var = "{\"shipping_method\": \"flat.flat\",\"comment\": \"Order From IOT device ID: 19283746\"}";

    $data_string = json_encode($paymentmethod);                                                                                   
    $ch = curl_init($api_url['shipmethds']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Response Set shipmethds : ",$data,$User_id,$device_id);
    curl_close($ch); 

     
    $paymentmethod= array("");
    //  var = "";

    $data_string = json_encode($paymentmethod);                                                                                   
    $ch = curl_init($api_url['payconfirm']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Response post confirm : ",$data,$User_id,$device_id);
    curl_close($ch); 



     
    $paymentmethod= array("");
    //  var = "";

    $data_string = json_encode($paymentmethod);                                                                                   
    $ch = curl_init($api_url['payconfirm']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $orderResponse=$data['success'];
    $order_id=$data['order_id'];
    $data=json_encode($data);
    storeLogs("Response PUT confirm : ",$data,$User_id,$device_id);
    curl_close($ch);  

     
    $paymentmethod= array("");
    //  var = "";

    $data_string = json_encode($paymentmethod);                                                                                   
    $ch = curl_init($api_url['logout']);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_HEADER, 0);                                                                  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',     
        'X-Oc-Merchant-Id: '.$secret,
        'X-Oc-Session: '.$sessionid,                                                                       
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                           
     
    $response = curl_exec($ch);
    $data = json_decode($response, true);	
    $data=json_encode($data);
    storeLogs("Response Logout: ",$data,$User_id,$device_id);
    curl_close($ch); 
    completeRequest($orderResponse,$order_id,$req_id);
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
        $query="select User_id,Email,g_user.Password as Password,product,noofproduct from g_device join g_user using (User_id) where Device_id='$device_id' ";
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
