<?php
require '../config/functions.php';
require '../config/AuthMeController.php';
require '../config/Sha256.php';
$authme_controller = new Sha256();
session_start();
if ($authme_controller->is_session()) {
    header('LOCATION: /dashboard/?login=loginSuccess');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>OpLuckyCraft.it | Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form method="post" enctype="application/x-www-form-urlencoded" name="myform" id="myform"
                  class="login100-form validate-form"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $action = $_POST["action"];
                    $user = $_POST["username"];
                    $pass = $_POST["password"];

                    $was_successful = false;
                    if ($action && $user && $pass) {
                        if ($action === 'Login') {
                            $was_successful = process_login($user, $pass, $authme_controller);
                            if ($was_successful === true) {
                                $_SESSION["id"] = $user;
                            }
                        }
                    }
                }

                ?>

                <span class="login100-form-title p-b-48">
						<img src="../img/logo.png">
                </span>
                <span class="login100-form-title p-b-26">
						Welcome
				</span>

                <div class="wrap-input100 validate-input" data-validate="Enter username">
                    <input class="input100" type="username" name="username" minlength="1">
                    <span class="focus-input100" data-placeholder="Username"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                    <input class="input100" type="password" name="password">
                    <span class="focus-input100" data-placeholder="Password"></span>
                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" form="myform" name="action" class="login100-form-btn" value="Login">
                            Login
                        </button>
                    </div>
                </div>
                <div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

                    <a class="txt2" href="#">
                        Sign Up
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

</body>
</html>