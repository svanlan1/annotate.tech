<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
mysql_select_db("annotate_main");
$query = sprintf("SELECT * FROM news");

  $result = mysql_query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate - Documentation</title>

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
  <div class="navbar-fixed an_focus">
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
            <li><a href="logout.php" class="black-text">Logout</a></li>
          </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons grey-text darken-3">menu</i></a>
      </div>
    </nav>
  </div>

  <div class="container an_focus">
    <div class="section">
      <div class="row">
        <div class="col s12">
          <h1 class="annotate left-align" style="font-size: 2rem;">Documentation</h1>
            <ul class="collapsible popout" data-collapsible="accordion">
                <li>
                  <div class="collapsible-header"><i class="material-icons" aria-hidden="true" >web</i><h2 class="docs annotate-h2">Getting Started</h2></div>
                  <div class="collapsible-body">
                    <h3 class="annotate annotate-h3">What is Annotate?</h3>
                    <p>
                      Annotate began as a small Google Chrome extension to draw boxes around sections and place pins on the page to share with others.
                      <br />
                      Now, Annotate is a full system of notation tools.  With a free account, users annotate any web page and save it to their account.  Future releases include the ability to share annotations with other users and printing a PDF of all annotations and recommendations.
                    </p>
                    <h3 class="annotate annotate-h3">What does being in Beta mean?</h3>
                    <p>
                      Annotate is a work in progress.  If you are reading this, you are one of the early adopters.  Reference the timeline below for an incremental look of functionality that Annotate will soon have.<br />
                      <table style="margin-left:25px; width: 60%">
                        <thead></thead>
                        <tbody>
                          <tr>
                            <th scope="row">Add/edit custom recommendations</th><td>August 15th, 2016</td>
                          </tr>                         
                          <tr>
                            <th scope="row">Firefox Extension completion date</th><td>September 1st, 2016</td>
                          </tr>
                          <tr>
                            <th scope="row">Share annotations with other users</th><td>October 1st, 2016</td>
                          </tr> 
                          <tr>
                            <th scope="row">Microsoft Edge extension completion date</th><td>October 1st, 2016</td>
                          </tr> 
                          <tr>
                            <th scope="row">Share annotations with other users</th><td>October 1st, 2016</td>
                          </tr> 
                        </tbody>
                      </table>                         
                    </p>
                    <h3 class="annotate annotate-h3">Sign up for an account</h3>
                    <p>
                      Signing up for an Annotate! account is easy and free.  To sign up, go to 
                      <a class="black-text" href="signup.php">http://annotate.tech/signup.php</a>.  
                      You only need an email address and password to sign up.
                    </p>
                    <h3 class="annotate annotate-h3">Will I receive spam?</h3>
                    <p>
                      Never.  Honestly, we'll probably never even email you unless you want us to.  All news and updates can be found on the homepage after login.
                    </p> 
                    <h3 class="annotate annotate-h3">Where do I get the Chrome extension?</h3>
                    <p>
                      Getting Annotate is easy.  Simply click the button below to install the extension to Chrome.<br />
                      <buton class="blue white-text">COMING SOON</buton>
                    </p>
                    <h3 class="annotate annotate-h3">What if I hate Chrome and want to use Firefox or Edge?</h3>
                    <p>
                      If Chrome isn't your cup of tea, we'll soon have you covered.  We're working on porting over the same extension to Mozilla Firefox and Microsoft Edge.  The estimated release date for the Firefox extension is September 1st, 2016 with an Edge extension following shortly thereafter.
                    </p>
                    <h3 class="annotate annotate-h3">Where do I leave feedback?</h3>
                    <p>
                      Love it or hate it, we want to know.  Annotate is a tool for <strong>you</strong>.  If it's not doing what you want, tell us and we'll do our best to make it happen.<br />
                      <a class="black-text" href="feedback.php">Send feedback to Annotate!</a>
                    </p>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header active"><i class="material-icons" aria-hidden="true" >extension</i><h2 class="docs annotate-h2">Extension</h2></div>
                  <div class="collapsible-body">
                    <h3 class="annotate annotate-h3">Installing the extension</h3>
                    <p style="display:block;">
                      <img src="images/an_ext_s1.jpg" alt="" style="width: 300px;" align="right" />
                      Annotate can be installed either from the Chrome Web Store, or by clicking the 'INSTALL' button on the homepage.<br />
                      Once the extension has been installed, you should immediately visit the 'Options' page of the extension and login at the top of the screen.

                    </p>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons" aria-hidden="true" >exit_to_app</i>Annotate.tech</div>
                  <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
                </li>
              </ul>
          </div>          
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="section">

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
