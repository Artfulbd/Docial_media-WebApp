
<!DOCTYPE HTML>
<html>
<?php include 'Temp/header.php'; ?>

<?php
// define variables and set to empty values
include 'Temp/connectdb.php';
$success = "Enter your information here";
$nameErr = $emailErr = $genderErr = $nidErr = $passErr = $bdayErr = $addErr =  $fnameErr = $mnameErr = "";
$name = $email = $gender = $website = $nid = $pass1 = $pass2 = $add =  $fname =  $mname = $bday ="";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["fname"])) {
    $fnameErr = "Father's name is required";
  } else {
    $fname = test_input($_POST["fname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fnameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["mname"])) {
    $mnameErr = "Mother's name is required";
  } else {
    $mname = test_input($_POST["mname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$mname)) {
      $mnameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["nid"])) {
    $nidErr = "NID is required";
  } else {
    $nid = test_input($_POST["nid"]);
    // if (!preg_match("/^[\d]{5,5}?/",$website)) {
    if (!preg_match("/^[0-9][0-9][0-9][0-9]?/",$nid)) {
      $nidErr = "Invalid NID";
    }
  }

  if (empty($_POST["pass1"]) && empty($_POST["pass2"])) {
    $passErr = "password is required";
  } else if(empty($_POST["pass2"])){
    $passErr = "reenter-password is required";
  } else {
    $pass1 = test_input($_POST["pass1"]);
    $pass2 = test_input($_POST["pass2"]);
    if($pass1 != $pass2) $passErr = "They are not samne";
    else if (!preg_match("/^\S*(?=\S{4,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/",$pass1)) {
      $passErr = "Invalid password";
    }
  }

  if (empty($_POST["bday"])) {
    $bdayErr = "Birthdate is required";
  } else {
    $bday = test_input($_POST["bday"]);
  }


  if (empty($_POST["add"])) {
    $addErr = "Address requered";
  } else {
    $add = test_input($_POST["add"]);
  }



  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }


  $allok = $nameErr . $emailErr . $genderErr . $nidErr . $passErr . $bdayErr . $addErr .  $fnameErr . $mnameErr;
 if($allok == "")
  {
    $res = array();
    $sql = 'select * from alluser';
    $hold = mysqli_query($link , $sql);
    $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
    mysqli_free_result($hold);
    $newID = sizeof($res);
    $newID = $newID+1;
    $found = false;
    foreach ($res as $data) {
      if($data['nid'] == $nid){
        $found = true;
        break;
      }
    }
    if($found){
      global $success;
      $success = "Account already exist";
    }else{
      $sql3 = "INSERT INTO `alluser`(`id`, `nid`, `email`, `pass`, `name`, `fname`, `mname`, `gender`, `bday`, `addr`)VALUES ('$newID', '$nid', '$email', '$pass1', '$name', '$fname', '$mname', '$gender', '$bday','$add')";
      $hold = mysqli_query($link , $sql3);
       if(!$hold){
         global $seuucess;
         $success = "Problem in account  creating.!!";
       }else{
         global $seuucess;
         $success = "Account successfuly created";
        header('Refresh: 4; URL=http://localhost/phpFiles/sight/login.php');
       }



    }// end of else
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<h2 style="text-align:center"><?php echo $success; ?></h2>

<div class="center">
  <p><span class="error- red">* required field</span></p>
</div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error- red">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error- red">* <?php echo $emailErr;?></span>
  <br><br>
  NID: <input type="text" name="nid" value="<?php echo $nid;?>">
  <span class="error- red">* <?php echo $nidErr;?></span>
  <br><br>

  Password: <input type="password" name="pass1" value="<?php echo $pass1;?>">
  <br><br>
  Reenter-Password<input type="password" name="pass2" value="<?php echo $pass2;?>">
  <span class="error- red">* <?php echo $passErr;?></span>
  <br><br>
  Birthday:<input type="date" name="bday" value="<?php echo $bday;?>">
  <span class="error- red">* <?php echo $bdayErr;?></span>
  <br><br>
  Address: <textarea name="add" rows="10" cols="40"><?php echo $add;?></textarea>
  <span class="error- red">* <?php echo $addErr;?></span>
  <br><br>
  Gender:
  <span class="error- red">* <?php echo $genderErr;?></span>
  <br><br>
  <p>
    <label>
      <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">
      <span>Female</span>
    </label>
  </p>
  <p>
    <label>
      <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">
      <span>Male</span>
    </label>
  </p>
  <p>
    <label>
      <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">
      <span>Other</span>
    </label>
  </p>
  Father's name: <input type="text" name="fname" value="<?php echo $fname;?>">
  <span class="error- red">* <?php echo $fnameErr;?></span>
  <br><br>
  Mother's name: <input type="text" name="mname" value="<?php echo $fname;?>">
  <span class="error- red">* <?php echo $mnameErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

  <?php include 'Temp/footer.php'; ?>
</html>
