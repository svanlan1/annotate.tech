<?php
  session_start();
  require_once 'class.user.php';
  $user_home = new USER();
  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $session_id = $_POST['session_id'];
  if($user_home->delete_annotation($session_id))
  {
    echo 'Record '.$session_id.' has been successfully removed.';
  } 
?> 