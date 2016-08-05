<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

$userID = trim($_POST['userID']);
$url = trim($_POST['url']);
$obj = trim($_POST['obj']);

if($user_home->update_annotation($userID,$url,$obj))
{
  $msg = array('Result'=>'Success');
  echo json_encode($msg);
} else {
  $msg = array('Result'=>'Failure.  Dont know why.');
  echo json_encode($msg);
  //$user_home->update_annotation($userID,$url,$obj);
}

?>