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

  <div id="index-banner" class="parallax-container" style="height: 48rem;">
    <div class="section no-pad-bot">
      <div class="container">

        <br><br>
        <h1 class="annotate-h1 lighter" id="banner-h1" style="text-shadow: #999 1px 1px 1px; font-size: 3rem;">Pin. Draw. Write. Save.</h1>
        <h5 class="annotate-h5 lighter" id="banner-h5" style="margin-left: 15px;"><img src="images/marker_128.png" alt="" style="width: 22px;" />Annotate</h5>
        <!--div style="width: 303px; height: 178px; border-radius: 5px; border: solid 2px #fff;">
          <div style="width: 297px; height: 173px; opacity: .6; border-radius: 5px; background: #000; position: absolute; display: block;"></div>
          
          <h5 class="annotate white-text lighter" style="position: absolute; top: 136px; margin-left: 15px;">Simple.  Quick.  Fun.</h5>          
        </div-->
        <?php 
        if(isset($_GET['inactive']))
        {
          ?>
                <div class='alert alert-error'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
          </div>
                <?php
        }
        ?>
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

        <br><br>

      </div>
    </div>
    <div class="center">
      
    </div>
    <div class="parallax"><img src="" id="main_banner" style="width: 1000px" alt="Annotate!" /></div>
  </div>


  <div class="container">
    <div class="section">
        <div class="row center">
          <a href="#" target="_blank" class="btn-large waves-effect waves-light  blue darken-3"><img style="vertical-align: middle; padding-right: 5px;" src="images/chrome.png" alt="" />
            Get Annotate!
            <span class="screen-reader-only"> extension for Google Chrome! - opens in a new window</span>
            <br />
            <span class="small">for Chrome</span>
          </a>

          <!--a href="https://chrome.google.com/webstore/detail/annotate/hmapkigpghjemmoodagegimpoimooamc" target="_blank" id="download-button" class="btn-large waves-effect waves-light orange darken-3"><img style="vertical-align: middle; padding-right: 5px;"  src="images/ff.png" alt="" />   Get Annotate!
            <span class="screen-reader-only"> extension for Firefox! - opens in a new window</span>
          </a-->

        </div>
      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-grey-text annotate-h2"><i class="material-icons" aria-hidden="true">screen_share</i><span class="screen-reader-only">What is Annotate!</span></h2>
            

            <p class="light">Annotate is a full suite of end-to-end tools for any role to use in any stage of your timeline.  Make notes, place emoji pins, highlight text, and highlight elements on the screen to share with other users on your team using <a href="http://annotate.tech">annotate.tech</a></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center green-text annotate-h2"><i aria-hidden="true" class="material-icons">done</i><span class="screen-reader-only">Who should use Annotate!</span></h2>

            <p class="light">Developers?  Check.<br />
              Designers?  Check.<br />
              Students?  Check.<br />
              Everyone can use annotate! You don't need to be a developer or designer to use it. Annotate is great for students and researchers who want to annotate sections of a page to save for later!</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text annotate-h2"><i class="material-icons">touch_app</i></h2>

            <p class="light">Annotate is touch friendly!  Use on your touchscreen computer without a mouse and keyboard.</p>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div id="what" class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h2 class="header col s12 light-blue-text text-darken-3 annotate-h2" style="font-size: 2.92rem; color: #fff !important">What is Annotate!</h2>

        </div>
        <div class="row">
          <p class="center">
            Annotate! is a set of tools created to provide a streamlined experienced for users to make notes and other annotations, while quickly and easily collaborating and sharing with others!
          </p>         
          <p class="center">
            With Annotate! you are able to draw boxes around elements, place pins anywhere on the page, add a textual note, and make HTML, CSS, or Accessibility recommendations!
          </p>
        </div>
      </div>
    </div>
    <div class="parallax blue darken-1"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h4 class="annotate">Choose from 40 pins to place on the page</h4>
          <div class="col l4 s16 right-align">         
            <p class="right-align">
              Pointing out a specific point on a page can be crucial.  Annotate! gives you 40 pins to choose from to convey exactly what you're thinking.  You can also invert pins and quickly change the size of pins.
            </p>
            <p class="right-align">
              Right clicking on any pin on the page will open the 'Add Notes' dialog.  This gives you the ability to add additional notes and recommendations for a full report that can be generated when you're all finished.
            </p>
          </div>
          <div class="col l8 s12">
            <img class="blue-border" src="images/pins.gif" alt="" style="margin-left: 25px;" />
          </div>           
        </div>
      </div>

    </div>
  </div>  

  <div class="page-footer grey lighten-2 black-text">
    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 center">
            <h4 class="annotate">Draw boxes over any section of the page</h4>
            <div class="col l8 s12">
              <img class="blue-border" src="images/boxes.gif" alt="" style="margin-right: 25px;" />
            </div>        
              <div class="col l4 s16 right-align">
                Does that section right over there need to stand out?  Do you just want to highlight an area to remember for your next visit?  Annotate! has the ability to draw a bordered box around any section of the page.  You can adjust the border width, border color, and background color!  All boxes are both moveable and resizable.
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <div class="container">
    <div class="section">
      <div class="row">
        <div class="col s12 center">
          <h4 class="annotate">Add your own preset recommendations</h4>
          <div class="col l4 s16 right-align">
              Typing the same information over and over and over and over again is tedious.  It can have serious consequences for your mental health.  Quickly add a preset recommendation and example that you can select from to save yourself the monotony of giving the same exact feedback over and over...and yeah.
          </div>
         <div class="col l8 s12">
            <img class="blue-border" src="images/notes.gif" alt="" style="margin-left: 25px;" />
          </div>           
        </div>
      </div>
    </div>
  </div>

  <div class="page-footer grey lighten-2 black-text">
    <div class="container">

        <div class="row">
          <div class="col s12 center">
            <h4 class="annotate">Add notes directly to the page</h4>
            <div class="col l8 s12">
              <img class="blue-border" src="images/text.gif" alt="" style="margin-left: 25px;" />
            </div> 
            <div class="col l4 s16 left-align">
              Writing down exactly what you want to say should be an easy and fast experience.  Annotate! gives you the ability to write what you want to say, in the color that you want to write it, and lets you quickly resize by rolling your mouse wheel over the text!
            </div>            
          </div>
        </div>

    </div>
  </div>

  <div id="where" class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h2 class="annotate-h2 header col s12 light-blue-text text-darken-3" style="font-size: 2.92rem; color: #fff !important">Where can you use Annotate!</h2>

        </div>
        <div class="row">
          <!--p class="center">
            Annotate! is a suite of tools.  On the front end there is a free extension for either Chrome or Firefox.
          </p>         
          <p class="center">
            After you've installed the extension, sign up for a free account at <a class="white-text" href="http://annotate.tech">annotate.tech</a-->
          </p>
        </div>
      </div>
    </div>
    <div class="parallax blue darken-1"></div>
  </div>  
  <div class="container">
    <div class="section">
      <div class="row">
        <div class="col s16 center">
          <h4 class="annotate">Get the extension</h4>
          <div class="col l6 s16 left-align">
              Annotate! is a free extension that for Google Chrome.  Click the button to the left to get the extension in your current browser.
          </div>
          <div class="col l6 s16">
            <a href="https://chrome.google.com/webstore/detail/annotate/hmapkigpghjemmoodagegimpoimooamc" target="_blank" class="btn-large waves-effect waves-light  blue darken-3"><img style="vertical-align: middle; padding-right: 5px;" src="images/chrome.png" alt="" />
              Get Annotate!
              <span class="screen-reader-only"> extension for Google Chrome! - opens in a new window</span>
              <br />
              <span class="small">for Chrome</span>
            </a>

            <!--a href="https://chrome.google.com/webstore/detail/annotate/hmapkigpghjemmoodagegimpoimooamc" target="_blank" id="download-button" class="btn-large waves-effect waves-light orange darken-3"><img style="vertical-align: middle; padding-right: 5px;"  src="images/ff.png" alt="" />   Get Annotate!
              <span class="screen-reader-only"> extension for Firefox! - opens in a new window</span>
            </a-->            
          </div>           
        </div>
      </div>
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
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Product",
  "url": "http://annotate.tech",
  "name": "Annotate"
}
</script>  
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
