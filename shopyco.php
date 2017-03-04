<?php
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
?>