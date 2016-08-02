<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	//$user_login->redirect('home.php');
	echo 'Already logged in';
}
else
{
	$email = trim($_POST['userEmail']);
	$upass = trim($_POST['userPass']);
	
	if($user_login->login($email,$upass))
	{
		echo 'Success!';
	}	
}
?>