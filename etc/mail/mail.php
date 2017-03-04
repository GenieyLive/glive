<?php

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
if(isset($_GET['mail']))
{
    $toaddress=$_GET['To'];
    if(isset($_GET['Subject']))
    {
        $Subject=$_GET['Subject'];
    }
    else
    {
        $Subject=" ";
    }
    if(isset($_GET['body']))
    {
        $body=$_GET['body'];
    }
    else
    {
        $body=" ";
    }
    $r=sendMail($toaddress,$Subject,$body);
    echo $r;
}
if(isset($_POST['mail']))
{
    $toaddress=$_POST['To'];
    if(isset($_POST['Subject']))
    {
        $Subject=$_POST['Subject'];
    }
    else
    {
        $Subject=" ";
    }
    if(isset($_POST['body']))
    {
        $body=$_POST['body'];
    }
    else
    {
        $body=" ";
    }
    $r=sendMail($toaddress,$Subject,$body);
    echo $r;
}

function sendMail($toaddress,$Subject,$body)
{
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->PluginDir = './PHPMailer_5.2.0/'; // relative path to the folder where PHPMailer's files are located
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPAuth = true;
$mail->Host = 'mail.shopyco.com.tw'; // "ssl://smtp.gmail.com" didn't worked
// $mail->Host = 'mail.shopyco.com.tw';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
// or try these settings (worked on XAMPP and WAMP):
// $mail->Port = 587;
// $mail->SMTPSecure = 'tls';


$mail->Username = "test@shopyco.com.tw";
$mail->Password ="admin@123";

$mail->IsHTML(true); // if you are going to send HTML formatted emails
$mail->SingleTo = true; // if you want to send mail to the users individually so that no recipients can see that who has got the same email.

$mail->From = "test@shopyco.com.tw";
$mail->FromName = "Geniey";


$mail->addAddress($toaddress,'user');


$mail->addCC("naveen.ccmsd@gmail.com","Naveen");


$mail->Subject = $Subject;
$mail->Body =$body;

if(!$mail->Send())
    return 0;
else
    return 1;
}

	?> 
