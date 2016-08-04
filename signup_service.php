<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}


//if(isset($_POST['btn-signup']))
//{
	$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$fname = trim($_POST['txtfname']);
	$lname = trim($_POST['txtlname']);
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  email allready exists , Please Try another one
			  </div>
			  ";

		echo 'User already exists.  Try that shit again.';
	}
	else
	{
		if($reg_user->register($uname,$email,$upass,$fname,$lname,$code))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
			$message = "					
						<link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet'>
						<link href='http://annotate.tech/css/materialize.min.css' rel='stylesheet'>
						<link href='http://annotate.tech/css/annotate.css' rel='stylesheet'>
						Hello $fname $lname,
						<br /><br />
						<h1 class='annotate'>Welcome to Annotate!</h1><br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a class='btn-large waves-effect waves-light blue darken-3 white-text' href='http://annotate.tech/verify.php?id=$id&code=$code'>Click here to Activate</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	

			echo 'Success!  You will receive a confirmation email shortly.';

		}
		else
		{
			//echo "sorry , Query could no execute...";
		}		
	}
//}
?>