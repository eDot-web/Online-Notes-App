<?php
session_start();
include('connection.php');

$id = $_SESSION['user_id'];

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

$username = $formDetails->username;

$sql = "UPDATE users SET username='$username' WHERE user_id='$id'";
$result = mysqli_query($link,$sql);

if(!$result){
    echo "<div class='alert alert-danger'>There was an error updating your username</div>";
    exit;
}



?>