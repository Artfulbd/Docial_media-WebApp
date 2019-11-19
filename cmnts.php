<?php
    include "Temp/connectdb.php";
    $link2 = mysqli_connect('localhost' , 'Artful' , 'a1234', 'comment') or die("cannot connect");
    if(!$link2)echo "Connection error: ".mysqli_connect_error();
    if(!mysqli_select_db($link2, 'comment'))echo 'Database not connected\n';

    session_start();
    if($_SESSION['username'] == ''){
      header('Location: login.php');
    }
    $cmntID = 0;
    $userName = $_SESSION['username'];
    $userID = $_SESSION['userid'];
    if (isset($_GET['ditnmc'])) {
      $_SESSION['cmntID'] = $_GET["ditnmc"];
    }
    $cmntID =   $_SESSION['cmntID'];
    $tablename = "cmnt".$cmntID;

    if (isset($_GET['out'])) {                 /// log out
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
    if (isset($_GET['lk']) && isset($_GET['st'])) {                 /// like
             $like_id = test_input($_GET['lk']);
             $st = test_input($_GET['st']);
             $st++;
             $sql = " UPDATE `{$tablename}` SET `likee` = $st WHERE `id` = '$like_id' ";
             $hold = mysqli_query($link2, $sql);
     }
     else if (isset($_GET['dlk']) && isset($_GET['st'])) {                 /// dislike
              $like_id = test_input($_GET['dlk']);
              $st = test_input($_GET['st']);
              $st++;
              $sql = " UPDATE `{$tablename}` SET `dislike` = $st WHERE `id` = '$like_id' ";
              $hold = mysqli_query($link2, $sql);
      }
    $cmntErr ='';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["cmnt"])) {
        $cmntErr  = "Your comment field is empty.!!";
      } else {
        $cmnt = test_input($_POST["cmnt"]);
        echo $cmnt;


        $sql = "SELECT * FROM `{$tablename}` ORDER BY cmnt_time  ASC ";
        $hold = mysqli_query($link2 , $sql);
         if(!$hold){

           $tablename = "cmnt".$cmntID;
           $sql = "CREATE TABLE `{$tablename}` (cmnt_text varchar(300), likee int,dislike int,name varchar(30), id int, cmnt_time datetime)";
           $hold = mysqli_query($link2 , $sql);
           if($hold){
             $date = date('Y-m-d H:i:s a', time());
             $sql = "INSERT INTO `{$tablename}`(`cmnt_text`, `likee`, `dislike`, `name`, `id`, `cmnt_time`) VALUES ('$cmnt',0,0,'$userName','$userID','$date')";
             mysqli_query($link2 , $sql);
           }
           else {
             echo "Problem on database .!";
           }


         }else{
           $date = date('Y-m-d H:i:s a', time());
           $sql = "INSERT INTO `{$tablename}`(`cmnt_text`, `likee`, `dislike`, `name`, `id`, `cmnt_time`) VALUES ('$cmnt',0,0,'$userName','$userID','$date')";
           mysqli_query($link2 , $sql);

         }

         $sql = " UPDATE `post` SET `has_cmnt` = '1' WHERE `p_id` = '$cmntID' ";
         mysqli_query($link , $sql);
         header('Location: cmnts.php');
      }
    }
    $post = '';
    $post_like = '';
    $post_dislike = '';
    $post_time = '';
    $post_title = '';
    $post_by = '';
    $posterID = '';
    $nocmnt = true;
    $sql = "SELECT * FROM `post` where p_id = '$cmntID'";
    $hold = mysqli_query($link , $sql);
     if(!$hold){
       echo "problem on database.!!";
     }else{
       $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
       if(!array_filter($res)){
           echo "NO value found.!!";
       }
       else {
         $post = $res[0]['post_text'];
         $post_like = $res[0]['likee'];
         $post_dislike = $res[0]['dislike'];
         $post_time = $res[0]['post_time'];
         $post_title = $res[0]['post_titel'];
         $posterID = $res[0]['id'];
         if($res[0]['has_cmnt'])$nocmnt = false;

         $sql = "SELECT name FROM `alluser` where id = '$posterID'";
         $res  = mysqli_fetch_all(mysqli_query($link , $sql), MYSQLI_ASSOC);
         $post_by = $res[0]['name'];
         mysqli_close($link);


       }
     }
     if(!$nocmnt){
       $tablename = "cmnt".$cmntID;
       $sql = "SELECT * FROM `{$tablename}` ORDER BY cmnt_time  ASC ";
       $hold = mysqli_query($link2 , $sql);
        if(!$hold){
          echo "Problem on Database.!!!!";
           $nocmnt = true;
        }else{
          $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
          if(!array_filter($res)){
             $nocmnt = true;
             echo "No cmnt";
          }
        }
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comment</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
  <link rel="stylesheet" href="assets/css/Profile-Card-1.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .profileContents{
    padding: 50px 0px 0 0px; /* Dont touch this*/
    text-align: center;
    /**/
  }
  .profileContents_{
    margin: 25px 450px 75px; /*top - lr - bottom*/

    color: black;
    text-align: center;
    /**/
  }
  .leftallignedcontents{
    text-align: left;
  }
  .post{
    padding: 50px 0px 0 0px; /* Padding is for the spacing between profile picture+name and the profile posts*/
    text-align: center;
  }
  .profpic{
    padding:2px;
    border: 2px solid black;
  }
  .Comments{
    font-size: 14px;
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
              </ul>
              <span class="navbar-text actions">
                <a class="btn btn-light action-button" role="button" href='cmnts.php?out=true'>Log out</a>
              </span><b></b>
            </div>
      </div>
  </nav>

<div>
  <div class="profileContents_" id="allposts">
    <div class="leftallignedcontents" id="posts">
      <div id="POST_ID_01">
        <div>Posted by:
          <?php
          if($posterID == $userID) echo "<b>$userName</b>";
           else echo '<a target="_blank" href="visitor.php?dit='.$posterID.'"> '.$post_by.'</a>';
           ?>
           on <?php echo "$post_time"; ?></div>
        <h3> <?php echo $post_title;  ?></h3>
        <?php echo $post; ?>
          <br>
        <div class="LikesDislikes"><?php echo $post_like ?> likes | <?php echo $post_dislike ?> dislikes <br></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <label for="exampleInputCmnt">Write a Comment:</label>
            <textarea class="form-control" id="exampleInputCmnt" rows="3" name="cmnt"></textarea>
            <span class="error- red">* <?php echo $cmntErr;?></span>
            <br>
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          <br>
        </form>
        <br>
        <?php if(!$nocmnt){
          foreach ($res as $data) {
            $vid = $data['id']; ?>
        <div class="Comments">
          <div id="comment_POSTID_COMMENTID">
            <?php echo $data['cmnt_text']; ?>
              <div>Posted by:
              <?php
                  if($userName == $data['name']) echo $userName;
                  else {
                    echo '<a target="_blank" href="visitor.php?dit='.$vid.'"> '.$data["name"].'</a>';
                  }
               ?>
                on <?php   echo $data['cmnt_time'] ?> </div>

            <div class="LikesDislikes"><?php echo $data['likee'] ?> <?php echo '<a href="cmnts.php?ditnmc='.$cmntID.'&lk='.$vid.'&st='.$data["likee"].'">Like</a>'; ?>| <?php echo $data['dislike'] ?> <?php echo '<a href="cmnts.php?ditnmc='.$cmntID.'&dlk='.$vid.'&st='.$data["dislike"].'">Dislike</a>'; ?> <br></div>

            <br>
          </div>
        <?php }
      }else {
        echo "<h2>Upss. no comment!</h2>";
      } ?>
        </div>
      </div>
    </div>

  </div>
</div>
</body>
</html>
