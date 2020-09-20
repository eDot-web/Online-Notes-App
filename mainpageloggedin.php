<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Notes App</title>
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
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Help</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></a></li>
                    <li class="nav-item active"><a class="nav-link" href="#">My Notes</a></a></li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Logged in as <b><?php echo $_SESSION['username']?></b></a></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?logout=1">Log Out</a></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top:120px;">
      <!-- Alert Message -->
      <div class="alert alert-danger collapse" id="alert">
        <a class="close" data-dismiss="#alert">&times;</a>
        <p id="alertContent"></p>
      </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6" style="margin:0 auto;">
                <div class="buttons">
                  <button id="addNote" type="button" class="btn btn-info">Add Note</button>
                  <button id="allNotes" type="button" class="btn btn-info">All Notes</button>

                  <button id="edit" type="button" class="btn btn-info float-right">Edit</button>
                  <button id="done" type="button" class="btn green float-right">Done</button>
                </div>

                <!-- Text Area -->
                <div id="notepad">
                  <textarea rows="10"></textarea>
                </div>

                <!-- Existing Notes -->
                <div id="notes" class="notes">
                  <!-- AJAX to PHP -->
                </div>

            </div>
        </div>
    </div>

    <form method="post" id="loginform">
        <div class="modal" tabindex="-1" role="dialog" id="loginModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Login:</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <!-- Login Error or Success -->
                    <div class="loginmessage"></div>

                    <div class="form-group">
                        <label for="loginemail" class="sr-only">Email:</label>
                        <input class="form-control" type="email" id="loginemail" name="loginemail" placeholder="Email" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="loginpassword" class="sr-only">Password:</label>
                        <input class="form-control" type="password" id="loginpassword" name="loginpassword" placeholder="Choose a password" maxlength="30">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rememberme" id="rememberme">Remember Me
                        </label>

                        <a class="ml-auto" style="cursor: pointer;" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">Forgot Password?</a>
                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" data-target="#loginModal, #signupModal" data-toggle="modal">Register</button>
                  <button type="button" class="btn green" data-dismiss="modal" name="login" value="login" data-dismiss="modal" data-target="#loginModal">Login</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#loginModal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
    </form>

    <form method="post" id="forgotpasswordform">
        <div class="modal" tabindex="-1" role="dialog" id="forgotpasswordModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Forgot Password? Enter Your Email Address:</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <!-- Forgot Password Error or Success -->
                    <div class="loginmessage"></div>

                    <div class="form-group">
                        <label for="signinemail" class="sr-only">Email:</label>
                        <input class="form-control" type="email" id="signinemail" name="signinemail" placeholder="Email" maxlength="30">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                  <button type="button" class="btn green" data-dismiss="modal" name="submit" value="submit">Sumbit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#forgotpasswordModal">Cancel</button>
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
<script src="./mynotes.js"></script>
</body>
</html>