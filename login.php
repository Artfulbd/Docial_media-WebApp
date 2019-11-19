<?php
    $email = $pass = '';
    $errors = array('email' => '', 'pass' => '');
    if(isset($_POST['submit'])){
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      if(empty($email)){
        $errors['email'] = 'An email is required';
      } else if (!preg_match("/^[0-9][0-9][0-9][0-9]?/",$email)) {
        $errors['email'] = 'NID must be valid';
      }
      if(empty($_POST['pass'])){
        $errors['pass'] = 'A password is required';
      } else
      if (!preg_match("/^\S*(?=\S{4,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/",$pass)) {
        $errors['pass'] = 'Invalid id or password';
      }

      if(!array_filter($errors))
      {
        include 'Temp/connectdb.php';
        $sql = "SELECT name, id from alluser where nid = '$email' and pass = '$pass'";
        $hold = mysqli_query($link , $sql);
         if(!$hold){
           $errors['pass'] = 'Server down';
         }else{
           $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
           if(!array_filter($res)){
               $errors['pass'] = 'Invalid id or password';
           }
           else {
            include 'Temp/globalVars.php';
             //echo $res[0]['name'];
             session_start();
             $_SESSION['username'] = $res[0]['name'];
             $_SESSION['userid'] = $res[0]['id'];
             header('Location: profile.php');
           }
         }
      }

    }// end of postcheck
 ?>
 <!DOCTYPE html>
<html >
  <?php include 'Temp/header.php'; ?>

    <section class="container gray-text">
      <h4 class="center">Log in page</h4>
      <form class="white" action="login.php" method="POST">
        <label>Enter your NID: </label>
        <input type="text" name="email"  value = <?php echo htmlspecialchars($email); ?>>
        <div class="red-text"><?php echo $errors['email']; ?></div>

        <label>Enter password: </label>
        <input type="text" name="pass" value =<?php echo htmlspecialchars($pass); ?> >
        <div class="red-text"><?php echo $errors['pass']; ?></div>

        <div class="center">
          <input type="submit" name="submit" value="Log in" class="btn brand z-depth-0">
        </div>
        <br><br>
        <li><a href="singup.php" target="_blank" >Creat new Account</a> </li>
      </form>
    </section>

  <?php include 'Temp/footer.php'; ?>
</html>
