<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	//$reg_user->redirect('home.php');
}


//if(isset($_POST['btn-signup']))
//{
	$uname = trim($_POST['userName']);
	$email = trim($_POST['userEmail']);
	$upass = trim($_POST['userPass']);
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
		$res =  array('response'=>'duplicate');
		echo json_encode($res);
	}
	else
	{
		if($reg_user->register($uname,$email,$upass,$code))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
			$message = "					
						<link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet'>
						<link href='http://annotate.tech/css/materialize.min.css' rel='stylesheet'>
						<link href='http://annotate.tech/css/annotate.css' rel='stylesheet'>
						Hello $uname,
						<br /><br />
						<h1 class='annotate'>Welcome to Annotate!</h1><br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a class='btn-large waves-effect waves-light blue darken-3 white-text' href='http://annotate.tech/register/verify.php?id=$id&code=$code'>Click here to Activate</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	
			/*$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
			  		</div>
					";*/

			$test = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
			$test->execute(array(":email_id"=>$email));
			$newrow = $stmt->fetch(PDO::FETCH_ASSOC);					

			//echo 'Account successfully created';
			$res = array('response'=>'success');
				echo json_encode($res);
				echo json_encode($newrow);
			//$reg_user->redirect('home.php');
		}
		else
		{
			echo "sorry , Query could no execute...";
		}		
	}
//}
?>