<?php

session_start();
include('connection.php');


$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

// get user_id
$id = $formDetails->id;
$note = $formDetails->note;

$time = time();

$sql = "UPDATE notes SET note='$note', time='$time' WHERE id='$id'";
$result = mysqli_query($link,$sql);

if(!$result){
    echo 'error';
}

?>