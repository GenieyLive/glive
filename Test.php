<?php
echo date('D M d Y H:i:s T O');
$row['type']="1";
$res=$row['type']==1?"admin":"user";
echo $res;
require('etc/mail/mail.php');
sendMail("naveen.ccmsd@gmail.com","Test Subject","Complete test mail");
?>
