<?php
  session_start();
  require_once 'class.user.php';
  $user_login = new USER();
  $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $storyid = $_GET["story_id"];

  

  mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
  mysql_select_db("annotate_main");
  $query = sprintf("SELECT * FROM news 
    WHERE story_id='%s'",
    mysql_real_escape_string($storyid));

    $result = mysql_query($query);

  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        $msg = array('title'=>$row['title'], 'story'=>$row['title']);
        echo json_encode($msg);
    }  

?>