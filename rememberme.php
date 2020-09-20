<?php
session_start();
include('connection.php');

if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
    // array_key_exists
    list($auth1,$auth2) = explode(',',$_COOKIE['rememberme']);
    $auth2 = hex2bin($auth2);
    $f2auth2 = hash('sha256', $auth2);

    $sql = "SELECT * FROM rememberme WHERE auth1='$auth1'";
    $result = mysqli_query($link,$sql);
            if(!$result){
                echo '<div class="alert alert-danger">Oops! Some Problem :(</div>';
                exit;
            }
            $count = mysqli_num_rows($result);

            if($count !== 1){
                echo '<div class="alert alert-danger">Oops! Some Problem Remember me process failed!</div>';
                exit;
            }
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

            if(!hash_equals($row['f2auth2'],$f2auth2)){
                echo '<div class="alert alert-danger">Oops! Some Problem Remember me process failed :(</div>';
            }else{
                $_SESSION['user_id'] = $row['user_id'];

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

                $_SESSION['user_id'] = $row['user_id'];
                header("location:mainpageloggedin");
            }
}
// else{
//     echo '<div class="alert alert-danger" style="margin-top: 50px;">User id:'.$_SESSION['user_id'].'</div>';
//     echo '<div class="alert alert-danger">Cookie Value:'.$_COOKIE['rememberme'].'</div>';
// }

?>