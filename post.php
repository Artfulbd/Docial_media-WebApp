<?php

    $link2 = mysqli_connect('localhost' , 'Artful' , 'a1234', 'pending_posts') or die("cannot connect");
    if(!$link2)echo "Connection error: ".mysqli_connect_error();
    if(!mysqli_select_db($link2, 'pending_posts'))echo 'Database not connected\n';
    session_start();
    $name = $_SESSION['username'];
    $id = $_SESSION['userid'];
    $target = "ad_".$id;
    if($_SESSION['username'] == ''){
      header('Location: login.php');
    }
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    function checkIt($tableName){
      include "Temp/connectdb.php";
      $link2 = mysqli_connect('localhost' , 'Artful' , 'a1234', 'pending_posts') or die("cannot connect");
      if(!$link2)echo "Connection error: ".mysqli_connect_error();
      if(!mysqli_select_db($link2, 'pending_posts'))echo 'Database not connected\n';

      $sql = "SELECT count(*) d FROM information_schema.columns WHERE table_name ='$tableName'";
      $hold = mysqli_fetch_all(mysqli_query($link2,$sql),MYSQLI_ASSOC);
      $totalVote = $hold[0]['d'];
      $totalVote -=3;
      $requ = ($totalVote * 50)/100;
      $sql = "SELECT * FROM $tableName";
      $hold = mysqli_query($link2,$sql);
      if(!$hold)return 0;
      $data = mysqli_fetch_all($hold,MYSQLI_ASSOC);


      $sql = "SELECT column_name d FROM information_schema.columns WHERE table_name='$tableName'";
      $hold = mysqli_query($link2,$sql);
      if(!$hold)return 0;
      $columns = mysqli_fetch_all($hold,MYSQLI_ASSOC);

      $yvote = 0;
      $nvote = 0;
      for ($i=3; $i <count($columns) ; $i++) {
              if($data[0][$columns[$i]['d']] == 'yes') $yvote++;
              else if($data[0][$columns[$i]['d']] == 'no') $nvote++;
      }
      $id = preg_replace('/[^0-9]/', '', "$tableName");
      if($totalVote == ($yvote+$nvote)){
        $ac = false;
        if($yvote >= $requ){
            $sql = "SELECT count(*) d from post";
            $hold = mysqli_fetch_all(mysqli_query($link,$sql),MYSQLI_ASSOC);
            $postid = $hold[0]['d']+1;
            $title = $data[0]['post_titel'];
            $time = $data[0]['post_time'];
            $text = $data[0]['post_text'];
            $sql = "INSERT INTO `post`(`id`, `p_id`, `post_titel`, `post_text`,  `post_time`) VALUES ($id,$postid,'$title', '$text','$time')";
            $hold = mysqli_query($link,$sql);
            $sql = "UPDATE alluser SET ac_post = ac_post + 1 where id = '$id'";
            $hold = mysqli_query($link,$sql);
            $ac = true;
        }
        if(!$ac){
          $sql = "UPDATE alluser SET re_post = re_post + 1 where id = '$id'";
          $hold = mysqli_query($link,$sql);
        }
        $sql = "DROP TABLE $tableName";
        $hold = mysqli_query($link2,$sql);
      }
    }// end of function hahuhu



    if(isset($_GET['docu']) && isset($_GET['st'])){
          $docu = test_input($_GET['docu']);
          $st = test_input($_GET['st']);
          if($st == 609){
            $sql = "UPDATE `{$docu}` SET `{$target}`= 'yes' WHERE 1";
            $hold = mysqli_query($link2, $sql);
          }
          else if($st == 456){
            $sql = "UPDATE `{$docu}` SET `{$target}`= 'no' WHERE 1";
            $hold = mysqli_query($link2, $sql);
          }
          checkIt($docu);
          $_GET['docu'] = '';
          header('Location: post.php');
    }
    $tableNames = array();
    $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='pending_posts'";
    $res =  mysqli_fetch_all(mysqli_query($link2,$sql),MYSQLI_ASSOC);
    $pendingCount = count($res);

    for ($i=0; $i <$pendingCount ; $i++) {
        $temp = $res[$i]['TABLE_NAME'];
        $sql = "SELECT `{$target}` d from $temp";
        $hold = mysqli_query($link2,$sql);
        if($hold){
          $data = mysqli_fetch_all($hold,MYSQLI_ASSOC);
           if($data[0]['d'] == 'dot') array_push($tableNames,$res[$i]['TABLE_NAME']);
        }
    }
    $pendingCount = count($tableNames);


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Approve post</title>
  <meta charset="utf-8">
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
          <div class="container"><a class="h1 navbar-brand" href="#">Artful <?php echo '  --('.$name.')--' ?></a>
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

<div class ="feedContents" >
  <div class="leftallignedcontents" id="posts">
    <div class="h5 bg-danger"> Pending Posts: <?php echo "$pendingCount"; ?> </div>
    <br><br>
    <?php
    $time = '';
    $title = '';
    $text = '';
    for ($i=0; $i <$pendingCount ; $i++) {
            $sql = "SELECT post_titel,post_text,post_time FROM $tableNames[$i]";
            $hold = mysqli_fetch_all(mysqli_query($link2, $sql), MYSQLI_ASSOC);
            $time = $hold[0]['post_time'];
            $title =$hold[0]['post_titel'];
            $text = $hold[0]['post_text'];
     ?>

    <div id="POST_ID_02">
      <h4>Posted on <?php echo $time; ?></h4>
      <h3> <?php echo $title; ?> </h3>
      <?php echo $text; ?>
      <br>
      <br>
      <div>
          <?php echo '<a class="btn btn-success action-button" role="button" href="post.php? docu='.$tableNames[$i].' & st=609">Agree</a>';?>
          <?php echo '<a class="btn btn-danger action-button" role="button" href="post.php? st=456 & docu='.$tableNames[$i].'">Disagree</a>'; ?>
      </div>
      ____________________________________________________
      <br><br>
    </div>

    <?php } ?>

  </div>
</div>
</body>
</html>
