<?php
session_start();
include('connection.php');

$id = $_SESSION['user_id'];

$missingCurrentPassword = '<p><strong>Please enter your current Password</strong></p>';
$incorrectCurrentPassword = '<p><strong>Please enter correct current Password</strong></p>';
$missingPassword = '<p><strong>Please enter a Password</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
$invalidPassword = '<p><strong>Your password should be atleast 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';

$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

if($formDetails->currentpassword === ""){
    $errors .= $missingCurrentPassword;
}else{
    $currentpassword = $formDetails->currentpassword;

    $currentpassword = mysqli_real_escape_string($link, $currentpassword);
    // $password = md5($password);
    $currentpassword = hash('sha256',$currentpassword);

    $sql = "SELECT password FROM users WHERE user_id = '$id'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);

    if($count != 1){
        echo '<div>Oh no problems! :( </div>';
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($currentpassword != $row['password']){
            $errors.= $incorrectCurrentPassword;
        }
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
}else{
    $password = mysqli_real_escape_string($link, $password);
    // $password = md5($password);
    $password = hash('sha256',$password);

    $sql = "UPDATE users SET password='$password' WHERE user_id='$id'";
    $result = mysqli_query($link,$sql);

    if(!$result){
        echo "<div class='alert alert-danger'>There was an error updating your password</div>";
    }else{
        echo "<div class='alert alert-success'>Your password was updated successfully!</div>";
    }
}
// // Username Taken
// $sql = "SELECT * FROM users WHERE username = '$username'";
// $result = mysqli_query($link, $sql);

// if(!$result){
//     echo '<div>Oh no Error! :( </div>';
//     exit;
// }



// $sql = "UPDATE users SET username='$username' WHERE user_id='$id'";
// 

?>