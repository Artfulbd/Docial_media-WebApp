<?php
  include "Temp/connectdb.php";
  $link2 = mysqli_connect('localhost' , 'Artful' , 'a1234', 'pending_posts') or die("cannot connect");
  if(!$link2)echo "Connection error: ".mysqli_connect_error();
  if(!mysqli_select_db($link2, 'pending_posts'))echo 'Database not connected\n';

  /*SELECT TABLE_NAME
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='dbName'*/
  $postedData = "This post is for testing. All ok. Alhamdulillah";
  $newPostTitle = "Testing post titel";
  $newPostTime = date('Y-m-d H:i:s a', time());
  $adminCount = 0;
  $id = 4;
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


         $sql = "CREATE table `{$newTableName}`(post_titel varchar(50) ,post_text varchar(1000), post_time datetime, ad_2 varchar(5) DEFAULT 'dot',ad_3 varchar(5) DEFAULT 'dot');";
        echo "$sql<br>";
        $sql = "CREATE table `{$newTableName}`(post_titel varchar(50) ,post_text varchar(1000), post_time datetime)";
        $sql[strlen($sql)-1] = ' ';
        foreach ($adminData as $data) {
          $sql = $sql.", ad_".$data['id']." varchar(5) DEFAULT  'dot'";
        }
        $sql= $sql.');';
        echo "$sql<br>";

        $hold = mysqli_query($link2, $sql);
        $sql = "INSERT INTO `{$newTableName}`(`post_titel`, `post_text`, `post_time`) VALUES ('$newPostTitle','$postedData','$newPostTime');";
        $hold = mysqli_query($link2, $sql);
        if($hold){
          echo "Successfuly posted";
        }
        else {
          echo "Server down.";
        }
      }else {
        echo "Sorry, you already have a pending post.";
      }


      }




?>
