<?php
  session_start();
  require_once 'class.user.php';
  $user_home = new USER();
  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $rec_id = $_POST['rec_id'];
  if($user_home->delete_rec($rec_id))
  {
    echo 'Record '.$rec_id.' has been successfully removed.';
  } 
?> 