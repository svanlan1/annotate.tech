<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

$subject = trim($_POST['subject']);
$email = "endoflineprod@gmail.com";
$comments = trim($_POST['comments']);

if($reg_user->send_mail($email,$comments,$subject)) {
echo 'success bitch';
//header("Location: success.php?feedback");
} else {
echo 'fail bitch';
//header("Location: error.php?error-already-exists");
}
