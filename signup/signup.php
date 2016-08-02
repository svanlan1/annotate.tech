<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
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
						<a class='btn-large waves-effect waves-light blue darken-3 white-text' href='http://annotate.tech/register/verify.php?id=$id&code=$code'>Click here to Activate</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	

		}
		else
		{
			echo "sorry , Query could no execute...";
		}		
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate!</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
  <link href="css/annotate.css" type="text/css" rel="stylesheet" media="screen, projection" />
  <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/hmapkigpghjemmoodagegimpoimooamc">
  <link rel="icon" 
      type="image/png" 
      href="images/marker_16_active.png"> 
</head>
<body>
  <div class="navbar-fixed">
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="http://annotate.tech" class="brand-logo annotate">annotate<span class="small">.tech</span></a>
      <form class="form-signin" method="post">
          <?php
          if(isset($_GET['error']))
      {
        ?>
          <div class='alert alert-success'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Wrong Details!</strong> 
        </div>
              <?php
      }
      ?>      
      <ul class="right hide-on-med-and-down annotate">
        <li>
        	<a href="login.php">Login</a>
        </li>   
      </ul>
      </form>
      <ul id="nav-mobile" class="side-nav">
        <li>
			<a href="login.php">Login</a>
        </li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  </div>

  <div id="index-banner" class="parallax-container" style="height: 48rem;">
    <div class="section">
      <div class="container">

      <div class="row">
        <br><br>
        <h1 class="annotate black-text lighter" id="banner-h1" style="text-shadow: #999 1px 1px 1px; font-size: 3rem;">Sign up for an account<span style="font-size: 1rem;">it's free</span></h1>
		<div class="left-align">
			<form class="form-signin small_width" method="post">
	      		<span style="display: block;">
	      			<label for="username" required class="required">Username</label>
	      			<input type="text" id="userName" class="black-text" name="txtuname" required />
	      		</span>

	      		<span style="display: block;">
	      			<label for="txtfname" required class="required">First name</label>
	      			<input type="text" id="txtfname" class="black-text" name="txtfname" required />
	      		</span>	     

	      		<span style="display: block;">
	      			<label for="txtlname" required class="required">Last name</label>
	      			<input type="text" id="txtlname" class="black-text" name="txtlname" required />
	      		</span>	 	      		 		

	      		<span style="display: block;">
	      			<label for="userEmail" required class="required">Email address</label>
	      			<input type="email" id="userEmail" class="black-text" name="txtemail" required />
	      		</span>

	      		<span style="display: block;">
	      			<label for="password" required class="required">Password</label>
	      			<input type="password" class="black-text" id="password" name="txtpass" required />
	      		</span>
	      		<span style="display: block;">
	      			<label for="re_enter_pass" required class="required">Re-enter password</label>
	      			<input type="password" class="black-text" id="re_enter_pass" required />
	      		</span>	      		

	      		<button class="btn waves-effect waves-light grey darken-3" type="submit" name="btn-signup">Sign Up</button>
	      		<a class="black-text" href="login.php">Login</a>
      		</form>
	    </div>
</div>
      </div>
    </div>

    <div class="parallax"></div>
  </div>

  <div class="section">
  	<div class="container">

  	</div>
  </div>


    <footer class="page-footer grey darken-4 white-text lighter">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="annotate">About svA11y</h5>
          <p class="text-lighten-4">Annotate! was created and is maintained by Shea VanLaningham.  svA11y.com is a website dedicated to providing quality Web Accessibility and Section 508 consultation and remediation.  Annotate! was created to assist users in making Accessibility notations, but quickly grew into something much bigger and better!</p>


        </div>
        <div class="col l3 s12">
          <h5 class="annotate">Connect</h5>
          <ul>
            <li><a href="http://annotate.tech">Annotate Tech</a></li>
            <li><a href="http://sva11y.com">svA11y.com</a></li>
            <li><a href="#!">Get Annotate! for Firefox</a></li>
            <li><a href="https://chrome.google.com/webstore/detail/annotate/hmapkigpghjemmoodagegimpoimooamc">Get Annotate! for Google Chrome</a></li>
            <li><a href="http://www.sheavanlaningham.com">sheavanlaningham.com</a></li>
            <li><a href="https://www.linkedin.com/in/shea-vanlaningham-b284782b">LinkedIn</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      <a href="http://www.sva11y.com" target="_blank">svA11y.com <span class="screen-reader-only"> opens in a new window</span></a> 2016
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/annotate.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81728929-1', 'auto');
  ga('send', 'pageview');

</script>

  </body>
</html>
