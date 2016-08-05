<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['userEmail']);
	$upass = trim($_POST['userPass']);

	if($user_login->login($email,$upass))
	{
		$user_login->redirect('home.php');
	}
}

if(isset($_POST['btn-login-mobile']))
{
  $email = trim($_POST['muserEmail']);
  $upass = trim($_POST['muserPass']);

  if($user_login->login($email,$upass))
  {
    $user_login->redirect('home.php');
  }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate! - Success!</title>

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
<body onload="a.run();">
  <div class="navbar-fixed">
    <nav class="white" role="navigation">
      <div class="nav-wrapper container">
        <a id="logo-container" href="http://annotate.tech" class="brand-logo annotate">annotate<span class="small">.tech</span></a>
        <form class="form-signin" method="post">
          <ul id="nav-mobile" class="side-nav">
            <li>
              <h5 style="margin:0; padding: 5px;" class="grey darken-4 white-text lighter annotate">Login</h5>
            </li>       
            <li>
              <label class="screen-reader-only" for="login">Email address</label>
              <input style="padding-left:1rem;" type="email" id="login" class="white black-text" placeholder="Login/Email address" name="muserEmail" />
            </li>
            <li>
              <label class="screen-reader-only" for="password">Password</label>
              <input style="padding-left:1rem;"  type="password" id="password" class="white black-text" placeholder="Password" name="muserPass" />
            </li>
            <li style="margin-left: 1rem;">
              <button class="btn-large waves-effect waves-light blue darken-3 white-text" name="btn-login-mobile" style="height: 47px; line-height: 27px;">Login</button>
            </li>
          </ul>
          <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons grey-text darken-3">menu</i></a>           
          <ul class="right hide-on-med-and-down annotate">
            <li>
              <label class="screen-reader-only" for="userEmail">Email address</label>
              <?php
                if(isset($_GET['error']))
                {
              ?>
              <input type="text" id="userEmail" class="white black-text annotate-error tooltipped" style="padding-left: 5px;" data-position="bottom" data-delay="50" data-tooltip="Incorrect email/password" placeholder="Login/Email address" name="userEmail" aria-describedby="login_error" />
              <span class="screen-reader-only" id="login_error"> Incorrect Email/Password.  Please try again</span>
              <?php
                } else {
              ?>
              <input type="text" id="userEmail" class="white black-text"  style="padding-left: 5px;" placeholder="Login/Email address" name="userEmail" />
              <?php
                }
              ?>           
            </li>
            <li>
              <label class="screen-reader-only" for="userPass">Password</label>
              <?php
                if(isset($_GET['error']))
                {
              ?>
              <input style="margin-left: 1rem; padding-left: 5px;" type="password" id="userPass" class="white black-text annotate-error" placeholder="Password" name="userPass" aria-describedby="password_error" />
              <?php
                } else {
              ?>
              <input style="margin-left: 1rem; padding-left: 5px;" type="password" id="userPass" class="white black-text" placeholder="Password" name="userPass" />
              <?php
                }
              ?>  
            </li>
            <li style="margin-left: 1rem;">
              <button class="btn-large waves-effect waves-light blue darken-3 white-text" name="btn-login" style="margin-left: 1rem; height: 47px; line-height: 27px;">Login</button>
            </li>   
            <li>
              <a href="signup.php">Sign up</a>
            </li> 
          </ul>
        </form>
      </div>
    </nav>
  </div>


  <?php
    if(isset($_GET['error-already-exists']))
    {
  ?>
      <div class='container'>
        <div class='section'>
          <div class='row'>
            <div class='m12 s12 col'>
              <div class='card-panel red accent-4' style='padding: 10px;'>
                <div class='row'>
                  <div class='col l8 white-text'>
                    <h5><i class='material-icons' style='margin-right: 1rem; vertical-align: bottom;'>error_outline</i>Ruh roh!</h5>
                    <h6 style='margin-left: 3rem;'>An account with this Email address has already activated.</h6>
                  </div>
                  <div class='col l4 right-align'>
                    <br>
                    <a href='index.php' class='waves-effect waves-light modal-trigger btn btn-large white black-text darken-4 btn-flat'>Login</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>";
  <?php
    } else if (isset($_GET['could-not-execute'])) {
  ?>    
    <div class='container'>
      <div class='section'>
        <div class='row'>
          <div class='m12 s12 col'>
            <div class='card-panel red accent-4' style='padding: 10px;'>
              <div class='row'>
                <div class='col l8 white-text'>
                  <h5><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>error_outline</i>Ruh roh!</h5>
                  <h6 style="margin-left: 3rem;">Something went wrong.  Please try signing up again.</h6>
                </div>
                <div class='col l4 right-align'>
                  <br>
                  <a href='signup.php' class='waves-effect waves-light modal-trigger btn btn-large white blue-text darken-4 btn-flat'>Sign up</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php     
    }
  ?>
    
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
