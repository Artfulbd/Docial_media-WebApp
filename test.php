<?php
    include "Temp/connectdb.php";
    $adims;
    $sql = 'SELECT * FROM `admins`';
    $hold = mysqli_query($link,$sql);
    $admincount = 0;
     if(!$hold){
       echo "problem on database.!!";
     }else{
       $res  = mysqli_fetch_all($hold, MYSQLI_ASSOC);
       if(!array_filter($res)){
           echo "NO value found.!!";
       }
       else {
         $admincount = count($res);
         foreach ($res as $data) {
           echo $data['id']."<br>";
           echo $data['name']."<br>";
           echo $data['startdate']."<br>";
         }
       }
     }
     
     $sql = "INSERT INTO `pending_post`(`id`, `post_text`, `post_time`)";
     $sql[strlen($sql)-1] = ' ';
     for($i = 0; $i<$admincount; $i++){
       $sql = $sql.',`admin'.$res[$i]['id'].'`, '.'`admin'.$res[$i]['id'].'_text` ';
     }
     $sql[strlen($sql)-1] = ')';
     $sql = $sql.' VALUES ';
      $id = 4;
      $post = "Amnitei try kore dekhlam r ki ..";
      $post_time = date('Y-m-d H:i:s a', time());
       $sql = $sql."('$id', '$post', '$post_time' ";

       for($i = 0; $i<$admincount; $i++){
         $sql = $sql.', 0, " " ';
       }
       $sql = $sql.')';

       echo $sql.'<br>';
       $hold = mysqli_query($link,$sql);
       $admincount = 0;
        if(!$hold){
          echo "problem on database.!!";
        }
        else {
          echo "Done";
        }


 ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Hello I am from another php file, I am truing to run on you.<br></h1>


  </body>
</html>
