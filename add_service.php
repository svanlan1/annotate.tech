<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

$userID = trim($_POST['userID']);
$url = trim($_POST['url']);
$obj = trim($_POST['obj']);
$session_id = md5(uniqid(rand()));

if($user_home->add_annotation($userID,$url,$obj,$session_id))
{
  $msg = array('Result'=>'Success');
  echo json_encode($msg);
} else {
  $msg = array('Result'=>'Failure.  Dont know why.');
  echo json_encode($msg);
}

?>