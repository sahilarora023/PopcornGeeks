<?php
session_start();
// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: user.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	include_once("php_includes/db_conx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<strong style="color:#009900;">' . $username . ' sounds cool</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
	    exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']);
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == "" || $g == "" || $c == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, email, password, gender, country, ip, signup, lastlogin, notescheck)       
		        VALUES('$u','$e','$p','$g','$c','$ip',now(),now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
		// Establish their row in the useroptions table
		$sql = "INSERT INTO useroptions (id, username, background) VALUES ('$uid','$u','original')";
		$query = mysqli_query($db_conx, $sql);
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		if (!file_exists("user/$u")) {
			mkdir("user/$u", 0755);
		}
		// Email the user their activation link
		$to = "$e";							 
		$from = "admin@popcorngeeks.com";
		$subject = 'PopcornGeeks Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>PopcornGeeks Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.popcorngeeks.com"><img src="http://www.popcorngeeks.com/images/logo.png" width="36" height="30" alt="popcorngeeks" style="border:none; float:left;"></a>PopcornGeeks Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.popcorngeeks.com/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
		$headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $message, $headers);
		echo "signup_success";
		exit();
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PopcornGeeks - Sign Up</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/ajax.js"></script>
        <script>
            function restrict(elem){
	            var tf = _(elem);
	            var rx = new RegExp;
	            if(elem == "email"){
		            rx = /[' "]/gi;
	            } else if(elem == "username"){
		            rx = /[^a-z0-9]/gi;
	            }
	            tf.value = tf.value.replace(rx, "");
            }
            function emptyElement(x){
	            _(x).innerHTML = "";
            }
            function checkusername(){
	            var u = _("username").value;
	            if(u != ""){
		            _("unamestatus").innerHTML = 'Checking ...';
		            var ajax = ajaxObj("POST", "signup.php");
                    ajax.onreadystatechange = function() {
	                    if(ajaxReturn(ajax) == true) {
	                        _("unamestatus").innerHTML = ajax.responseText;
	                    }
                    }
                    ajax.send("usernamecheck="+u);
	            }
            }
            function signup(){
	            var u = _("username").value;
	            var e = _("email").value;
	            var p1 = _("pass1").value;
	            var p2 = _("pass2").value;
	            var c = _("country").value;
	            var g = _("gender").value;
	            var status = _("status");
	            if(u == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == ""){
		            status.innerHTML = "Fill out all of the form data";
	            } else if(p1 != p2){
		            status.innerHTML = "Your password fields do not match";
	            } else if( _("terms").style.display == "none"){
		            status.innerHTML = "Please view the terms of use";
	            } else {
		            _("signupbtn").style.display = "none";
		            status.innerHTML = 'please wait ...';
		            var ajax = ajaxObj("POST", "signup.php");
                    ajax.onreadystatechange = function() {
	                    if(ajaxReturn(ajax) == true) {
	                        if(ajax.responseText != "signup_success"){
					            status.innerHTML = ajax.responseText;
					            _("signupbtn").style.display = "block";
				            } else {
					            window.scrollTo(0,0);
					            _("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process and activating your account. You will not be able to do anything on the website until you successfully activate your account.";
				            }
	                    }
                    }
                    ajax.send("u="+u+"&e="+e+"&p="+p1+"&c="+c+"&g="+g);
	            }
            }
            function openTerms(){
	            _("terms").style.display = "block";
	            emptyElement("status");
            }
            /* function addEvents(){
	            _("elemID").addEventListener("click", func, false);
            }
            window.onload = addEvents; */
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
            <div class="container_signup">
                <form name="signupform" id="signupform" onsubmit="return false;">
                    <h3 id="signup_heading">Sign Up Here!</h3>
                    <input id="username" type="text" class="form-control" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16" placeholder="Your Username" required>
                    <span id="unamestatus"></span><br>
                    <input id="email" class="form-control" type="text" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88" placeholder="Your Email Address" required><br>
                    <input id="pass1" class="form-control" type="password" onfocus="emptyElement('status')" maxlength="16" placeholder="Set Your Password" required><br>
                    <input id="pass2" class="form-control" type="password" onfocus="emptyElement('status')" maxlength="16" placeholder="Confirm Password" required><br>
                    <select id="gender" class="form-control" onfocus="emptyElement('status')" required>
                        <option value="">Gender...</option>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select><br>
                    <select id="country" class="form-control" onfocus="emptyElement('status')" required>
                        <?php include_once("php_includes/template_country_list.php"); ?>
                    </select><br>
                    <div>
                        <a href="#" onclick="return false" onmousedown="openTerms()" style="color:#b41919">
                        View the Terms Of Use
                        </a>
                    </div>
                    <div id="terms" style="display: none;">
                        <h4>PopcornGeeks Terms Of Use</h4>
                        <p id="termsofuse">1. This social networking website is for the purpose of discussing and sharing information related to movies only. Any form of abuse to other users will have your account terminated. Please help us maintain a friendly environment.</p>
                        <p id="termsofuse">2. This website is copyrighted by PopcornGeeks Inc. Any reproduction of the original material on this website for commercial use is strictly prohibited, and will have legal action taken against.</p>
                        <p id="termsofuse">3. Please do not give out or ask for personal information on this website. Any user asking for private and confidential information like credit card number, social security etc. must be reported at once.</p>
                    </div>
                    <br>
                    <button id="signupbtn" onclick="signup()" class="btn btn-primary">Create Account</button>
                    <span id="status"></span>
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