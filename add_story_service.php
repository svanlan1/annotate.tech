<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


  $by = $row['userID'];
  $date = time();
  $id = md5(uniqid(rand()));
  $story = trim($_POST['story']);
  $title = trim($_POST['title']);
  $fName = $row['first_name'];
  $lName = $row['last_name'];

  if($user_home->add_news($by,$date,$id,$story,$title,$fName,$lName))
  {
    //$user_home->redirect('settings.php?success-story');
    $msg = array('result'=>'success');
    //echo json_encode($msg);
  } else {
    $msg = array('result'=>'fail');
    //echo json_encode($msg);
  }
?>