<?php
    include "Temp/connectdb.php";
    session_start();
    if($_SESSION['username'] == ''){
      header('Location: login.php');
    }
    $name = $_SESSION['username'];
    $id = $_SESSION['userid'];
    $_SESSION['cmntID'] = '';
    if($name == ''){
      header('Location: login.php');
    }
    if (isset($_GET['lk']) && isset($_GET['st'])) {                 /// like
             $like_id = test_input($_GET['lk']);
             $st = test_input($_GET['st']);
             $st++;
             $sql = " UPDATE `post` SET `likee` = $st WHERE `p_id` = '$like_id' ";
             $hold = mysqli_query($link, $sql);
     }
     else if (isset($_GET['dlk']) && isset($_GET['st'])) {                 /// dislike
              $like_id = test_input($_GET['dlk']);
              $st = test_input($_GET['st']);
              $st++;
              $sql = " UPDATE `post` SET `dislike` = $st WHERE `p_id` = '$like_id' ";
              $hold = mysqli_query($link, $sql);
      }

    $allok = false;
    $cmntID = 0;
    $sql = "SELECT * FROM `alluser` WHERE id = '$id'";
    $hold = mysqli_query($link , $sql);
    $noPost = false;
     if(!$hold){
       echo "Problem";
     }else{
       $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
       if(!array_filter($res)){
           echo "Problem on database.!!";
       }
       else {
         $allok = true;

       }
     }
    $about = "Ohohohoh it's working that's great sounds well..";
    $flag = false;
    $sql = "SELECT * FROM `post` ORDER BY `post`.`post_time` ASC ";
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
     function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
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
     <title>Feed</title>
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
             <div class="container"><a class="navbar-brand" href="#">Artful <?php echo '  --('.$name.')--' ?></a>
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
         <li class="nav-item"><a class="nav-link " href="profile.php">My profile</a></li>
         <li class="nav-item"><a class="nav-link active" href="feed.php">Feed</a></li>
     </ul>




          <br>
        <?php if($flag && !$noPost) {
          foreach ($res as $data) {
            $posted_by = $data['id'];
            $sql = "SELECT name FROM `alluser` WHERE id = '$posted_by'";
            $posted_by = '';
            $hold = mysqli_query($link , $sql);
             if(!$hold){
               echo "Problem";
             }else{
               $res2  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
               $posted_by = $res2[0]['name'];
             }
             ?>
         <div id="POST_ID_02" style="position: relative; margin-left: 20px;">
           Posted by:<b>
           <?php
                $vid = $data['id'];
               if($id == $vid) echo $name;
               else {
                 echo '<a target="_blank" href="visitor.php?dit='.$vid.'"> '.$posted_by.'</a>';
               }
            ?>
           </b> on <?php   echo $data['post_time'] ?>
           <h3> <?php   echo "Titel: ".$data['post_titel'] ?></h3>
           <?php echo $data['post_text'] ?>
           <div class="LikesDislikes"><?php $cmntID = $data['p_id']; echo $data['likee'] ?> <?php echo '<a href="feed.php?lk='.$cmntID.'&st='.$data["likee"].'">Like</a>'; ?>| <?php echo $data['dislike'] ?> <?php echo '<a href="feed.php?dlk='.$cmntID.'&st='.$data["dislike"].'">Dislike</a>'; ?> <br></div>
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
         <br><br>
       <?php }
       }else if($noPost){

         echo "<h1>Upsss.! You don't have any post.</h1>";
       } else {
         echo "<h1>Problem on database</h1>";
       }
     }else{
       echo "<h2>Problem on database.!!!</h2>";
     } ?>
 </body>
 </html>
