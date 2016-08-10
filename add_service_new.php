<?php
$servername = "localhost";
$username = "annotate_admin";
$password = "XtcVsAA1979";
$dbname = "annotate_main";

$userID = trim($_POST['userID']);
$userName = trim($_POST['username']);
$url = trim($_POST['url']);
$obj = json_encode($_POST["obj"]);
$page_title = trim($_POST['page_title']);
$session = $_POST['session_id'];
$date = time();

echo $session;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = 	"INSERT INTO results (userID, url, obj, page_title, updated, session_id, username) 
					VALUES ('$userID', '$url','$obj','$page_title','$date','$session','$userName')
						ON DUPLICATE KEY UPDATE
							obj='$obj', updated='$date', url='$url', username='$userName'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>