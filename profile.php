<?php
    include "Temp/connectdb.php";
    session_start();
    $_SESSION['rnd'] = '';
    $name = $_SESSION['username'];
    $id = $_SESSION['userid'];
    $_SESSION['cmntID'] = '';
    if($_SESSION['username'] == ''){
      header('Location: login.php');
    }
    $superAdmin = false;
    $rnd = '';
    $confermation = '';
    if($id == 2){
      $superAdmin = true;
      $rnd = rand();
      $_SESSION['rnd'] = $rnd ;
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

    if (isset($_GET['rq'])) {                                          ///admin request
      if($_GET['rq'] == '21csd8dscd'){
        $rqTime = date('Y-m-d H:i:s a', time());;
        $sql = "UPDATE `alluser` SET `admin_req`= '1', `reqTime`= '$rqTime' WHERE id = '$id'";
        $hold = mysqli_query($link, $sql);
        if($hold){
          header('Location: profile.php');
        }
        else{
          $confermation = "Server down";
        }
      }
    }

    if (isset($_GET['lk']) && isset($_GET['st'])) {                        /// like
             $like_id = test_input($_GET['lk']);
             $st = test_input($_GET['st']);
             $st++;
             $sql = " UPDATE `post` SET `likee` = $st WHERE `p_id` = '$like_id' ";
             $hold = mysqli_query($link, $sql);
     }
     else if (isset($_GET['dlk']) && isset($_GET['st'])) {                 /// like
              $like_id = test_input($_GET['dlk']);
              $st = test_input($_GET['st']);
              $st++;
              $sql = " UPDATE `post` SET `dislike` = $st WHERE `p_id` = '$like_id' ";
              $hold = mysqli_query($link, $sql);
      }

      $postedData = '';
      $newPostTitle = '';
      $postErr = '';
      $ttlErr = '';


      if ($_SERVER["REQUEST_METHOD"] == "POST" ) {                        ///new post
        $allok = true;
        if(empty($_POST["newTitle"])){
          $ttlErr = "Your titel box is empty.!!";
          $allok = false;
        }else {
          $newPostTitle = test_input($_POST["newTitle"]);
        }

        if(empty($_POST["newPost"])){
          $postErr = "Your post box is empty.!!";
          $allok = false;
        }  else {
          $postedData = $_POST['newPost'];
        }

        if($allok){
          $hold = $_POST['newPost'];
          $data = stripslashes($hold);
          $postedData = htmlspecialchars($data);
          if($hold != $postedData){
            $postedData = '';
            $postErr = "You are trying to hack right!? This is not allowed ..";
          }
          else {                                                            //do everything here
            $link2 = mysqli_connect('localhost' , 'Artful' , 'a1234', 'pending_posts') or die("cannot connect");
            if(!$link2)echo "Connection error: ".mysqli_connect_error();
            if(!mysqli_select_db($link2, 'pending_posts'))echo 'Database not connected\n';


            $newPostTime = date('Y-m-d H:i:s a', time());
            $adminCount = 0;
            $havePendingPost = false;
            $res = array();

            $sql = "SELECT id FROM `admins`";
            $hold = mysqli_query($link , $sql);
            if(!$hold){
              echo "Problem";
              echo "send a error msg";
            } else {               /// do everything here
                $allTableName = array();           ///checking for exiesting post
                $newTableName = "post".$id;
                $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='pending_posts' ";
                $allTableName = mysqli_fetch_all(mysqli_query($link2, $sql), MYSQLI_ASSOC);
                $tblcnt = count($allTableName);
                for ($i = 0; $i < $tblcnt; $i++) {
                   if($allTableName[$i]['TABLE_NAME']== $newTableName){  ///means you already have a post/
                     $havePendingPost = true;
                     break;
                   }
                }
                if(!$havePendingPost){           ///posting
                  $adminData = mysqli_fetch_all($hold, MYSQLI_ASSOC);
                  $adminCount = count($adminData);

                  $sql = "CREATE table `{$newTableName}`(post_titel varchar(50) ,post_text varchar(1000), post_time datetime)";
                  $sql[strlen($sql)-1] = ' ';
                  foreach ($adminData as $data) {
                    $sql = $sql.", ad_".$data['id']." varchar(5) DEFAULT  'dot'";
                  }
                  $sql= $sql.');';

                  $hold = mysqli_query($link2, $sql);
                  $sql = "INSERT INTO `{$newTableName}`(`post_titel`, `post_text`, `post_time`) VALUES ('$newPostTitle','$postedData','$newPostTime');";
                  $hold = mysqli_query($link2, $sql);
                  if($hold){
                    $postedData = '';
                    $newPostTitle = '';
                    $confermation = "Your post successfuly sent to admin panel";
                  }
                  else {
                     $confermation = "Sorry, cannot post. Server down.";
                  }
                }else {
                  $confermation =  "Sorry, you already have a pending post.";
                }
              }
          }
        }
      }

    $admin = false;
    $admin_req = false;
    $ac_post = 0;
    $re_post = 0;
    $allok = false;
    $cmntID = 0;
    $gender = '';
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
         $gender = $res[0]['gender'];
         $admin = $res[0]['is_admin'];
         $ac_post = $res[0]['ac_post'];
         $re_post = $res[0]['re_post'];
         $admin_req = $res[0]['admin_req'];
         $allok = true;

       }
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

 ?>
 <!DOCTYPE html>
 <html>

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>profile</title>
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
         <li class="nav-item"><a class="nav-link active" href="profile.php">My profile</a></li>
         <li class="nav-item"><a class="nav-link " href="feed.php">Feed</a></li>
         <pre style="font-style: italic; font-size:20px; color:red;">                         <b><?php echo "$confermation"; ?></b></pre>
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
          <?php echo '<a class="btn btn1" role="button" href="info.php?oFym='.$id.'">My Info</a>'; ?>
       </span>
       <span class="navbar-text actions">
         <a class="btn btn2" role="button" href='#'>Pictures</a>
       </span>
       <span class="navbar-text actions">
         <?php
         if($superAdmin) echo '<a class="btn btn3" role="button" target="_blank" href="admin.php?rd='.$rnd.'">Aprove admin</a>';
         else if($admin) echo '<a class="btn btn3" role="button" target="_blank" href="post.php?rq=oppa">Aprove post</a>';
         else {
           if($admin_req)echo '<a class="btn btn3" role="button" href="#">Admin request sent</a>';
           else echo '<a class="btn btn3" role="button" href="profile.php?rq=21csd8dscd">Send admin request</a>';
         }
          ?>
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

         <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
             <div class="text-center profile-card" style="margin:15px;background-color:#ffffff;">
                <h4>Post title</h4> <input name="newTitle"  value="<?php echo $newPostTitle;?>" type="text"  id="examplepost" placeholder="Write your post title" >
                <br><span style="background-color:red;">* <?php echo $ttlErr;?></span>
               <h4>->Post content<</h4> <textarea  name="newPost" value="<?php echo $postedData;?>" rows="4" cols="60" id="exampleInputCmnt" placeholder="What do you want to say, write here .."></textarea>
               <br><span style="background-color:red;">* <?php echo $postErr;?></span>
            </div>

            <div class="wrapper">
                <button type="submit" class="button btn btn-primary"  name="submit">Post</button>
            </div>
          </form>
          <br>
        <?php if($flag && !$noPost) {
          foreach ($res as $data) { ?>
         <div id="POST_ID_02" style="position: relative; margin-left: 20px;">
           Posted by: <b><?php echo $name; ?></b> on <?php   echo $data['post_time'] ?>
           <h3> <?php   echo "Titel: ".$data['post_titel'] ?></h3>
           <?php echo $data['post_text'] ?>
           <div class="LikesDislikes"><?php $cmntID = $data['p_id']; echo $data['likee'] ?> <?php echo '<a href="profile.php?lk='.$cmntID.'&st='.$data["likee"].'">Like</a>'; ?>| <?php echo $data['dislike'] ?> <?php echo '<a href="profile.php?dlk='.$cmntID.'&st='.$data["dislike"].'">Dislike</a>'; ?> <br></div>
           <div class="Comments">
             <?php
             $cmntID = $data['p_id'];
              echo '<a target="_blank"  href="cmnts.php?ditnmc='.$cmntID.'">Click here to comment  or see previous comments</a>';
               ?>


               <br>
           </div>
           _____________________________________________________________________________________________

           <br><br>
         </div>

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
