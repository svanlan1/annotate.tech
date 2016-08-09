<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST'); 
session_start();
require_once 'class.user.php';
$user_login = new USER();
$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($user_login->is_logged_in()!="")
{
    $msg = array('account'=>'User is already logged in!', 'userID'=>$row['userID'], 'first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'email_address'=>$row['userEmail']);
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