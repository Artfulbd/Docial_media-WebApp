<?php
    include "Temp/connectdb.php";
    $id ='';
    $name = '';
    $rd = '';
    session_start();
    if($_SESSION['username'] == '' || $_SESSION['rnd'] == ''){
      header('Location: login.php');
    }else {
      if(isset($_GET['rd'])){
        $name = $_GET['rd'];
        $id =  $_SESSION['rnd'];
        $rd = $_GET['rd'];
        if($name != $id)  {
          header('Location: login.php');
        }
      }else {
        header('Location: login.php');
      }
    }
    $id = $_SESSION['userid'];
    $name = $_SESSION['username'];

    if (isset($_GET['out'])) {                                  /// log out
       $_SESSION['username'] = '';
       $_SESSION['userid'] = '';
       session_destroy();
        header('Location: login.php');
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $st = '';
    $docu = '';
    if(isset($_GET['st']) && isset($_GET['docu'])){
          $st = test_input($_GET['st']);
          $docu = test_input($_GET['docu']);
          if($st == 609){
            $sql = "INSERT INTO admins(id, name, startdate) SELECT id,name,reqTime FROM alluser where id = '$docu'";
            $hold = mysqli_query($link,$sql);
            $sql = "UPDATE `alluser` SET `is_admin`=1,`admin_req`= 0,`reqTime`= NULL WHERE id = '$docu' ";
            $hold = mysqli_query($link,$sql);
          }
          else if($st == 456){
            $sql = "UPDATE `alluser` SET `is_admin`=0, `admin_req`= 0,`reqTime`= NULL WHERE id = '$docu' ";
            $hold = mysqli_query($link,$sql);
          }
          $_GET['st'] = '';
          $_GET['docu'] = '';

    }


    $crntAdmin = 0;
    $sql = "SELECT count(*) crnt FROM admins";
    $req = mysqli_fetch_all(mysqli_query($link, $sql), MYSQLI_ASSOC);
    $crntAdmin = $req[0]['crnt'];
    $prb = false;
    $names = array();
    $times = array();
    $id = array();
    $sz = 0;
    $sql = "SELECT name, id, reqTime FROM alluser WHERE admin_req = 1";
    $hold = mysqli_query($link, $sql);
    if($hold){
      $res = mysqli_fetch_all($hold, MYSQLI_ASSOC);
      $sz = count($res);
      for ($i = 0; $i < $sz; $i++) {
             $names[$i] = $res[$i]['name'];
             $id[$i] = $res[$i]['id'];
             $times[$i] = $res[$i]['reqTime'];
      }
    }else{
      $prb = true;
    }

 ?><!DOCTYPE html>
 <html lang="en">
 <head>
   <title>Approve admin</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
   <link rel="stylesheet" href="assets/css/Profile-Card-1.css">
   <link rel="stylesheet" href="assets/css/styles.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <style>
   .navbar{
     margin-bottom: 0;
     border-radius: 0;
     padding: 0.5% 0;
     font-size: 1.2em;
     border:0;
   }
   .navbar-brand{
     /* this is for the logo */
     float:left;
     padding: 7px 10px 0px;
   }
   .navbar-inverse .navbar-nav li a{
     /*color of hovering over button in nav bar*/

   }
   .profileContents{
     padding: 50px 0px 0 0px; /* Dont touch this*/
     text-align: center;
     /**/
   }
   .leftallignedcontents{
     text-align: left;
   }
   .feedContents{
     margin: 25px 450px 75px; /*top - lr - bottom*/
     text-align: left;
   }
   .Comments{
     font-size: 12px;
     font-family:cursive;
   }
   .LikesDislikes{
     font-size: 16px;
     font-family: serif;
   }
   .stayontop{
     padding: 1px 0px 0px 600px; /* Dont touch this*/
     position: -webkit-sticky; /* Safari */
     position: sticky;
     top: 0;
   }
   body{
     background-color: #D8D8D8;
     background-image: url("img/bg.png");
     background-position: center;
     background-repeat: repeat-y;
     margin:auto;
   }
   </style>
 </head>
 <body>
   <div>
       <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
           <div class="container"><a class="navbar-brand" href="#">Artful <?php echo '  --('.$name.')--' ?></a>
             <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="navbar-toggler-icon"></span>
             </button>
               <div class="collapse navbar-collapse"
                   id="navcol-1">
                   <ul class="nav navbar-nav mr-auto">
                       <li class="nav-item" role="presentation">
                         <?php echo '<a class="nav-link"  target = "_blank" href="approved.php?"> Current admins </a>' ?>
                       </li>
                       <li class="nav-item" role="presentation">
                         <a class="nav-link" href="#">Voteing info</a></li>
                   </ul>
                   <span class="navbar-text actions">
                     <a class="btn btn-light action-button" role="button" href='profile.php?out=true'>Log out</a>
                   </span>
                 </div>
           </div>
       </nav>
   </div>
      <h3 > <b>Be careful while choosing admin.</b></h3>
 <div class ="feedContents" >
   <div class="leftallignedcontents" id="posts">
     <div class="stayontop">
     <div style="font-style: italic; font-size:20px; color:green;" class="h4  "> Current_Admins:<?php echo "$crntAdmin"; ?> </div>
     <div style="font-style: italic; font-size:20px; color:red;" class="h4 ">  Pending_Admins:<?php echo "$sz" ?> </div>
     </div>
     <?php if(!$prb) {
       for ($i=0; $i <$sz ; $i++) {?>
     <div class="Adminrequests">
       <div id="REQ1">
         <?php echo '<a target="_blank" href="visitor.php?dit='.$id[$i].'"> <h1>'.$names[$i].'</h1></a>'; ?>
         <h3>Request Sent on <?php echo $times[$i]; ?></h3>
         <?php echo '<a class="btn btn-success action-button" role="button" href="admin.php?rd='.$rd.' & docu='.$id[$i].' & st=609">Confirm</a>';?>
         <?php echo '<a class="btn btn-danger action-button" role="button" href="admin.php?rd='.$rd.' & st=456 & docu='.$id[$i].'">Reject</a>'; ?>
        <br>____________________________________________________<br><br>
       </div>
     <?php }
      if($sz == 0){
        echo '<h3><pre style="font-style: italic; font-size:20px; color:red;">         NO request to show<b></b></pre><h3>';
      }

    }else{
       echo "Opps, server down.";
     } ?>




     </div>
   </div>
 </div>
 </body>
 </html>
