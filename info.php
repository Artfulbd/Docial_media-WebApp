<?php
    include "Temp/connectdb.php";
    $visitorId ='';
    $visitorName = '';
    session_start();
    if($_SESSION['username'] == ''){
      header('Location: login.php');
    }
    $visitorId = $_SESSION['userid'];
    $visitorName = $_SESSION['username'];
    $id = '';
    $email = '';
    $name = '';
    $gender = '';
    $bday = '';
    $addres = '';
    $fname  = '';
    $mname = '';

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    if (isset($_GET['oFym'])) {  // do everything here
        $id = $_GET['oFym'];
        $id = test_input($id);
        $sql =" SELECT name, fname, mname, bday,email,gender,addr FROM `alluser` WHERE id = '$id'" ;
        $hold = mysqli_query($link, $sql);
        if($hold){
            $res = mysqli_fetch_all($hold, MYSQLI_ASSOC);
            $email = $res[0]['email'];
            $name = $res[0]['name'];
            $gender = $res[0]['gender'];
            $bday = $res[0]['bday'];
            $addres = $res[0]['addr'];
            $fname  = $res[0]['fname'];
            $mname = $res[0]['mname'];
        }

    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>User info</title>
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
          <div class="container"><a class="navbar-brand" href="#">Artful <?php echo '  --('.$visitorName.')--' ?></a>
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

<div>
  <div class ="profileContents" id="profiledetails">
    <?php
    if($gender == 'male') echo '<img class="profpic" src="assets/img/boy.png" height="150px" width="200"">';
    else echo '<img class="profpic" src="assets/img/girl.png" height="150px" width="150"">';
     ?>
    <h1><?php echo "$name"; ?></h1>
  </div>
  <div class="profileContents_" id="allposts">
    <div class="leftallignedcontents" id="posts">

      <h3>Email: <?php echo "$email"; ?></h3>
      <h3>
        Date of Birth:<?php echo "  $bday"; ?>
      </h3>
      <h3>
        Gender:<?php echo "  $gender"; ?>
      </h3>
      <h3>
        Father's name:<?php echo "  $fname"; ?>
      </h3>
      <h3>
        Father's name:<?php echo "  $mname"; ?>
      </h3>
      <h3>
        Address:<?php echo "  $addres"; ?>
      </h3>
    </div>

  </div>
</div>
</body>
</html>
