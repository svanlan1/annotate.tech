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
$eUrl = mysql_escape_string ($url);
$eUser = mysql_escape_string ($userID);

	mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
	mysql_select_db("annotate_main");
	$query = sprintf("SELECT url, obj, session_id, updated FROM results
    WHERE userID='$eUser' AND url='$eUrl'");

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
	    if($row['obj'] !== "[]")
	    {
	    	$msg = json_decode($row['obj']);
	    	echo json_encode($msg);
	    }
	    
		//$obj = stripcslashes ( $row['obj'] );
	    //$msg = array('session_id'=>$row['session_id'], 'results'=>$obj, 'updated'=>$row['updated']);
	    
	}

	mysql_free_result($result);
?>