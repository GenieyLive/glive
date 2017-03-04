<?php
require_once('etc/db.php');
 $query="select * from naveen_table ";
 $result = "{'success':false}";
 $dbresult=mysql_query($query);
 $markers = array();
 while($row=mysql_fetch_array($dbresult)){
 
    $markers[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'lat' => $row['lat'],
      'lng' => $row['lng']
    );
  }
  if($dbresult){
    $result = "{\"success\":true, \"markers\":" . json_encode($markers) . "}";        
  }
  else
  {
    $result = "{'success':false}";
  }
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
 
  echo($result);
 
?>