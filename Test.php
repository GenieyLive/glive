<?php
echo date('D M d Y H:i:s T O');
$row['type']="1";
$res=$row['type']==1?"admmin":"user";
echo $res;
$device_id="device id kj78gehwjjU766ghsjsj";
echo $device_id;
require('etc/mail/mail.php');

$s=file_get_contents('etc/mail/action.html');
sendMail("naveen.ccmsd@gmail.com","test subj",$s);
echo "mail sent ";

?>
