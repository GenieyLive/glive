<?php
echo date('D M d Y H:i:s T O');
$row['type']="1";
$device_id="lol";
$res=$row['type']==1?"admin":"user";
echo $res;
require('etc/mail/mail.php');
$s = file_get_contents('etc/mail/action.html');
$s = str_replace('$device_id', 'lol', $s);
// sendMail("naveen.ccmsd@gmail.com","Test Subject",$s);
echo $s;
// echo sprintf($s, $device_id);

?>
