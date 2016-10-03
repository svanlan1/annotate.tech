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


  $userID = $row['userID'];
  $admin = $row['admin'];
  if(isset($_POST['btn-update']))
  {
    
    $quickname = trim($_POST['quickname']);
    $ex = $_POST['example'];
    $description = $_POST['description'];
    $additional = $_POST['additional'];
    $rec_id = trim($_POST['rec_id']);
    $global_rec = $_POST['global_rec'];
    $wcag = $_POST['wcag'];

    if($global_rec === 'on') {
      $global_rec = 'Y';
    } else {
      $global_rec = 'N';
    }

    if($rec_id === "") {
      $rec_id = md5(uniqid(rand()));
    }    
    if($user_home->add_recommendation($userID,$quickname,$ex,$description,$additional,$rec_id,$global_rec,$wcag))
    {
      header('Location:recs.php?success');
    }
  }
  mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
  mysql_select_db("annotate_main");
  $query = sprintf("SELECT * FROM recs 
    WHERE userID='%s' OR global_rec='Y' ORDER BY quickname asc",
    mysql_real_escape_string($userID));

    $result = mysql_query($query);  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Annotate - <?php echo $row['userEmail']; ?> - Recommendations</title>

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

  <div class="container annotate">
    <div class="section">
      <div class="row">
        <div class="col s12">
          <h1 class="annotate-h1">Recommendations</h1>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <?php
              if(isset($_GET['success']))
              {
            ?>
              <div class='row'>
                <div class='col s12'>
                  <div class='card-panel light-green darken-4' style='padding: 10px;'>
                    <div class='row'>
                      <div class='col l12 white-text'>
                        <h5><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>check_circle</i>Success!</h5>
                        <h6 style="margin-left: 3rem;">Your recommendation has been added.  It is now ready for use in the Annotate extension.</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            <?php
              } else if (isset($_GET['error'])) {
            ?>
              <div class='row'>
                <div class='col s12'>
                  <div class='card-panel red accent-4' style='padding: 10px;'>
                    <div class='row'>
                      <div class='col l12 white-text'>
                        <h5><i class="material-icons" style='margin-right: 1rem; vertical-align: bottom;'>error_outline</i>Ruh roh!</h5>
                        <h6 style="margin-left: 3rem;">Hm, something went wrong.  An email has automatically been sent to the dev team.  They're in their basement fixing it now.</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php

              }
            ?>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <ul class="tabs">
            <li class="tab col s3"><a href="#saved_recs" class="active">Saved</a></li>
            <li class="tab col s3"><a href="#add_rec">Add</a></li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <div id="saved_recs" class="col s12">
            <h3 class="screen-reader-only">Stored recommendations</h3>
            <table>
              <thead>
                <tr>
                  <!--th scope="col" class="screen-reader-only">Include</th-->
                  <th scope="col">Name</th>
                  <th scope="col">Description</th>
                  <th scope="col">Example</th>
                  <th scope="col">Additional notes</th>
                  <td></td>
                  <td></td>
                </tr>
                </thead>
                <tbody>
                  <?php
                    if (!$result) {
                        $message  = 'Invalid query: ' . mysql_error() . "\n";
                        $message .= 'Whole query: ' . $query;
                        echo $message;
                        die($message);
                    }
                    while ($res = mysql_fetch_assoc($result)) {
                      echo "<tr><!--td><form><p><label class='screen-reader-only' for='an-check-".trim($res['quickname'])."'>Include ".$res['quickname']." in your recommendations</label><input style='position:relative; left: auto; top: auto; vertical-align: top; opacity: 1; height: 15px; width: 15px;' type='checkbox' class='annotate-checkbox-rec-include' id='an-check-". trim($res['quickname'])."' /></p></form></td--><th scope='row' style='vertical-align:top; font-weight: bold;'>".$res['quickname']."</td>";
                      $desc = stripslashes($res['description']);
                      $ex = $res['example'];
                      $examp = str_replace("<", "&lt;", $ex);
                      $newexamp = str_replace(">", "&gt;", $examp);
                      $final = str_replace('\\', '', $newexamp);
                      echo "<td style='vertical-align:top;'>".$desc."</td>";
                      echo "<td style='vertical-align:top;'>".$final."</td>";
                      echo "<td style='vertical-align:top;'>".stripslashes($res['additional'])."</td>";
                      if($res['global_rec'] === 'N' || $admin === 'Y')
                      {
                        echo "<td style='vertical-align:top;'><a class='blue-text' title='Edit ".$res['quickname']."' href='http://annotate.tech/rec_update.php?rec_id=".$res['rec_id']."' data-ann-val='".$res['rec_id']."' data-ann-action='edit'><i class='material-icons'>mode_edit</i></a></td>";
                        echo "<td style='vertical-align:top;'><a title='Delete ".$res['quickname']."' class='red-text delete-row' href='javascript:void(0);' data-ann-val='".$res['rec_id']."' data-ann-action='delete'><i class='material-icons'>delete_forever</i></a></td></tr>";
                      }
                    }
                  ?>
                </tbody>
              </table>            
          </div>
          <div id="add_rec" class="col s12">
            <p>
              Recommendations are used to note a type of element.  You can enter whatever information you want in here.  All recommendations will be saved to your account and can be accessed in the extension.
            </p>
            <p>
              <form class="form-signin" method="post">        
                <?php
                  if($row['admin'] === 'Y')
                  {
                ?>
                  <div class="row" style="height: 58px;">
                    <div class="input-field col s12 left-align">
                      <div class="switch">
                          <label>
                            Global recommendation<br />
                            <span aria-hidden="true">Off</span>
                            <input type="checkbox" id="global_rec" name="global_rec" <?php echo $checked ?> />
                            <span class="lever"></span>
                            <span aria-hidden="true">On</span>
                        </label>
                      </div>
                    </div>
                  </div>
                <?php
                  } 
                ?>                 
                <div class="row">
                  <div class="input-field col s12 left-align">
                   <label for="quickname">Recommendation name</label>
                   <input type="text" id="quickname" name="quickname" />
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 left-align">
                   <label for="description">Description</label>
                   <textarea id="description" class="materialize-textarea" name="description"></textarea>
                  </div>
                </div> 
                <div class="row">
                  <div class="input-field col s12 left-align">
                   <label for="example">Example</label>
                   <textarea id="example" class="materialize-textarea" name="example"></textarea>
                  </div>
                </div>  
                <div class="row">
                  <div class="input-field col s12 left-align">
                   <label for="example">Guideline</label>
                   <textarea id="wcag" class="materialize-textarea" name="wcag"></textarea>
                  </div>
                </div>                  
                <div class="row">
                  <div class="input-field col s12 left-align">
                   <label for="additional">Additional notes</label>
                   <textarea id="additional" class="materialize-textarea" name="additional"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 left-align">
                    <button class="btn waves-effect waves-light grey darken-3" name="btn-update" style="height: 47px; line-height: 27px;">Update</button>
                    <a href="recs.php" class="btn waves-effect waves-light grey darken-3" style="height: 47px; line-height: 47px;">Cancel</a>
                  </div>
                </div> 
              </form>  
            </p>
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
  function remove() {
    $('.delete-row').click(function() {
      if(confirm('Are you sure want to remove this recommendation?')) {
        var row = $(this).parent().parent();
        $.ajax({
          url: "http://annotate.tech/delete_rec_service.php",
          type: "POST",
          data: {rec_id: $(this).attr('data-ann-val')},
          success: function (response) {
            alert(response);
            $(row).remove();
          },
          error: function (error) {
            alert('Didnt work :( ' + error);
          }
        });         
      }
    });
  }
  remove();
</script>
  <div class
  </body>
</html>
