<?php
$var1 = $_GET['device_id'];
$var2 = $_GET['password'];
$fileContent = "Today is " . date("Y-m-d h:i:sa") . " Device Id ".$var1." and Password ".$var2." -Done.\n";
$fileStatus= file_put_contents('myFile.txt',$fileContent,FILE_APPEND);
if(fileStatus != false)
{
echo "SUCCESS: Datat Written to File";

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$url	= "http://www.iot.shopyco.com.tw/index.php?route=feed/rest_api/session";
$secret = "123"; 

$ch = curl_init($url);
		
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	"X-Oc-Merchant-Id: ".$secret
));

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$data = json_decode($response, true);
$sessionid = $data['data']['session'];

echo("<pre>sessionid:");
print_r($sessionid);
echo("</pre>");
curl_close($ch);

echo("1.Login");
 
$data_string = "{\"email\":\"".$var1."\",\"password\":\"".$var2."\"}";                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/index.php?route=rest/login/login');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);


echo("6. getwishlist");
 
$url	= "http://www.iot.shopyco.com.tw/api/rest/wishlist";
$ch = curl_init($url);
		
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Oc-Merchant-Id: '.$secret,
    'X-Oc-Session: '.$sessionid   
));

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$data = json_decode($response, true);	
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);


echo("2.Empty Cart");                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/index.php?route=rest/cart/emptycart');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);

echo("2.add product");
$data_string = "{\"product_id\": \"5077\",\"quantity\": \"2\"}";                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/index.php?route=rest/cart/cart');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);

echo("3. Load user payment address");
$url	= "http://www.iot.shopyco.com.tw/index.php?route=rest/payment_address/paymentaddress";
$ch = curl_init($url);
		
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Oc-Merchant-Id: '.$secret,
    'X-Oc-Session: '.$sessionid   
));

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$data = json_decode($response, true);	
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);

echo("4. set paymentaddress();");
$address = array("payment_address"=>"existing", "address_id"=> "41");
$data_string = json_encode($address);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/index.php?route=rest/payment_address/paymentaddress');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 
 
 echo("5.shippingaddress");
 
$shipaddress = array("shipping_address"=>"existing", "address_id"=> "41");
$data_string = json_encode($shipaddress);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/api/rest/shippingaddress');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 
 
 
 
 echo("6. getpaymentmethods");
 
$url	= "http://www.iot.shopyco.com.tw/api/rest/paymentmethods";
$ch = curl_init($url);
		
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Oc-Merchant-Id: '.$secret,
    'X-Oc-Session: '.$sessionid   
));

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$data = json_decode($response, true);	
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);


 
 echo("7.setpaymentmethods();");
 
$paymentmethod= array("payment_method"=>"cod", "agree"=>"1", "comment"=>"Order from Linkit One MCU");
//var = "{\"payment_method\": \"cod\",\"agree\": \"1\",	\"comment\": \"Order from Linkit One MCU\"}";
$data_string = json_encode($paymentmethod);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/api/rest/paymentmethods');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 


echo("8. getshippingmethods");
 
$url	= "http://www.iot.shopyco.com.tw/api/rest/shippingmethods";
$ch = curl_init($url);
		
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Oc-Merchant-Id: '.$secret,
    'X-Oc-Session: '.$sessionid   
));

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$data = json_decode($response, true);	
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch);


echo("7.setshippingmethods();");
 
$paymentmethod= array("shipping_method"=>"flat.flat", "comment"=>"Order From IOT device ID: 19283746");
// var = "{\"shipping_method\": \"flat.flat\",\"comment\": \"Order From IOT device ID: 19283746\"}";

$data_string = json_encode($paymentmethod);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/api/rest/shippingmethods');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 


echo("7.postconfirm();");
 
$paymentmethod= array("");
//  var = "";

$data_string = json_encode($paymentmethod);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/api/rest/confirm');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 



echo("7.putconfirm();");
 
$paymentmethod= array("");
//  var = "";

$data_string = json_encode($paymentmethod);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/api/rest/confirm');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 



echo("7.logout();");
 
$paymentmethod= array("");
//  var = "";

$data_string = json_encode($paymentmethod);                                                                                   
$ch = curl_init('http://www.iot.shopyco.com.tw/api/rest/logout');                                                                      
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
echo("<pre>");
print_r($data);
echo("</pre>");
curl_close($ch); 

 
 
  
 
  //  getsessionid();   
     // emptycart();
  //  login();   
  //  getwishlist();
  //  add_cart();
  //  paymentaddress();   
  //  shippingaddress();  
  //  getpaymentmethods();
  //  setpaymentmethods();
  //  getshippingmethods();
 //   setshippingmethods();
  //  postconfirm();
  //  putconfirm();  
   
  //  logout();


}
else
{
echo "Faile: could not write to file";
}
?>