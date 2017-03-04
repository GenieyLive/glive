<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php

function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
if(isset($_POST['mail']))
{
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->PluginDir = './PHPMailer_5.2.0/'; // relative path to the folder where PHPMailer's files are located
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPAuth = true;
$mail->Host = 'smtp.gmail.com'; // "ssl://smtp.gmail.com" didn't worked
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
// or try these settings (worked on XAMPP and WAMP):
// $mail->Port = 587;
// $mail->SMTPSecure = 'tls';


$mail->Username = "naveen.ccmsd@gmail.com";
$mail->Password = decryptIt("k5KMvM4dpC9/ebpAAddoizsgxJ0mtohsMevqx+Oe6Uw=");

$mail->IsHTML(true); // if you are going to send HTML formatted emails
$mail->SingleTo = true; // if you want to send mail to the users individually so that no recipients can see that who has got the same email.

$mail->From = "info@gmail.com";
$mail->FromName = "Geniey";
$toaddress=$_POST['toadd'];

$mail->addAddress($toaddress,'user');


$mail->addCC("naveen.ccmsd@gmail.com","Naveen");


$mail->Subject = "Testing PHP Mailer with localhost";
$mail->Body = "Hi,<br /><br />This system is working perfectly.";
$mail->AddAttachment("poll_result.txt");

if(!$mail->Send())
    echo "Message was not sent <br />PHP Mailer Error: " . $mail->ErrorInfo;
else
    echo "Message has been sent";
	}
	?> 

<body>
<form  name="form1" action="new_smtp.php" method="post">
MAIL ID:<input type="text"  name="toadd"/></br>
<input type="submit" value="mail" name="mail"/>
</form>

</body>
</html>
