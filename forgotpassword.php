<?php

session_start();

include('connection.php');

$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email!</strong></p>';

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

if($formDetails->forgotemail === ""){
    $errors .= $missingEmail;
}else{
    $email = filter_var($formDetails->forgotemail, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}

if($errors){
    $resultMessage = '<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
    exit;
}

$email = mysqli_real_escape_string($link, $email);

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div>Oh no Error! :( </div>';
    exit;
}

$count = mysqli_num_rows($result);

if($count != 1){
    echo '<div class="alert alert-danger">These Email does not exist!</div>';
    exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];

$key = bin2hex(openssl_random_pseudo_bytes(16));

$time = time();
$status = 'pending';
$sql = "INSERT INTO forgotpassword (user_id,resetkey,time,status) VALUES ('$user_id','$key','$time','$status')";

$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div>Oh no Error! :( </div>';
    exit;
}

$message = "Please click on this link to Reset your password:\n\n";
$message .= "http://onlinenotesapp.epizy.com/resetpassword.php?user_id=$user_id&key=$key";

if(mail($email,'Reset your Password', $message, 'From:'.'medilipjain@gmail.com')){
    echo '<div class="alert alert-success">An email has been sent to '.$email.'. Please click on the link to reset your password.</div>';
}


?>