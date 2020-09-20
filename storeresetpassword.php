<?php
session_start();

include('connection.php');


$missingPassword = '<p><strong>Please enter a Password</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
$invalidPassword = '<p><strong>Your password should be atleast 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

if(($formDetails->user_id === '') || ($formDetails->key === '')){
    echo '<div class="alert alert-danger">There was an error. Please try again later.</div>';
    exit;
}

$user_id = $formDetails->user_id;
$key = $formDetails->key;
$time = time() - 86400;

$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

$sql = "SELECT user_id FROM forgotpassword WHERE (resetkey='$key' AND user_id='$user_id' AND time>'$time' AND status='pending')";
$result = mysqli_query($link,$sql);

if(!$result){
    echo '<div>Oh no Error! :( </div>';
    exit;
}

$count = mysqli_num_rows($result);

if($count !== 1){
    echo '<div class="alert alert-danger">Oops! Please try again!</div>';
    exit;
}

if($formDetails->password === ""){
    $errors .= $missingPassword;
}elseif(!((strlen($formDetails->password)>6) and preg_match('/[A-Z]/',($formDetails->password)) and preg_match('/[0-9]/',($formDetails->password)))){
    $errors .=$invalidPassword;
}else{
    $password = filter_var($formDetails->password2, FILTER_SANITIZE_STRING);
    if($formDetails->password2 === ""){
        $errors .= $missingPassword2;
    }else{
        $password2 = filter_var($formDetails->password2, FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $errors .=$differentPassword;
        }
    }
}

if($errors){
    $resultMessage = '<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
    exit;
}

$password = mysqli_real_escape_string($link, $password);
// $password = md5($password);
$password = hash('sha256',$password);

$sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";

$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div class="alert alert-danger">There was a problem updating the Password:( </div>';
    exit;
}

$sql = "UPDATE forgotpassword SET status='used' WHERE (user_id='$user_id' AND resetkey='$key')";

$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div class="alert alert-danger">There was a problem updating the Password:( </div>';
}else{
    echo '<div class="alert alert-success">Your password was updated successfully!  <a href="index.php">Login</a></div>';
}


?>