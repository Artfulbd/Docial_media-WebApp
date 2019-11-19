<?php
    include "Temp/connectdb.php";
    $link2 = mysqli_connect('localhost' , 'Artful' , 'a1234', 'pending_posts') or die("cannot connect");
    if(!$link2)echo "Connection error: ".mysqli_connect_error();
    if(!mysqli_select_db($link2, 'pending_posts'))echo 'Database not connected\n';
    $tableName = 'post4';
    $sql = "SELECT count(*) d FROM information_schema.columns WHERE table_name ='$tableName'";
    $hold = mysqli_fetch_all(mysqli_query($link2,$sql),MYSQLI_ASSOC);
    $totalVote = $hold[0]['d'];
    $totalVote -=3;
    $requ = ($totalVote * 50)/100;
    $sql = "SELECT * FROM $tableName";
    $data = mysqli_fetch_all(mysqli_query($link2,$sql),MYSQLI_ASSOC);
    print_r($data);



    $sql = "SELECT column_name d FROM information_schema.columns WHERE table_name='$tableName'";
    $columns = mysqli_fetch_all(mysqli_query($link2,$sql),MYSQLI_ASSOC);

    $yvote = 0;
    $nvote = 0;
    for ($i=3; $i <count($columns) ; $i++) {
            if($data[0][$columns[$i]['d']] == 'yes') $yvote++;
            else if($data[0][$columns[$i]['d']] == 'no') $nvote++;
    }
    echo "<br>$yvote  $nvote<br>";
    $id = preg_replace('/[^0-9]/', '', "$tableName");
    echo $id."<br>";
    if($totalVote == ($yvote+$nvote)){
      if($yvote >= $requ){
        echo "Yes<br>";
          $sql = "SELECT count(*) d from post";
          $hold = mysqli_fetch_all(mysqli_query($link,$sql),MYSQLI_ASSOC);
          $postid = $hold[0]['d']+1;
          $title = $data[0]['post_titel'];
          $time = $data[0]['post_time'];
          $text = $data[0]['post_text'];
          $sql = "INSERT INTO `post`(`id`, `p_id`, `post_titel`, `post_text`,  `post_time`) VALUES ($id,$postid,'$title', '$text','$time')";
          $hold = mysqli_query($link,$sql);


      } else {
        echo "no";


      }
      $sql = "DROP TABLE $tableName";
      $hold = mysqli_query($link2,$sql);
      echo $sql;




    } else {
      echo "Custing continue";
    }

 ?>
