<?php
	session_start();
	require_once 'class.user.php';
	$user_login = new USER();
	$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['userSession']));
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	//$userID = $user['userID'];

	$userID = trim($_POST['userID']);
	$url = trim($_POST['url']);
	mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
	mysql_select_db("annotate_main");
	$query = sprintf("SELECT url, obj, session_id FROM store 
    WHERE userID='%s' AND url='%s'",
    mysql_real_escape_string($userID),
    mysql_real_escape_string($url));

    $result = mysql_query($query);
	if (!$result) {
	    $message  = 'Invalid query: ' . mysql_error() . "\n";
	    $message .= 'Whole query: ' . $query;
	    echo $message;
	    die($message);
	}    

	while ($row = mysql_fetch_assoc($result)) {
	    //$msg = array('results'=>$row['obj'],'URL'=>$row['url'],'session_id'=>$row['session_id']);
	    //$msg = "[{url:".$row['url'].",obj:".$row['obj']."}]";
	    $msg = $row['obj'];
	    echo json_encode($msg);
	}

	mysql_free_result($result);
?>