<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

$userID = trim($_POST['userID']);
$url = trim($_POST['url']);

if($user_home->query_store($userID,$url))
{
	echo 'query success';
}

?>