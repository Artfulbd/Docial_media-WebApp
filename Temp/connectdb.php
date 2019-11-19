<?php
    $link = mysqli_connect('localhost' , 'Artful' , 'a1234', 'test') or die("cannot connect");
    if(!$link)echo "Connection error: ".mysqli_connect_error();
    if(!mysqli_select_db($link, 'test'))echo 'Database not connected\n';
 ?>
