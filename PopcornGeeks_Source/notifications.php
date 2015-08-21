<?php
include_once("php_includes/check_login_status.php");
// If the page requestor is not logged in, usher them away
if($user_ok != true || $log_username == ""){
	header("location: http://www.popcorngeeks.com");
    exit();
}
$notification_list = "";
$sql = "SELECT * FROM notifications WHERE username LIKE BINARY '$log_username' ORDER BY date_time DESC";
$query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
	$notification_list = "You do not have any notifications";
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$noteid = $row["id"];
		$initiator = $row["initiator"];
		$app = $row["app"];
		$note = $row["note"];
		$date_time = $row["date_time"];
		$date_time = strftime("%b %d, %Y", strtotime($date_time));
		$notification_list .= "<p><a href='user.php?u=$initiator'>$initiator</a> | $app<br />$note</p>";
	}
}
mysqli_query($db_conx, "UPDATE users SET notescheck=now() WHERE username='$log_username' LIMIT 1");
?><?php
$friend_requests = "";
$sql = "SELECT * FROM friends WHERE user2='$log_username' AND accepted='0' ORDER BY datemade ASC";
$query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
	$friend_requests = 'No friend requests';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$reqID = $row["id"];
		$user1 = $row["user1"];
		$datemade = $row["datemade"];
		$datemade = strftime("%B %d", strtotime($datemade));
		$thumbquery = mysqli_query($db_conx, "SELECT avatar FROM users WHERE username='$user1' LIMIT 1");
		$thumbrow = mysqli_fetch_row($thumbquery);
		$user1avatar = $thumbrow[0];
		$user1pic = '<img src="user/'.$user1.'/'.$user1avatar.'" alt="'.$user1.'" class="user_pic">';
		if($user1avatar == NULL){
			$user1pic = '<img src="images/avatardefault.gif" alt="'.$user1.'" class="user_pic">';
		}
		$friend_requests .= '<div id="friendreq_'.$reqID.'" class="friendrequests">';
		$friend_requests .= '<a href="user.php?u='.$user1.'">'.$user1pic.'</a>';
		$friend_requests .= '<div class="user_info" id="user_info_'.$reqID.'">'.$datemade.' <a href="user.php?u='.$user1.'">'.$user1.'</a> requests friendship<br /><br />';
		$friend_requests .= '<button onclick="friendReqHandler(\'accept\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\')">accept</button> or ';
		$friend_requests .= '<button onclick="friendReqHandler(\'reject\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\')">reject</button>';
		$friend_requests .= '</div>';
		$friend_requests .= '</div>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PopcornGeeks - Notifications & Newsfeed</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="style.css">
		<style type="text/css">
        div#notesBox{float:left; width:430px; min-height: 300px; margin-right:60px; padding:30px; margin:0px auto; margin-left:40px; margin-top:20px}
        div#friendReqBox{float:left; width:430px; min-height: 300px; margin-right:60px; padding:30px; margin:0px auto;margin-left:60px; margin-top:20px}
        div.friendrequests{height:74px; border-bottom:#CCC 1px solid; margin-bottom:8px;}
        img.user_pic{float:left; width:68px; height:68px; margin-right:8px;}
        div.user_info{float:left; font-size:14px;}
        </style>
		<script src="js/main.js"></script>
        <script src="js/ajax.js"></script>
        <script type="text/javascript">
        function friendReqHandler(action,reqid,user1,elem){
            var conf = confirm("Press OK to '"+action+"' this friend request.");
            if(conf != true){
                return false;
            }
            _(elem).innerHTML = "processing ...";
            var ajax = ajaxObj("POST", "php_parsers/friend_system.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText == "accept_ok"){
                        _(elem).innerHTML = "<b>Request Accepted!</b><br />You are now friends";
                    } else if(ajax.responseText == "reject_ok"){
                        _(elem).innerHTML = "<b>Request Rejected</b><br />You chose to reject friendship with this user";
                    } else {
                        _(elem).innerHTML = ajax.responseText;
                    }
                }
            }
            ajax.send("action="+action+"&reqid="+reqid+"&user1="+user1);
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
            
            <!--PopcornGeeks Navbar-->
            <div id="filmstrip">
                <a href="user.php" id="tabs" title="Profile"><h4 id="tab_font">Profile</h4></a> 
                <a href="notifications.php" id="tabs" title="Newsfeed"><h4 id="tab_font" style="color: #f00">Newsfeed</h4></a>
                <a href="search.php" id="tabs" title="Find Geeks"><h4 id="tab_font">Find Geeks</h4></a>
                <a href="whats_new.php" id="tabs" title="What's New"><h4 id="tab_font">What's New</h4></a>
                <a href="about_us_in.php" id="tabs" title="About Us"><h4 id="tab_font">About Us</h4></a>
                <a href="logout.php" id="tabs" title="Sign Out"><h4 id="tab_font">Sign Out</h4></a>
            </div>
            
            <div id="main_body" style="min-height:500px;">
              <!-- START Page Content -->
              <div id="notesBox"><h2>Notifications</h2><hr><?php echo $notification_list; ?></div>
              <div id="friendReqBox"><h2>Friend Requests</h2><hr><?php echo $friend_requests; ?></div>
              <div style="clear:left;"></div>
              <!-- END Page Content -->
            </div>
            
        <!--Standard PopcornGeeks Footer-->
        <footer id="footer"><br>
            <a href="user.php" id="footer_link">Profile</a>  &nbsp;&nbsp;  |   &nbsp;&nbsp;
            <a href="notifications.php" id="footer_link">Newsfeed</a> &nbsp;&nbsp;  |   &nbsp;&nbsp;
            <a href="search.php" id="footer_link">Find Geeks</a>  &nbsp;&nbsp;   |   &nbsp;&nbsp;
            <a href="whats_new.php" id="footer_link">What's New</a> &nbsp;&nbsp;  |    &nbsp;&nbsp;
            <a href="about_us_in.php" id="footer_link">About Us</a>  &nbsp;&nbsp;   |   &nbsp;&nbsp;
            <a href="logout.php" id="footer_link">Logout</a>  &nbsp;&nbsp;   |   &nbsp;&nbsp;
            <br><br>
            <p>Copyright &copy; 2014 - PopcornGeeks Inc. - All Rights Reserved</p>
        </footer>
</body>
</html>