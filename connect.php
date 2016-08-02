<?php
$connection = mysql_connect('localhost', 'annotate_admin', 'XtcVsAA1979');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('annotate_main');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}