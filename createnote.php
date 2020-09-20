<?php

session_start();
include('connection.php');

// get user_id
$user_id = $_SESSION['user_id'];

// get time
$time = time();

$sql = "INSERT INTO notes (user_id,note,time) VALUES ('$user_id','','$time')";
$result = mysqli_query($link, $sql);

if(!$result){
    echo 'error';
}else{
    echo mysqli_insert_id($link);
}

?>