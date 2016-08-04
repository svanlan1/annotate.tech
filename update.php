<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

$userID = trim($_POST['userID']);
$url = trim($_POST['url']);
$obj = trim($_POST['obj']);
$session_id = trim($_POST['session_id']);


if($user_home->update_annotation($userID,$url,$obj,$session_id))
{
  $msg = array('Result'=>'Success');
  echo json_encode($msg);
} else {
  $msg = array('Result'=>'Failure.  Dont know why.');
  echo json_encode($msg);
}

?>