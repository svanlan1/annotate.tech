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

if(isset($_POST['btn-update']))
{
  $email = trim($_POST['userEmail']);
  $upass = trim($_POST['userPass']);
  $fName = trim($_POST['firstName']);
  $lName = trim($_POST['lastName']);
  $userID = $row['userID'];

  if($user_home->update($email,$upass,$fName,$lName,$userID))
  {
    $user_home->redirect('settings.php?success');
    echo $fName;
  } else {
    $user_home->redirect('settings.php?error');
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate - <?php echo $row['userEmail']; ?> - Settings</title>

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
          <li><a class="dropdown-button" href="#!" data-activates="dropdown1" style="min-width: 14rem;"><?php 
            if($row['userEmail']) {
              echo $row['userEmail']; 
            } else {
              echo 'Guest';
            }
            
          ?><i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>      
         <ul id="dropdown1" class="dropdown-content">
          <li>
            <span class="small black-text" style="font-size: .9rem;">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/user.png" alt=<?php 
                  if($row['first_name']) {
                    echo $row['first_name'].' '.$row['last_name'];
                  } else {
                    echo 'Guest';
                  }
                  
                 ?> />
              </div>
              <?php 
                if($row['userEmail']) {
                  echo $row['userEmail']; 
                } else {
                  echo 'Guest';
                }
                
              ?>
            </span>
          </li> 
          <li class="divider"></li>
          <?php

          if($row['admin'] === 'Y')
          {
            ?>

                    <li>
                      <a href="add_news.php" class="black-text">
                        <div class="chip" style="display: inline; background: none; padding: 0;">
                          <img src="images/newspaper.png" alt="" style="border-radius: 0;" />
                        </div>
                        Add News
                      </a>
                    </li>
            <?php
          } 

          ?>         
          <li>
            <a href="results.php" class="black-text">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/marker_128.png" alt="" />
              </div>
              Annotations
              </a>
            </li>
          <li>
            <a class="black-text" href="recs.php">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/pin.png" alt="" style="border-radius: 0;" />
              </div>
              Recommendations
            </a>
          </li>
          <li>
            <a href="docs.php" class="black-text">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/folder.png" alt="" style="border-radius: 0;" />
              </div>              
              Documentation
            </a>
          </li>          
          <li>
            <a href="settings.php" class="black-text">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/settings.png" alt="" style="border-radius: 0;" />
              </div>              
              Settings
            </a>
          </li>
          <li>
            <a href="feedback.php" class="black-text">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/chat.png" alt="" style="border-radius: 0;" />
              </div>              
              Leave feedback
            </a>
          </li>           
          <li>
            <a href="logout.php" class="black-text">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/logout.png" alt="" style="border-radius: 0;" />
              </div>              
              Logout
            </a>
          </li>
        </ul> 
          <ul id="nav-mobile" class="side-nav">
            <li>
              <a href="home.php" style="padding-left: 10px;"><span class="small black-text"><?php echo $row['userEmail']; ?></span></a>
            </li> 
            <li class="divider"></li>
            <li><a href="results.php" class="black-text">Annotations</a>
            <li><a href="recs.php">Recommendations</a></li>
            <li><a href="docs.php">Documentation</a></li>
            <li><a href="settings.php" class="black-text">Settings</a></li>
            <li><a href="feedback.php" class="black-text">Leave feedback</a></li>
            <li><a href="logout.php" class="black-text">Logout</a></li>
          </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons grey-text darken-3">menu</i></a>
      </div>
    </nav>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h4 class="annotate">Account information</h4>
          <div class="col l12 s16 left-align">         

          </div>         
        </div>
      </div>
      <form class="form-signin" method="post">
        <div class="row">
          <div class="col s12 left-align">
           <label for="userEmail" class="required">Email address</label>
           <input type="email" id="userEmail" name="userEmail" value=<?php echo $row['userEmail']; ?> />
          </div>
        </div>
        <div class="row">
          <div class="col s12 left-align">
           <label for="userName" class="required">Username</label>
           <input type="text" id="userName" name="userName" value=<?php echo $row['userName']; ?> />
          </div>
        </div>
        <div class="row">
          <div class="col s12 left-align">
           <label for="firstName" class="required">First Name</label>
           <input type="text" id="firstName" name="firstName" value=<?php echo $row['first_name']; ?> />
          </div>
        </div>   
        <div class="row">
          <div class="col s12 left-align">
           <label for="lastName" class="required">Last Name</label>
           <input type="text" id="lastName" name="lastName" value=<?php echo $row['last_name']; ?> />
          </div>
        </div>
        <div class="row">
          <div class="col s12 left-align">
            <button class="btn waves-effect waves-light grey darken-3" name="btn-update" style="height: 47px; line-height: 27px;">Update</button>
          </div>
        </div> 
      </form>     


    </div>
  </div>
  <footer class="page-footer grey darken-4 white-text lighter">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="annotate-h5">About svA11y</h5>
          <p class="text-lighten-4 light" style="font-size: 13px;">Annotate! was created and is maintained by Shea VanLaningham.  svA11y.com is a website dedicated to providing quality Web Accessibility and Section 508 consultation and remediation.  Annotate! was created to assist users in making Accessibility notations, but quickly grew into something much bigger and better!</p>


        </div>
        <div class="col l3 s12">
          <h5 class="annotate-h5">Connect</h5>
          <ul style="font-size: 13px;">
            <li><a href="http://annotate.tech">Annotate Tech</a></li>
            <li><a href="http://sva11y.com">svA11y.com</a></li>
            <li><a href="javascript:void(0);" id="install-button">Get Annotate! for Google Chrome</a></li>
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
