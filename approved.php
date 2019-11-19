<?php
    include "Temp/connectdb.php";
    $id ='';
    $name = '';
    $rd = '';
    session_start();
    if($_SESSION['username'] == '' && $_SESSION['userid']!=2){
      header('Location: login.php');
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

    $crntAdmin = 0;
    $prb = false;
    $names = array();
    $times = array();
    $id = array();
    $sql = "SELECT * FROM admins";
    $hold = mysqli_query($link, $sql);
    if($hold){
      $res = mysqli_fetch_all($hold, MYSQLI_ASSOC);
      $crntAdmin = count($res);
      for ($i = 0; $i < $crntAdmin; $i++) {
             $names[$i] = $res[$i]['name'];
             $id[$i] = $res[$i]['id'];
             $times[$i] = $res[$i]['startdate'];
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
                       <h3 > <b>They are current admins. </b></h3>
                   </ul>
                   <span class="navbar-text actions">
                     <a class="btn btn-light action-button" role="button" href='profile.php?out=true'>Log out</a>
                   </span>
                 </div>
           </div>
       </nav>
   </div>

 <div class ="feedContents" >
   <div class="leftallignedcontents" id="posts">
     <div class="stayontop">
     <div style="font-style: italic; font-size:20px; color:green;" class="h4  "> Current_Admins:<?php echo "$crntAdmin"; ?> </div>
     </div>
     <?php if(!$prb) {
       for ($i=0; $i <$crntAdmin ; $i++) {?>
     <div class="Adminrequests">
       <div id="REQ1">
         <?php echo '<a target="_blank" href="visitor.php?dit='.$id[$i].'"> <h2>'.$names[$i].'</h2></a>'; //&docu='.$id[$i].' & st=454?>
         <h3>Admin from <?php echo $times[$i]; ?></h3>
         ____________________________________________________<br><br>
       </div>
     <?php }
        }else{
           echo "Opps, server down.";
         } ?>




     </div>
   </div>
 </div>
 </body>
 </html>
