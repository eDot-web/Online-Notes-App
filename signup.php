<?php
session_start();

include('connection.php');

// Possible Errors:
$missingUsername = '<p><strong>Please enter a username!</strong></p>';
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$missingPassword = '<p><strong>Please enter a Password</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email!</strong></p>';
$invalidPassword = '<p><strong>Your password should be atleast 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

if($formDetails->username === ""){
    $errors .= $missingUsername;
}else{
    $username = filter_var($formDetails->username, FILTER_SANITIZE_STRING);
}

if($formDetails->email === ""){
    $errors .= $missingEmail;
}else{
    $email = filter_var($formDetails->email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
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

$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
// $password = md5($password);
$password = hash('sha256',$password);

// Username Taken
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div>Oh no Error! :( </div>';
    exit;
}

if(mysqli_num_rows($result) != 0){
    echo '<div class="alert alert-danger">Username already Taken.</div>';
    exit;
}


// Email Exists
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div>Oh no Error! :( </div>';
    exit;
}

if(mysqli_num_rows($result) != 0){
    echo '<div class="alert alert-danger">That email is already Registered. Do you want to login in?</div>';
    exit;
}

// echo 'here';

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

$sql = "INSERT INTO users (username,email,password,activation) VALUES ('$username','$email','$password','$activationKey')";
$result = mysqli_query($link,$sql);

if(!$result){
    echo '<div class="alert alert-danger">Oops! Something\'s wrong, Please try again</div>';
    exit;
}

$message = "Please click on this link to activate your account:\n\n";
$message .= "http://onlinenotesapp.epizy.com/activate.php?email=". urlencode($email)."&key=$activationKey";

if(mail($email,'Confirm your Registration', $message, 'From:'.'medilipjain@gmail.com')){
    echo '<div class="alert alert-success">Thank you for Registrating. Confirmation email has been send, please activate your account.</div>';
}



mysqli_close($link);
?>