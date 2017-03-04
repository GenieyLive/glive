<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $api_url['api'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n    \"loginToken\": \"".$$Password."\",\r\n    \"pincode\": \"122008\",\r\n    \"items\": [{\r\n        \"catalogId\": 50606,\r\n        \"supc\": \"1040103\",\r\n        \"vendorCode\": \"S25b97\",\r\n        \"quantity\": 1\r\n    }]\r\n}",
  CURLOPT_HTTPHEADER => array(
    "accept-encoding: gzip",
    "api_key: snapdeal",
    "cache-control: no-cache",
    "connection: Keep-Alive",
    "content-type: application/json",
    "deviceid: 359648069215740",
    "host: mobileapi.snapdeal.com",
    "login-token: ".$Password,
    "os: android",
    "user-agent: android",
    "v: 6.0.5"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
$data = json_decode($response, true);	
echo("<pre>");
print_r($data);
echo("</pre>");
}