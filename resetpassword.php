<?php
session_start();

include('connection.php');

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Password Reset</title>
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
            <h1>Reset Password</h1>
            <div id="resetpasswordmessage"></div>


<?php
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please try again later.</div>';
    exit;
}

$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400;

$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

$sql = "SELECT user_id FROM forgotpassword WHERE (resetkey='$key' AND user_id='$user_id' AND time>'$time')";
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

echo "<form method='POST' id='resetpasswordform'>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='user_id' value='$user_id'>

<div class='form-group'>
<label for='password'>Enter your new password:</label>
<input type='password' placeholder='Enter Password' class='form-control' id='password' name='password'>
</div>

<div class='form-group'>
<label for='password2'>Re-enter Password:</label>
<input type='password' placeholder='Re-enter Password' class='form-control' id='password2' name='password2'>
</div>
<input type='submit' name='resetpassword' value='Reset Password' class='btn btn-success btn-lg'>
</form>";

?>



        </div>
    </div>
</div>

<script src="./jquery-3.4.1.min.js"></script>
<script src="./js/bootstrap.js"></script>

<script>

$('#resetpasswordform').submit(function(event){
    event.preventDefault();

    // will form an array with objects with name:htmlattrname and value:formvalue
    var datafromform = $(this).serializeArray();
    // const datatopost = new FormData(document.querySelector('#signupform'));
    
    const datatopost = {};
    datafromform.forEach(element => {
        datatopost[element['name']] = element['value'];
        // console.log(element['name'],element['value']);
    });
    var json = JSON.stringify(datatopost);
    // console.log(json);

    // console.log(datatopost);

    const url = './storeresetpassword.php';
    const request = new Request(url,{
        method:'POST',
        // headers:{
        //     'Content-Type':'text/html'
        // },
        body:json
    });
    
    fetch(request)
    .then(response => response.text())
    .then(data=>{
        $("#resetpasswordmessage").html(data);
    })

    .catch(()=>{
        $("#resetpasswordmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    })
    

    // $.ajax({
    //     url:"signup.php",
    //     type:"POST",
    //     data: datatopost,
    //     success: function(data){
    //         if(data){
    //             $("#signupmessage").html(data);
    //         }
    //     },
    //     error: function(){
    //         $("#signupmessage").html("<div class='alert alert-danger'>Something's fishy! Please try again later.</div>");
    //     }
    // });
});

</script>

</body>
</html>


<?php
mysqli_close($link);
?>