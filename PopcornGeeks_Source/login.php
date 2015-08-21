<?php
include_once("php_includes/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: user.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($e == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PopcornGeeks - Login</title>
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/ajax.js"></script>
        <script>
            function emptyElement(x){
	            _(x).innerHTML = "";
            }
            function login(){
	            var e = _("email").value;
	            var p = _("password").value;
	            if(e == "" || p == ""){
		            _("status").innerHTML = "Fill out all of the form data";
	            } else {
		            _("loginbtn").style.display = "none";
		            _("status").innerHTML = 'please wait ...';
		            var ajax = ajaxObj("POST", "login.php");
                    ajax.onreadystatechange = function() {
	                    if(ajaxReturn(ajax) == true) {
	                        if(ajax.responseText == "login_failed"){
					            _("status").innerHTML = "Login unsuccessful, please try again.";
					            _("loginbtn").style.display = "block";
				            } else {
					            window.location = "user.php?u="+ajax.responseText;
				            }
	                    }
                    }
                    ajax.send("e="+e+"&p="+p);
	            }
            }
        </script>
    </head>

    <body>
        <!--Standard PopcornGeeks Header-->
        <header id="header">
            <div id="logo">
                <a href="index.php"><img src="images/logo.png" alt="font" title="Home"></a>
            </div>
            <div id="headerText">
                <img src="images/font.png" alt="font">
            </div>
        </header>

        <!--Page Content-->
        <div id="main_body">
          <div class="container_login">
            <!-- LOGIN FORM -->
            <form id="loginform" class="loginform" onsubmit="return false;"><br><br>
                <h3 id="login_heading">Log In Here!</h3><br>
                <div class="form-group">
                    <div class="col-xs-10">
                        <input type="text" class="form-control" onfocus="emptyElement('status')" maxlength="88" id="email" placeholder="Email ID" required>
                    </div>
                </div><br><br><br>
                <div class="form-group">
                    <div class="col-xs-10">
                        <input type="password" class="form-control" onfocus="emptyElement('status')" maxlength="100" id="password" placeholder="Password" required>
                    </div>
                </div><br><br><br>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <button type="submit" class="btn btn-primary" id="loginbtn" onclick="login()">Login</button>
                    </div>
                </div><br><br>
                <p id="status"></p><br>
                        <button type="button" class="btn btn-warning" id="forgotpass" onclick="window.location.href='forgot_pass.php'">Forgot Your Password?</button>
            </form>
            </div>
        </div>

        <!--PopcornGeeks Footer-->
        <footer id="footer"><br>
            <a href="about_us.php" id="footer_link">About Us</a> 
            <br><br>
            <p>Copyright &copy; 2014 - PopcornGeeks Inc. - All Rights Reserved</p>
        </footer>

    </body>
</html>