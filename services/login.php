<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST'); 
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
    $msg = array('account'=>'Users is already logged in!');
    echo json_encode($msg);
}
else
{
  $email = trim($_POST['userEmail']);
  $upass = trim($_POST['userPass']);
  
  if($user_login->login($email,$upass))
  {
    //$user_login->redirect('home.php');
    //$msg = array('account'=>'success');
    //echo json_encode($msg);
  }  
}
?>