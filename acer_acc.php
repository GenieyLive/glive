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
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8080",
  CURLOPT_URL => "http://146.148.28.198:8080/genieyiotgate",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => " {\"id\":\".$var1.\"}",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic YWRtaW46ZG9udHRlbGw=",
    "cache-control: no-cache",
    "postman-token: c73dc838-6cac-f9cf-b569-01e8e46b5950"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}


}
else
{
echo "Faile: could not write to file";
}
?>