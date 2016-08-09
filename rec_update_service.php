<?php

  $rec_id = $_POST['rec_id'];
  mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
  mysql_select_db("annotate_main");
  $query = sprintf("SELECT * FROM recs 
    WHERE rec_id='%s'",
    mysql_real_escape_string($rec_id));

    $result = mysql_query($query); 

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        echo $message;
        die($message);
    }
    while ($res = mysql_fetch_assoc($result)) {
     echo $res['quickname'];
    }
?>
