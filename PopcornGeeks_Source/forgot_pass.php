<?php
include_once("php_includes/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: user.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// AJAX CALLS THIS CODE TO EXECUTE
if(isset($_POST["e"])){
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$sql = "SELECT id, username FROM users WHERE email='$e' AND activated='1' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 0){
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
			$id = $row["id"];
			$u = $row["username"];
		}
		$emailcut = substr($e, 0, 4);
		$randNum = rand(10000,99999);
		$tempPass = "$emailcut$randNum";
		$sql = "UPDATE useroptions SET temp_pass='$tempPass' WHERE username='$u' LIMIT 1";
	    $query = mysqli_query($db_conx, $sql);
		$to = "$e";
		$from = "admin@popcorngeeks.com";
		$headers ="From: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$subject ="PopcornGeeks Password";
		$msg = '<h2>Hello '.$u.'</h2><p>This is an automated message from PopcornGeeks. If you did not recently initiate the Forgot Password process, please disregard this email.</p><p>You indicated that you forgot your login password. We can generate a new password for you to log in with.</p><p>After you click the link below your password to login will be:<br /><b>'.$tempPass.'</b></p><p><a href="http://www.popcorngeeks.com/forgot_pass.php?u='.$u.'&p='.$tempPass.'">Click here now to apply the new password shown below to your account</a></p><p>If you do not click the link in this email, no changes will be made to your account. In order to set your login password to the new one you must click the link above.</p>';
		if(mail($to,$subject,$msg,$headers)) {
			echo "success";
			exit();
		} else {
			echo "email_send_failed";
			exit();
		}
    } else {
        echo "no_exist";
    }
    exit();
}
?><?php
// EMAIL LINK CLICK CALLS THIS CODE TO EXECUTE
if(isset($_GET['u']) && isset($_GET['p'])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
	$temppasshash = preg_replace('#[^a-z0-9]#i', '', $_GET['p']);
	if(strlen($temppasshash) < 1){
		exit();
	}
	$sql = "SELECT id FROM useroptions WHERE username='$u' AND temp_pass='$temppasshash' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows == 0){
		header("location: message.php?msg=There is no match for that username with that temporary password in the system. We cannot proceed.");
    	exit();
	} else {
		$row = mysqli_fetch_row($query);
		$id = $row[0];
		$sql = "UPDATE users SET password='$temppasshash' WHERE id='$id' AND username='$u' LIMIT 1";
	    $query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE useroptions SET temp_pass='' WHERE username='$u' LIMIT 1";
	    $query = mysqli_query($db_conx, $sql);
	    header("location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PopcornGeeks - Forgot Password</title>
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
        function forgotpass(){
	        var e = _("email").value;
	        if(e == ""){
		        _("status").innerHTML = "Type in your email address";
	        } else {
		        _("forgotpassbtn").style.display = "none";
		        _("status").innerHTML = 'please wait ...';
		        var ajax = ajaxObj("POST", "forgot_pass.php");
                ajax.onreadystatechange = function() {
	                if(ajaxReturn(ajax) == true) {
				        var response = ajax.responseText;
				        if(response == "success"){
					        _("forgotpassform").innerHTML = '<h3>Step 2. Check your email inbox in a few minutes</h3><p>You can close this window or tab if you like.</p>';
				        } else if (response == "no_exist"){
					        _("status").innerHTML = "Sorry that email address is not in our system";
				        } else if(response == "email_send_failed"){
					        _("status").innerHTML = "Mail function failed to execute";
				        } else {
					        _("status").innerHTML = "An unknown error occurred";
				        }
	                }
                }
                ajax.send("e="+e);
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
            <div class="container_forgotpass">
            <form id="forgotpassform" onsubmit="return false;"><br><br>
                <h3 id="forgotpass_heading">Generate A New Password</h3><br>
                <div><p id="forgotpass_text">Step 1: Please Enter Your Email Address</p></div><br>
                <div class="form-group">
                    <div class="col-xs-10">
                        <input type="text" class="form-control" onfocus="_('status').innerHTML='';" maxlength="88" id="email" placeholder="Email ID" required>
                    </div>
                </div><br><br><br>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <button type="submit" class="btn btn-primary" id="forgotpassbtn" onclick="forgotpass()">Generate New Password</button>
                    </div>
                </div>
                <p id="status"></p>
            </form>
            </div>
        </div>

        <!--Standard PopcornGeeks Footer-->
        <footer id="footer"><br>
            <a href="about_us.php" id="footer_link">About Us</a>
            
            <p>Copyright &copy; 2014 - PopcornGeeks Inc. - All Rights Reserved</p>
        </footer>

    </body>
</html>