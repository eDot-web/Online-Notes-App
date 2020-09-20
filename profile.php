<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location: index.php');
}

include('connection.php');
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result =mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username = $row['username'];
    $email = $row['email'];
}else{
    echo "There was an error retrieving the details";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
</head>
<body>
    <nav role="navigation" class="navbar navbar-custom fixed-top navbar-expand-md">
        <div class="container-fluid">
          
            <a class="navbar-brand">Online Notes</a>
            <button type="button" class="navbar-toggler" data-target="#navbarCollapse" data-toggle="collapse">
                <span class="navbar-toggler-icon" aria-label="Toggle Button">...</span>
            </button>
          

            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item active"><a class="nav-link" href="#">Profile</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Help</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="mainpageloggedin.php">My Notes</a></a></li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Logged in as <b><?php echo $username;?></b></a></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?logout=1">Log Out</a></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div class="col-md-offset-3 col-md-6" style="margin: auto;">
                <h2>General Account Settings:</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tr data-target="#updateusername" data-toggle="modal">
                            <td>Username</td>
                            <td><?php echo $username;?></td>
                        </tr>
                        <tr>
                            <td data-target="#updateemail" data-toggle="modal">Email</td>
                            <td><?php echo $email;?></td>
                        </tr>
                        <tr>
                            <td data-target="#updatepassword" data-toggle="modal">Password</td>
                            <td>hidden</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Update Username -->
    <form method="post" id="updateusernameform">
        <div class="modal" tabindex="-1" role="dialog" id="updateusername">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Username:</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <!-- SignUp Error or Success -->
                    <div id="updateusernamemessage"></div>

                    <div class="form-group">
                        <label for="username" class="sr-only">Username:</label>
                        <input class="form-control" type="text" id="username" name="username" value="<?php echo $username;?>" maxlength="30">
                    </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn green" id="submit" name="submit" value="Submit">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#updateusername">Cancel</button>
                </div>
              </div>
            </div>
          </div>
    </form>

    <!-- Update Email -->
    <form method="post" id="updateemailform">
        <div class="modal" tabindex="-1" role="dialog" id="updateemail">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Email:</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <!-- Edit Email Error or Success -->
                    <div id="updateemailmessage"></div>

                    <div class="form-group">
                        <label for="email">Enter new email:</label>
                        <input class="form-control" type="email" id="email" name="email" value="<?php echo $email;?>" maxlength="30">
                    </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn green" id="submit" name="submit" value="Submit">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#updateemail">Cancel</button>
                </div>
              </div>
            </div>
          </div>
    </form>

    <!-- Update Password -->
    <form method="post" id="updatepasswordform">
        <div class="modal" tabindex="-1" role="dialog" id="updatepassword">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Enter Current and New Password:</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <!-- Login Error or Success -->
                    <div id="updatepasswordmessage"></div>

                    <div class="form-group">
                        <label for="currentpassword" class="sr-only">Current Password:</label>
                        <input class="form-control" type="password" id="currentpassword" name="currentpassword" placeholder="Your Current Password" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Choose a Password:</label>
                        <input class="form-control" type="password" id="password" name="password" placeholder="Choose a password" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="password2" class="sr-only">Confirm Password:</label>
                        <input class="form-control" type="password" id="password2" name="password2" placeholder="Confirm password" maxlength="30">
                    </div>

                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn green" id="submit" name="submit" value="Submit">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#updatepassword">Cancel</button>
                </div>
              </div>
            </div>
          </div>
    </form>

    <div class="footer">
        <div class="container">
            <p>Developed by Dilip Jain. Copyright &copy;2020-<?php $today = date("Y"); echo $today?></p>
        </div>
    </div>
<script src="./jquery-3.4.1.min.js"></script>
<script src="./js/bootstrap.js"></script>
<script src="./profile.js"></script>
</body>
</html>