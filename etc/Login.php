<?php
require_once('db.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) 
{
	if (empty($_POST['email']) || empty($_POST['password'])) 
	{
	$error = "Username or Password is invalid";
	}
	else
	{
	$username=$_POST['email'];
	$password=$_POST['password'];
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);

	$query = mysql_query("select * from g_user where Password='$password' AND Email='$username'", $con);
	$rows = mysql_num_rows($query);
	if ($rows >= 1) {
		$_SESSION['login_user']=$username;
		if($row= mysql_fetch_array($query))
		{
			$_SESSION['login_user_name']=$row['Name'];
			$_SESSION['login_user_type']=$row['type']==1?"admin":"user";
		}
		
	} 
	else 
	{
	$_SESSION['error']="Fail";
	$error = "Username or Password is invalid";
	}
	header("location: ../index.php"); 
	mysql_close($connection); // Closing Connection
	}
}
else 
{
	echo "404 : Bad Access";
	header("location: Logout.php");
}
?>