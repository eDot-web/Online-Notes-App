<?php
session_start();
include('connection.php');
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>New Email Activation</title>
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
    <style>
        h1{
            color:purple;
        }
        .msgbox{
            margin:auto;
            border: 1px solid purple;
            margin-top: 50px;
            border-radius: 15px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 msgbox">
            <h1>Email Updation</h1>


<?php
if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the activation you received by email.</div>';
    exit;
}

$email = $_GET['email'];
$newemail = $_GET['newemail'];
$key = $_GET['key'];

$email = mysqli_real_escape_string($link, $email);
$newemail = mysqli_real_escape_string($link, $newemail);
$key = mysqli_real_escape_string($link, $key);

$sql = "UPDATE users SET email='$newemail', activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";

$result = mysqli_query($link,$sql);

if(mysqli_affected_rows($link) === 1){
    session_destroy();
    setcookie('rememberme',"",time()-3600);
    echo '<div class="alert alert-sucess">Your email has been updated</div>';
    echo '<a href="index.php" type="button" class="btn-lg btn-success">Login</a>';
}else{
    echo '<div class="alert alert-danger">Your email could not be activated.</div>';
}
?>

        </div>
    </div>
</div>

<script src="./jquery-3.4.1.min.js"></script>
<script src="./js/bootstrap.js"></script>
</body>
</html>


<?php
mysqli_close($link);
?>