<?php

session_start();
include('connection.php');

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

// get user_id
$note_id = $formDetails->id;

$sql = "DELETE FROM notes WHERE id='$note_id'";
$result = mysqli_query($link,$sql);

if(!$result){
    echo 'error';
}
?>