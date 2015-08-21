<?php
session_start();
include_once("php_includes/db_conx.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
$search_output = "";
if(isset($_POST['searchquery']) && $_POST['searchquery'] != ""){
	$searchquery = $_POST['searchquery'];
		$sqlCommand = "SELECT id, username AS username, avatar FROM users WHERE username LIKE '%$searchquery%'";  
        $query = mysqli_query($db_conx, $sqlCommand) or die(mysql_error());
	$count = mysqli_num_rows($query);
	if($count > 0){
		$search_output .= "<hr />$count results for <strong>$searchquery</strong><hr />";
		while($row = mysqli_fetch_array($query)){
	            $id = $row["id"];
		    $searchusername = $row["username"];
			$searchavatar = $row["avatar"];
		    if($searchavatar != ""){
			$searchpic = 'user/'.$searchusername.'/'.$searchavatar.'';
		} else {
			$searchpic = 'images/avatardefault.gif';
		}
		$search_output .= '<a href="user.php?u='.$searchusername.'"><img src="'.$searchpic.'" alt="'.$searchusername.'" title="'.$searchusername.'" class="searchpic"><br>'.$searchusername.'</a><hr />';
                } // close while
	} else {
		$search_output = "<hr />0 results for <strong>$searchquery</strong><hr />";
	}
}
?>
<html>
<head>
<title>Popcorngeeks - Find Geeks</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script>
            function blockSpecialChar(e) {
            var k = e.keyCode;
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8   || (k >= 48 && k <= 57) || k==13);
        }
			</script>
    <link rel="stylesheet" href="style.css">
	<style type="text/css">
    .searchpic{
        width: 75;
        height: 75;
        border: 10;
    }
	#search_header {
		font-weight: bold;
		font-size: 24px;
		text-align: center;
		margin-right: 100px;
		padding-top:40px;
	}
	#search_form {
		margin:0px auto;
		padding-left:40px;
		padding-bottom:40px
	}
	.form-control {
		width:300px;
		float:left;
		margin-right:20px;
	}
	.btn-primary {
		float:left;
	}
	#search_output {
		margin:0px auto;
		padding-left:40px;
		padding-bottom:40px;
		margin-left:20px;
	}
    </style>
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
            <a href="notifications.php" id="tabs" title="Newsfeed"><h4 id="tab_font">Newsfeed</h4></a>
            <a href="search.php" id="tabs" title="Find Geeks"><h4 id="tab_font"  style="color: #f00">Find Geeks</h4></a>
            <a href="whats_new.php" id="tabs" title="What's New"><h4 id="tab_font">What's New</h4></a>
            <a href="about_us_in.php" id="tabs" title="About Us"><h4 id="tab_font">About Us</h4></a>
            <a href="logout.php" id="tabs" title="Sign Out"><h4 id="tab_font">Sign Out</h4></a>
        </div>
        
        <!--Page Content-->
        <div id="main_body" style="min-height:500px;">
         	<h2 id="search_header">Search for Fellow Geeks!</h2><hr>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="search_form">
            Search: <br><br>
              <input name="searchquery" id="query" type="text" class="form-control" size="44" onkeypress="return blockSpecialChar(event)" maxlength="16" placeholder="Search by username"> 
            <input name="myBtn" type="submit" value="Search" class="btn btn-primary">
            <br />
            </form>
            <div id="search_output">
            <?php echo $search_output; ?>
            </div>
        </div>
        
        <!--Standard PopcornGeeks Footer-->
        <footer id="footer"><br>
        	|   &nbsp;&nbsp;
            <a href="user.php" id="footer_link">Profile</a>  &nbsp;&nbsp;  |   &nbsp;&nbsp;
            <a href="notifications.php" id="footer_link">Newsfeed</a> &nbsp;&nbsp;  |   &nbsp;&nbsp;
            <a href="search.php" id="footer_link">Find Geeks</a>  &nbsp;&nbsp;   |   &nbsp;&nbsp;
            <a href="whats_new.php" id="footer_link">What's New</a> &nbsp;&nbsp;  |    &nbsp;&nbsp;
            <a href="about_us_in.php" id="footer_link">About Us</a>  &nbsp;&nbsp;   |   &nbsp;&nbsp;
            <a href="logout.php" id="footer_link">Sign Out</a>  &nbsp;&nbsp;   |   &nbsp;&nbsp;
            <br><br>
            <p>Copyright &copy; 2014 - PopcornGeeks Inc. - All Rights Reserved</p>
        </footer>

</body>
</html>