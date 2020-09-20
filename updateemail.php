<?php
session_start();
include('connection.php');

$user_id = $_SESSION['user_id'];

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

$newemail = $formDetails->email;

$sql = "SELECT * FROM users WHERE email='$newemail'";
$result = mysqli_query($link,$sql);
$count = mysqli_num_rows($result);
if($count>0){
    echo "<div>This email is already registered</div>";
    exit;
}

$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result =mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $email = $row['email'];
}else{
    echo "There was an error retrieving the details";
    exit;
}

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

$sql = "UPDATE users SET activation2='$activationKey' WHERE user_id='$user_id'";
$result = mysqli_query($link,$sql);

if(!$result){
    echo '<div class="alert alert-danger">Oops! Something\'s wrong, Please try again</div>';
    exit;
}else{
   $message = "Please click on this link to activate your account:\n\n";
    $message .= "http://onlinenotesapp.epizy.com/activateupdatedemail.php?email=". urlencode($email)."&newemail=". urlencode($newemail)."&key=$activationKey";

    if(mail($newemail,'Email Updation', $message, 'From:'.'medilipjain@gmail.com')){
        echo '<div class="alert alert-success">An email has been sent to $newemail. Please Click on the link to activate your account</div>';
    } 
}
?>