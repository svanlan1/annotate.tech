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

mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
mysql_select_db("annotate_main");
$query = sprintf("SELECT * FROM news ORDER BY date_updated desc");

  $result = mysql_query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate - <?php echo $row['userEmail']; ?> - Home</title>

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
          <li><a class="dropdown-button" href="javascript:void(0);" data-activates="dropdown1" style="min-width: 14rem;"><?php 
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
          <h1 class="left-align annotate-h1">Welcome <?php echo $row['first_name'].' '.$row['last_name'] ?></h1>
          <div class="col l12 s16 left-align">         
            Thanks for using Annotate!
            <?php
              if($row['admin'] === 'Y')
              {
            ?>
              <p>
                <a class="btn waves-effect waves-light grey darken-3" href="http://a.annotate.tech/home.php" target="_blank">Admin panel <span class="screen-reader-only">, opens in a new window</span></a>
              </p>
            <?php
              }
            ?>
          </div>          
        </div>
      </div>
    </div>
  </div>

  <div class="container z-depth-2">
    <div class="section" style="padding-left:1rem; padding-right: 1rem;">
      <?php
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            echo $message;
            die($message);
        }    

        while ($row = mysql_fetch_assoc($result)) {
            $msg = "<div class='row'><div class='col s12'><h2 class='annotate-h2' style='padding-left:0;'>".$row['title']."</h2>
                    <span class='article-date'>Date: " . date("Y-m-d",$row['date_updated']) . "</span>
                    <span class='article-by'>by ".$row['created_first_name'] . " " . $row['created_last_name'] . "</span>
                    <p>".$row['story']."</p></div></div>";
            echo $msg;
        }

        mysql_free_result($result);

      ?>

    </div>
  </div>    

  <!--div class='container'>
    <div class='section'>
      <div class='row'>
        <div class='m12 s12 col'>
          <div class='card-panel light-green darken-4' style='padding: 10px;'>
            <div class='row'>
              <div class='col l8 white-text'>
                <h5><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>check_circle</i>Success!</h5>
                <h6 style="margin-left: 3rem;">We've sent you a confirmation email.  Click on the activation link to get started!</h6>
              </div>
              <div class='col l4 right-align'>
                <br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div--> 

  <!--div class='container'>
    <div class='section'>
      <div class='row'>
        <div class='m12 s12 col'>
          <div class='card-panel red accent-4' style='padding: 10px;'>
            <div class='row'>
              <div class='col l8 white-text'>
                <h5><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>error_outline</i>Ruh roh!</h5>
                <h6 style="margin-left: 3rem;">An account with this Email address has already activated.</h6>
              </div>
              <div class='col l4 right-align'>
                <br>
                <a href='index.php' class='waves-effect waves-light modal-trigger btn btn-large white blue-text darken-4 btn-flat'>Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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
  </div-->        

  <!--div class="container">
    <div class="section">
      <div class="row">
        <div class="m12 s12 col">
          <div class="card-panel light-blue darken-4" style='padding: 10px;'>
            <div class="row">
              <div class="col l8 white-text">
                <h5><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>info_outline</i>Don't Miss a Thing</h5>
                <h6 style="margin-left: 3rem;">Read the latest updates on Annotate</h6>
              </div>
              <div class="col l4 right-align">
                <br>
                <a href="latest.php" class="waves-effect waves-light modal-trigger btn btn-large white blue-text darken-4 btn-flat">Let's Go</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div-->

  <div class="container">
    <div class="section">
      <div class="row">
        <div class="m12 s12 col">
          <div class="card-panel orange darken-1" style='padding: 10px;'>
            <div class="row">
              <div class="col l8 white-text">
                <h3 class="annotate-h3"><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>info_outline</i>Find a bug?</h3>
                <span style="margin-left: 3rem; font-size: .85rem;">Annotate should work on all pages you visit.  If you find a bug while you're using it, let us know so we can get it fixed!</span>
              </div>
              <div class="col l4 right-align">
                <br>
                <a href="feedback.php" class="waves-effect waves-light modal-trigger btn btn-large white black-text btn-flat">Leave Feedback</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  

  <div class="container">
    <div class="section">
      <div class="row">
        <div class="m12 s12 col">
          <div class="card-panel light-blue darken-4" style='padding: 10px;'>
            <div class="row">
              <div class="col l8 white-text">
                <h3 class="annotate-h3"><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>info_outline</i>View your latest annotations</h3>
                <span style="margin-left: 3rem; font-size: .85rem;">All of your annotations in one place.  Edit and share functionality coming soon!</span>
              </div>
              <div class="col l4 right-align">
                <br>
                <a href="results.php" class="waves-effect waves-light modal-trigger btn btn-large white black-text btn-flat" style='font-size: .88rem;'>View Annotations</a>
              </div>
            </div>
          </div>
        </div>
      </div>
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

<script>
  function updateDates() {
      $('.article-date').each(function(i,v) {
       // var d = new Date($.parseJSON($(v).text().substring(6, $(v).text().length)));
       //var datestring = (d.getMonth()+1) + "/" + d.getDate()  + "/" + d.getFullYear(); 
       // $(v).text(datestring);       
      });
 
  };

  updateDates();

</script>

  </body>
</html>
