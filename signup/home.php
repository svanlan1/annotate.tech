<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate - <?php echo $row['userEmail']; ?> control panel</title>

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
      <ul class="right hide-on-med-and-down annotate">
        <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><?php echo $row['userEmail']; ?><i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>      
 <ul id="dropdown1" class="dropdown-content">
  <li><a href="settings.php">Settings</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul> 
      <ul id="nav-mobile" class="side-nav">
        <li>
          <span class="small"><?php echo $row['userEmail']; ?></span>
        </li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  </div>

  <!--div id="index-banner" class="parallax-container" style="height: 48rem;">
    <div class="section no-pad-bot">
      <div class="container">

        <br><br>
        
        
        <div style="width: 303px; height: 178px; border-radius: 5px; border: solid 2px #fff;">          
          <h1 class="annotate white-text light" id="banner-h1" style="text-shadow: #999 1px 1px 1px; font-size: 3rem;">Thanks for using Annotate</h1>
          <h5 class="annotate darker" id="banner-h5" style="margin-left: 15px;"><img src="images/marker_128.png" alt="" style="width: 22px;" /><span class="small"><?php echo $row['userEmail']; ?></span></h5>  
          <div style="width: 297px; height: 173px; opacity: .6; border-radius: 5px; background: #000; position: absolute; display: block;"></div>       
        </div>


        <br><br>

      </div>
    </div>
    <div class="center">
      
    </div>
    <div class="parallax"><img src="images/annotate_home_banner.jpg" id="main_banner" style="width: 1000px" alt="Annotate!" /></div>
  </div-->


  <div class="container">
    <div class="section">
      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-grey-text"><i class="material-icons" aria-hidden="true">screen_share</i><span class="screen-reader-only">What is Annotate!</span></h2>
            

            <p class="light">Annotate is a full suite of end-to-end tools for any role to use in any stage of your timeline.  Make notes, place emoji pins, highlight text, and highlight elements on the screen to share with other users on your team using <a href="http://annotate.tech">annotate.tech</a></p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center green-text"><i aria-hidden="true" class="material-icons">done</i><span class="screen-reader-only">Who should use Annotate!</span></h2>

            <p class="light">Developers?  Check.<br />
              Designers?  Check.<br />
              Testers?  Check.<br />
              Everyone can use annotate! You don't need to be a developer or designer to use it. Want to make notes on a page and share it with your friends? Here ya go!</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">settings</i></h2>

            <p class="light">Collaborate with other users on your team to expedite the design and development phase.  Simply share your notations with other members of your group and you're off to the races.</p>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div id="what" class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h2 class="header col s12 light-blue-text text-darken-3 annotate" style="font-size: 2.92rem; color: #fff !important">What is Annotate!</h2>

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
  <footer class="page-footer grey darken-4 white-text light">
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
