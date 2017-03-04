<?php

session_start();
if($_SESSION['login_user_type']=='admin')
{
header("location: addDevice.php"); 
}
if($_SESSION['login_user_type']=='user')
{
header("location: addDevice.php"); 
}


?>