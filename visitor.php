<?php
    include "Temp/connectdb.php";
    session_start();
    $id = 0;
    if($_SESSION['username'] == ''){
      header('Location: login.php');
    }
    if (isset($_GET['dit'])) {
      $_SESSION['id'] = $_GET["dit"];
    }
    $id = $_SESSION['id'];
    $userName = $_SESSION['username'];
    $_SESSION['cmntID'] = '';
    $ac_post = 0;
    $re_post = 0;
    $allok = false;
    $cmntID = 0;
    $sql = "SELECT * FROM `alluser` WHERE id = '$id'";
    $hold = mysqli_query($link , $sql);
    $noPost = false;
    $gender = '';
     if(!$hold){
       echo "Problem";
     }else{
       $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
       if(!array_filter($res)){
           echo "Problem on database.!!";
       }
       else {
         $name = $res[0]['name'];
         $gender = $res[0]['gender'];
         $allok = true;
       }
     }
     if($name == ''){
       header('Location: login.php');
     }
    $about = "Ohohohoh it's working that's great sounds well..";
    $flag = false;
    $sql = "SELECT * FROM `post` where id = '$id'";
    $hold = mysqli_query($link , $sql);
     if(!$hold){
       echo "Problem";
     }else{
       $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
       if(!array_filter($res)){
           $noPost = true;
       }
       else {
         $flag = true;
       }
     }

     if (isset($_GET['out'])) {                 /// log out
        $_SESSION['username'] = '';
        $_SESSION['userid'] = '';
        session_destroy();
         header('Location: login.php');
     }




 ?>
 <!DOCTYPE html>
 <html>

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $name ?></title>
     <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
     <link rel="stylesheet" href="assets/css/Profile-Card-1.css">
     <link rel="stylesheet" href="assets/css/styles.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

     <style media="screen">
     .container{
       text-align: center;
     }
     .btnn{
       border: 1px solid #3498db;
       background: none;
       padding: 10px 20px;
       font-size: 20px;
       font-family: "montserrat";
       cursor: pointer;
       margin: 10px;
       transition: 0.5s;
       position: relative;
       overflow: hidden;
     }

     .btn1,.btn2{
       color: #3498db;
     }
     .btn3,.btn4{
       color: #4285F4;
     }
     .btn1:hover,.btn2:hover{
       color: #9414222;
     }
     .btn3:hover,.btn4:hover{
       color: #EC030E;
     }
     .btnn::before{
       content: "";
       position: absolute;
       left: 0;
       width: 100%;
       height: 0%;
       background: #3498db;
       z-index: -1;
       transition: 0.8s;
     }
     .btn1::before,.btn3::before{
       top: 0;
       border-radius: 0 0 50% 50%;
     }
     .btn2::before,.btn4::before{
       bottom: 0;
       border-radius: 50% 50% 0 0;
     }
     .btn3::before,.btn4::before{
       height: 180%;
     }
     .btn1:hover::before,.btn2:hover::before{
       height: 180%;
     }
     .btn3:hover::before,.btn4:hover::before{
       height: 0%;
     }
     .LikesDislikes{
       font-size: 16px;
       font-family: serif;
     }
     .wrapper {
          text-align: center;
      }

     </style>

 </head>

 <body>
   <?php if($allok) {?>
     <div>
         <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
             <div class="container"><a class="navbar-brand" href="#">Artful <?php echo '  --('.$userName.')--' ?></a>
               <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="navbar-toggler-icon"></span>
               </button>
                 <div class="collapse navbar-collapse"
                     id="navcol-1">
                     <ul class="nav navbar-nav mr-auto">
                         <li class="nav-item" role="presentation">
                           <a class="nav-link" target="_blank" href="https://yts.am/">Notifications</a></li>
                         <li class="nav-item" role="presentation">
                           <a class="nav-link" href="#">Voteing info</a></li>
                         <li class="dropdown">
                           <a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Dropdown </a>
                             <div class="dropdown-menu" role="menu">
                               <a class="dropdown-item" role="presentation" href="#">First Item</a>
                               <a class="dropdown-item" role="presentation" href="#">Second Item</a>
                               <a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                         </li>
                     </ul>
                     <span class="navbar-text actions">
                       <a class="btn btn-light action-button" role="button" href='profile.php?out=true'>Log out</a>
                     </span>
                   </div>
             </div>
         </nav>
     </div>
     <ul class="nav nav-tabs">
         <li class="nav-item"><a class="nav-link active" href="#"> profile</a></li>
     </ul>
     <div class="text-center profile-card" style="margin:15px;background-color:#ffffff;">
         <div class="profile-card-img" style="background-image:url(&quot;iceland.jpg&quot;);height:150px;background-size:cover;"></div>
         <div>
           <?php
           if($gender == 'male') echo '<img class="rounded-circle" src="assets/img/boy.png" height="150px" style="margin-top:-70px;">';
           else echo '<img class="rounded-circle" src="assets/img/girl.png" height="150px" style="margin-top:-70px;">';
            ?>
             <h3><?php echo $name; ?></h3>
             <p style="padding:20px;padding-bottom:0;padding-top:5px;"><?php echo "$about"; ?></p>
         </div>
         <div class="row" style="padding:0;padding-bottom:10px;padding-top:20px;">
             <div class="col-md-6">
                 <p class="text-nowrap text-right">Accepted post</p>
                 <p class="text-right" ><strong><?php echo "$ac_post"; ?></strong> </p>
             </div>
             <div class="col-md-6">
                 <p class="text-left">Rejected post</p>
                 <p class="text-left"><strong><?php echo "$re_post"; ?></strong> </p>
             </div>
         </div>
     </div>
     <div class="container">
       <span class="navbar-text actions">
          <?php echo '<a class="btn btn1" role="button" href="info.php?oFym='.$id.'"> Info </a>'; ?>
       </span>
       <span class="navbar-text actions">
         <a class="btn btn2" role="button" href='#'>Pictures</a>
       </span>
       <span class="navbar-text actions">
         <a class="btn btn4" role="button" href='#'>Let's talk</a>
       </span>
     </div>
     <div class="btn-toolbar">
         <div class="btn-group" role="group"></div>
         <div class="btn-group" role="group"></div>
     </div>
         <script src="assets/js/jquery.min.js"></script>
         <script src="assets/bootstrap/js/bootstrap.min.js"></script>

          <br>
        <?php if($flag && !$noPost) {
          foreach ($res as $data) { ?>
         <div id="POST_ID_02" style="position: relative; margin-left: 20px;">
           Posted by: <b><?php echo $name; ?></b> on <?php   echo $data['post_time'] ?>
           <h3> <?php   echo "Titel: ".$data['post_titel'] ?></h3>
           <?php echo $data['post_text'] ?>
           <div class="LikesDislikes"><?php $cmntID = $data['p_id']; echo $data['likee'] ?> <?php echo '<a href="visitor.php?lk='.$cmntID.'&st='.$data["likee"].'">Like</a>'; ?>| <?php echo $data['dislike'] ?> <?php echo '<a href="visitor.php?dlk='.$cmntID.'&st='.$data["dislike"].'">Dislike</a>'; ?> <br></div>
           <div class="Comments">
             <?php
             $cmntID = $data['p_id'];
              echo '<a target="_blank"  href="cmnts.php?ditnmc='.$cmntID.'">Click here to comment  or see previous comments</a>';
               ?>

               <br>
           </div>
           _______________________________________________________________________________________
           <br><br>
         </div>
       <?php }
       }else if($noPost){
         if($gender == 'male') echo "<h1>Upsss.! He don't have any post.</h1>";
         else echo "<h1>Upsss.! She don't have any post.</h1>";
       } else {
         echo "<h1>Problem on database</h1>";
       }
     }else{
       echo "<h2>Problem on database.!!!</h2>";
     } ?>
     <br><br>
 </body>
 </html>
