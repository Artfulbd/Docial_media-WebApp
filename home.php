<?php
       include 'Temp/connectdb.php';
       $email = 'a@d.com';
       $pass =  'asdf';
       $name ='Somebody';
       $age =  12;
       $sql2 = "INSERT INTO logininfo (email, pass, Name, age) VALUES ('$email', ' $pass', '$name', '$age')";
       echo 'working'.'<br>';
       if(mysqli_query($link,$sql2))echo "Uploaded";


       $sql = "SELECT * FROM `alluser`";
       $hold = mysqli_query($link , $sql);
       $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
       mysqli_free_result($hold);

       $sql = 'SELECT COUNT(email) from logininfo';
       $hold = mysqli_query($link , $sql);
       mysqli_close($link);
 ?>
<!DOCTYPE html>
<html >
  <?php include 'Temp/header.php'; ?>

    <h1>From our database</h1>
    <table>
      <tr>
        <th>Email</th>
        <th>Name</th>
      </tr>
      <?php foreach ($res as $data) {?>
        <tr>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['Name']; ?></td>
        </tr>
      <?php } ?>


    </table>
    <?php



     ?>

  <?php include 'Temp/footer.php'; ?>
</html>
