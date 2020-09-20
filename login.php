<?php
session_start();
include("connection.php");

$missingEmail = '<p><strong>Please Enter your Email Address</strong></p>';
$missingPassword = '<p><strong>Please Enter your Password</strong></p>';

// Read Client Input:
$str_json = file_get_contents('php://input');
$formDetails = json_decode($str_json);

// print_r($formDetails);

if($formDetails->loginemail === ""){
    $errors .= $missingEmail;
}else{
    $email = filter_var($formDetails->loginemail, FILTER_SANITIZE_EMAIL);
}

if($formDetails->loginpassword === ""){
    $errors .= $missingPassword;
}else{
    $password = filter_var($formDetails->loginpassword, FILTER_SANITIZE_STRING);
}

if($errors){
    $resultMessage = '<div class="alert alert-danger">'.$errors.'</div>';
    echo $resultMessage;
}else{
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);

    $password = hash('sha256',$password);

        
    $sql = "SELECT * FROM users WHERE (email='$email' AND password='$password' AND activation = 'activated')";

    $result = mysqli_query($link, $sql);

    if(!$result){
        echo '<div>Oh no Error! :( </div>';
        exit;
    }

    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo "<div class='alert alert-danger'><strong>Wrong Username or Password</strong></div>";
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['user_id']=$row['user_id'];
        $_SESSION['username']=$row['username'];
        $_SESSION['email']=$row['email'];


        if($formDetails->rememberme === 'on'){
            $auth1 = bin2hex(openssl_random_pseudo_bytes(10));
            $auth2 = openssl_random_pseudo_bytes(20);

            function f1($a,$b){
                $c = $a.",".bin2hex($b);
                return $c;
            }

            function f2($b){
                $a = hash('sha256',$b);
                return $a;
            }

            $f2auth2 = f2($auth2);

            $user_id = $_SESSION['user_id'];

            $expiry = date('Y-m-d H:i:s', time()+ 1296000);

            $cookieValue = f1($auth1,$auth2);

            setcookie("rememberme",$cookieValue,time()+ 1296000);

            $sql = "INSERT INTO rememberme (auth1,f2auth2,user_id,expires) VALUES ('$auth1','$f2auth2','$user_id','$expiry')";

            $result = mysqli_query($link,$sql);
            if(!$result){
                echo '<div class="alert alert-danger">Oops! We might forget you!</div>';
                exit;
            }

            echo "success";

        }else{
            echo "success";
        }

    }
}


?>