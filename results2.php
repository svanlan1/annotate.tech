<?php
  session_start();
  require_once 'class.user.php';
  $user_login = new USER();

  if(!$user_login->is_logged_in())
  {
    $user_login->redirect('index.php');
  }



  $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $userID = $row['userID'];

  mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
  mysql_select_db("annotate_main");
  $query = sprintf("SELECT url, obj, session_id, username, page_title FROM results 
    WHERE userID='%s' ORDER BY updated desc",
    mysql_real_escape_string($userID));

    $result = mysql_query($query);


  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate - <?php echo $row['userEmail']; ?> - Saved Annotations</title>

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

  <style>
  .annotate-card-head {
    display: block;
    width: 99%;
    overflow: hidden;
    font-size: 1.2rem !important;
    text-overflow: ellipsis;
    /* text-indent: -5px; */
    text-decoration: underline;   
  }

  .annotate-card-head-text {
    width: 95%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;    
  }
  </style>
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
        <div class="col s12 left-align">
          <h1 class="annotate-h1"><?php echo $row['first_name']. " ". $row['last_name'] ?>'s annotations</h1>
          <div class="col l12 s16 left-align">         

          </div>         
        </div>
      </div>
      <div class="col s12">
      <ul class="collapsible" data-collapsible="accordion">
        <?php
          if (!$result) {
              $message  = 'Invalid query: ' . mysql_error() . "\n";
              $message .= 'Whole query: ' . $query;
              echo $message;
              die($message);
          }    

          $results = array();

          while ($row = mysql_fetch_assoc($result)) {
              if($row['obj'] !== "[]")
              {
                $msg = array($row['session_id']=>json_decode($row['obj']), 'url'=>$row['url'], 'username'=>$row['username'], 'page_title'=>$row['page_title']);
                array_push($results, $msg);
          ?>
                  <li>
                    <div class="collapsible-header"><i class="material-icons">filter_drama</i><?php echo $row['page_title'] ?></div>
                    <div class="collapsible-body">
                      <p><a class="black-text" style="font-size: 12px;" target="_blank" href="<?php echo $row['url'].'?annotate=true&an_tech_sess_id='.$row['session_id'] ?>"><?php echo $row['url'] ?><span class="screen-reader-only">, opens in a new window</span></a></p>
                      <p class="annotations"><?php echo $row['obj'] ?></p>
                      <p class="drawn-annotations"></p>
                    </div>
                  </li> 
          <?php             
              }
          }
          mysql_free_result($result);

        ?>
        </ul>
      </div> 
    </div>
    <div class="row" id="results_area"></div>    
  </div>
  <footer class="page-footer grey darken-4 white-text lighter">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="annotate-h5">About svA11y</h5>
          <p class="text-lighten-4">Annotate! was created and is maintained by Shea VanLaningham.  svA11y.com is a website dedicated to providing quality Web Accessibility and Section 508 consultation and remediation.  Annotate! was created to assist users in making Accessibility notations, but quickly grew into something much bigger and better!</p>


        </div>
        <div class="col l3 s12">
          <h5 class="annotate-h5">Connect</h5>
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
  <script>
    function display_annotations() {
      $('.annotations').each(function(i,v) {
        var j = $.parseJSON($(v).text());
        $(v).text('');
        $(j).each(function(l,m) {
          var thing = $('<div />').addClass('annotate-res-with').appendTo(v);
          if(m.type === 'pin') {
            $(thing).css('display', 'inline');
            var p_type = m['flag_color'];
            var img = $('<img />').attr('src', 'ext/images/pins/pin_24_' + p_type + '.png').css({
              'width': m['pin_size'],
              'display': 'inline-block',
              'margin': '5px'
            }).appendTo(thing);
          } else if (m.type === 'box') {
            var box = $('<div />').css({
              'width': '100%',
              'height': '50px',
              'border-width': m['box_width'],
              'border-style': 'solid',
              'border-color': m['box_color'],
              'background-color': m['box_bg_color'],
              'margin': '5px'
            }).appendTo(thing);
          } else if (m.type === 'text') {
              var textbox = $('<div />').css({
                'font-family': m['font_family'],
                'border-width': m['border_w'],
                'border-color': m['border_c'],
                'font-size': m['font'],
                'text-shadow': m['shadow'],
                'padding': '1rem',
                'display': 'block'
              }).text(unescape(m['text'])).appendTo(thing)
          } else if (m.type === 'context') {
            var wrap = $('<div />').css({
              'padding': '10px',
              'border': 'solid 1px #777',
              'margin': '5px',
              'border-radius': '3px'
            }).appendTo(thing);
            var context = $('<div />').appendTo(wrap);
            var noteWrap = $('<div />').appendTo(context);
            var noteHead = $('<strong />').text('Notes ').appendTo(noteWrap);
            var notes = $('<span />').css('display', 'block').text(unescape(m['notes'])).appendTo(noteWrap);
            if(m['qRec'] !== '') { 
              var recHead = $('<strong />').text('Recommendation ').css('margin-top', '5px').appendTo(context);
              var rec = $('<span />').css('display', 'block').appendTo(context).text(unescape(m['qRec']));
            }
          }
        })
      });
    }
    display_annotations();

      </script>  
 
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
