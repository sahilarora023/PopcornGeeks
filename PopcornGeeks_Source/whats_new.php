<?php
$apikey = 'kvemceqq4swkzk9am5w7h6p9';
 // make sure to url encode an query parameters

// construct the query with our apikey and the query we want to make

$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/lists/movies/in_theaters.json?page_limit=16&page=1&country=us&apikey='. $apikey;

// setup curl to make a call to the endpoint
$session = curl_init($endpoint);

// indicates that we want the response back
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// exec curl and get the data back
$data = curl_exec($session);

// remember to close the curl session once we are finished retrieveing the data
curl_close($session);
//print_r($data);
// decode the json data to make it easier to parse the php
$search_results = json_decode($data);
if ($search_results === NULL) die('Error parsing json');


// play with the data!
$movies = $search_results->movies;



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>What's New</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
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
            <a href="search.php" id="tabs" title="Find Geeks"><h4 id="tab_font">Find Geeks</h4></a>
            <a href="whats_new.php" id="tabs" title="What's New"><h4 id="tab_font" style="color: #f00">What's New</h4></a>
            <a href="about_us_in.php" id="tabs" title="About Us"><h4 id="tab_font">About Us</h4></a>
            <a href="logout.php" id="tabs" title="Sign Out"><h4 id="tab_font">Sign Out</h4></a>
        </div>
        <div id="main_body">
 <?php       echo '<h2 style="text-align:center;">Now in Theatres</h2>';
foreach ($movies as $movie) {
	
	echo '<div style="margin:15px;">';
	echo "<hr>";
	
echo '<div style="float:left; border:0.5px solid black;"><a href="'.$movie->links->alternate.'" target="_blank"><img src="'.$movie->posters->original.'"></a></div>';
	
  
  echo '<div style="float:left;margin-left:20px;"><a href="' . $movie->links->alternate . '" target="_blank">' . $movie->title . " (" . $movie->year . ")</a></div>";

 
	echo "<br>";
	
	
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Critics Score: ".$movie->ratings->critics_score;
	echo "<br>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Audience Score: ".$movie->ratings->audience_score;
	echo "<br>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "MPAA Rating : ".$movie->mpaa_rating;	
	
	echo "<br>";
		
	echo '</div>';

}
?>
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
