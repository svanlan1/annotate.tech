<?php
  $userID = trim($_POST['userID']);
  mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
  mysql_select_db("annotate_main");
  $query = sprintf("SELECT quickname, example, description, additional, rec_id FROM recs 
    WHERE userID='%s' OR global_rec='Y'",
    mysql_real_escape_string($userID));

    $result = mysql_query($query); 
     $results = array();
    while ($res = mysql_fetch_assoc($result)) {
        $ex = $res['example'];
        $examp = str_replace("<", "&lt;", $ex);
        $newexamp = str_replace(">", "&gt;", $examp);
        //$msg = array($row['session_id']=>json_decode($row['obj']), 'url'=>$row['url'], 'username'=>$row['username']);    	
    	$msg = array('name'=>$res['quickname'], 'rec'=>$res['description'], 'ex'=>$ex,  'add'=>$res['additional'], 'rec_id'=>$res['rec_id']);
    	array_push($results, $msg);
    }
    echo json_encode($results);

?>