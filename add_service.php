<?php
$servername = "localhost";
$username = "annotate_admin";
$password = "XtcVsAA1979";
$dbname = "annotate_main";

$userID = trim($_POST['userID']);
$url = trim($_POST['url']);
$obj = trim($_POST['obj']);
$date = time();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/*$sql = "INSERT INTO store (userID, url, obj, updated)
VALUES ($userID, $url, $obj, $date)";*/

$sql = 	"INSERT INTO store (userID, url, obj, updated) 
					VALUES ('$userID', '$url','$obj','$date')
						ON DUPLICATE KEY UPDATE
							userID='$userID', url='$url', obj='$obj', updated='$date'";	

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>