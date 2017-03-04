<?php
session_start(); 
if(isset($_SESSION['login_user']) && isset($_SESSION['login_user_type']))
{
	if($_SESSION['login_user_type']!="admin")
	{
		echo "Invalid Access";
		exit -1;
	}
}
else
{
	header("location: ../index.php"); 
}
?>