<?php
  session_start();
  require_once 'class.user.php';
  $user_login = new USER();
  $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $userID = $user['userID'];

  mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
  mysql_select_db("annotate_main");
  $query = sprintf("SELECT url, obj FROM store 
    WHERE userID='%s'",
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
  <link href="ext/css/annotate.css" type="text/css" rel="stylesheet" media="screen, projection" />  
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
  }
  </style>
</head>
<body>
  <div class="navbar-fixed">
    <nav class="white" role="navigation">
      <div class="nav-wrapper container">
        <a id="logo-container" href="http://annotate.tech" class="brand-logo annotate">annotate<span class="small">.tech</span></a>             
        <ul class="right hide-on-med-and-down annotate">
          <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><?php echo $user['userEmail']; ?><i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>      
         <ul id="dropdown1" class="dropdown-content">
          <li>
            <span class="small black-text" style="font-size: .9rem;">
              <div class="chip" style="display: inline; background: none; padding: 0;">
                <img src="images/user.png" alt=<?php echo $user['first_name'].' '.$user['last_name']; ?> />
              </div>
              <?php echo $user['userEmail']; ?>
            </span>
          </li> 
          <li class="divider"></li>
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
            <li><a href="change_default.php">Recommendations</a></li>
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
          <h4 class="annotate left-align">Saved annotations</h4>
          <h6 class="annotate left-align">Edit functionality coming shortly</h6>
          <div class="col l12 s16 left-align">         

          </div>         
        </div>
      </div>

      <?php
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            echo $message;
            die($message);
        }    

        while ($row = mysql_fetch_assoc($result)) {
            $tr = '<div id="ann-object">'.$row['obj'].'</div>';
            echo $tr;
        }

        mysql_free_result($result);

      ?> 
  

    </div>
    <div class="row" id="results_area"></div>    
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
      <script>
        function convert_obj() {
          //var tbody = $('#results_table tbody');
          var item = JSON.parse($('#ann-object').text());
          $('#ann-object').remove();
          //console.log(item);
          /*$(item).each(function(i,v) {
            var val = v.val
            if(v[val].length > 0) {
            var tr = $('<tr />').appendTo(tbody);
            var urltd = $('<td class="table-url" />').html('<a class="black-text" href="' + v.url + '" target="_blank">' + v.url + '</a>').appendTo(tr);
            var td = $('<td class="table-info"/>').appendTo(tr);
            $(v[val]).each(function(l,m) {
              
              var type = $('<div />').text(m.type).appendTo(td);
              var wid = $('<div />').text(m.win_w).appendTo(td);
              var hei = $('<div />').text(m.win_h).appendTo(td);
            });
            }
          });
          $('#ann-object').remove();*/
          var area = $('#results_area');
          var bgcolors = ['light-blue accent-1', 'indigo lighten-5', 'teal lighten-3', 'cyan accent-4', 'green accent-3', 'yellow lighten-2', 'grey lighten-1', 'grey lighten-4', 'deep-orange accent-2'];
          $(item).each(function(i,v) {
            var val = v.val;
            if(v[val].length > 0) {
              var cont = $('<div />').addClass('col s12 m6').appendTo(area);
              var div_card_sticky = $('<div />').addClass('card small sticky-action').appendTo(cont);

              var color = bgcolors[Math.floor(Math.random() * bgcolors.length)];
              $(div_card_sticky).addClass(color);

              var div_card_content = $('<div />').addClass('card-content').appendTo(div_card_sticky);
              var div_card_action = $('<div />').addClass('card-action').appendTo(div_card_sticky);
              var div_card_reveal = $('<div />').addClass('card-reveal').appendTo(div_card_sticky);
              var type = $('<span />').addClass('card-title activator black-text annotate-card-head').html('<span class="annotate-card-head-text">' + v.url + '</span><i class="material-icons right">more_vert</i>').appendTo(div_card_content);
              var moreInfo = $('<p />').appendTo(div_card_content);
              $('<span class="moreInfo black-text" />').text(v[val].length + ' Annotations').appendTo(moreInfo);
              $('<span class="moreInfo black-text" />').html('<p><strong>Last updated:</strong>' + v['date_time'] + '<br /> by ' + v['user'] + '</p>').appendTo(moreInfo);
              $('<div />').addClass('annotate-res-width black-text').html('<strong>Original window size</strong><br />' + v[val][0].win_w + ' x ' + v[val][0].win_h).appendTo(moreInfo);          


              var onclick="window.open('"+v.url+"?annotate=true&an_tech_sess_id="+val+"','_new', 'toolbar=yes, location=yes, status=no,menubar=yes,scrollbars=yes,resizable=no,width=" + v[val][0].win_w +",height=" + v[val][0].win_h +"')";
              var ac1 = $('<a />').addClass('black-text').attr('href', 'javascript:void(0);').attr('onclick', onclick).text('Visit Site').appendTo(div_card_action);
              var ac2 = $('<a />').addClass('black-text annotate_delete').attr('href', 'javascript:void(0);').text('Delete').appendTo(div_card_action);
              var aType = $('<span />').addClass('card-title activator').html(v.url + '<a href="javascript:void(0);"><i class="material-icons right">close</i></a>').appendTo(div_card_reveal);
              
              


              $(v[val]).each(function(l,m) {
                var thing = $('<div />').addClass('annotate-res-width').appendTo(div_card_reveal);
                //var lab = $('<h4 />').css('font-size: 1rem;').text('Type').appendTo(thing);
                if(m.type === 'pin') {
                  $(thing).css('display', 'inline');
                  var p_type = v[val][l]['flag-color'];
                  var img = $('<img />').attr('src', 'ext/images/pins/pin_24_' + p_type + '.png').css({
                    'width': v[val][l]['pin_size'],
                    'display': 'inline-block',
                    'margin': '5px'
                  }).appendTo(thing);
                } else if (m.type === 'box') {
                  var box = $('<div />').css({
                    'width': '100%',
                    'height': '50px',
                    'border-width': v[val][l]['box-width'],
                    'border-style': 'solid',
                    'border-color': v[val][l]['box_color'],
                    'background-color': v[val][l]['box_bg_color'],
                    'margin': '5px'
                  }).appendTo(thing);
                }
              });
            }
          });
        }      

        convert_obj();
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
