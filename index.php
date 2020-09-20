<?php
session_start();
include('connection.php');

include('rememberme.php');

include('logout.php');
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
    <nav role="navigation" class="navbar navbar-toggleable-md navbar-custom fixed-top navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Online Notes</a>
            <button type="button" class="navbar-toggler ml-auto" style="margin-left: auto;" data-target="#navbarCollapse" data-toggle="collapse">
              <span class="navbar-toggler-icon" aria-label="Toggle Button">...</span>
            </button>

            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item active"><a class="nav-link" href="#">Home</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Help</a></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></a></li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="#loginModal" data-toggle="modal">Login</a></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron" id="myContainer" data-target="#signupModal" data-toggle="modal">
        <h1>Online Notes App</h1>
        <p>Your Notes with You wherever you go.</p>
        <p>Easy to use, protects all your notes!</p>
        <button type="button" class="btn btn-lg green signup">Sign up-It's Free</button>
    </div>

    <form method="post" id="signupform">
        <div class="modal" tabindex="-1" role="dialog" id="signupModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Sign Up today and Start using our Online Notes App!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <!-- SignUp Error or Success -->
                    <div id="signupmessage"></div>

                    <div class="form-group">
                        <label for="username" class="sr-only">Username:</label>
                        <input class="form-control" type="text" id="username" name="username" placeholder="Username" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email:</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Email Address" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Choose a Password:</label>
                        <input class="form-control" type="password" id="password" name="password" placeholder="Choose a password" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="password2" class="sr-only">Confirm Password:</label>
                        <input class="form-control" type="password" id="password2" name="password2" placeholder="Confirm Password" maxlength="30">
                    </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn green" id="signup" name="signup" value="Sign Up">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" data-target="#signupModal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
    </form>

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
                    <div id="loginmessage"></div>

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

                        <a class="float-right" style="cursor: pointer;" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">Forgot Password?</a>
                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" data-target="#loginModal, #signupModal" data-toggle="modal">Register</button>
                  <input type="submit" class="btn green" id="login" name="login" value="Login">
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
                    <div id="forgotpasswordmessage"></div>

                    <div class="form-group">
                        <label for="forgotemail" class="sr-only">Email:</label>
                        <input class="form-control" type="email" id="forgotemail" name="forgotemail" placeholder="Email" maxlength="30">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                  <input type="submit" class="btn green" value="Sumbit" name="fsubmit" id="fsubmit">
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
<script src="./index.js"></script>
</body>
</html>