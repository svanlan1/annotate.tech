<?php
$servername = "localhost";
$username = "annotate_admin";
$password = "XtcVsAA1979";
$dbname = "annotate_main";

$userID = trim($_POST['userID']);
$quickname = trim($_POST['quickname']);
$example = trim($_POST['example']);
$description = trim($_POST['description']);
$additional = trim($_POST['additional']);
$rec_id = trim($_POST['rec_id']);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = 	"INSERT INTO recs (userID, quickname, example, description, additional, rec_id) 
					VALUES ('$userID', '$quickname','$example','$description','$additional', '$rec_id')
						ON DUPLICATE KEY UPDATE
							quickname='$quickname', example='$example', description='$description', additional='$additional'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>