<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>About PopcornGeeks</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript">
            $(document).ready(function(){
	            $(".annie").click(function(){
		            $("#annieModal").modal('show');
	            });
            });
            $(document).ready(function(){
	            $(".sahil").click(function(){
		            $("#sahilModal").modal('show');
	            });
            });
            $(document).ready(function(){
	            $(".manav").click(function(){
		            $("#manavModal").modal('show');
	            });
            });
            $(document).ready(function(){
	            $(".mukhtar").click(function(){
		            $("#mukhtarModal").modal('show');
	            });
            });
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
            <aside class="pull-left" style="padding-left: 10px; padding-top: 30px;">
                <div class="panel panel-primary" style="width: 240px">
                    <div class="panel-heading">
                        <h3 class="panel-title">Check out what's happening in the movie world!</h3>
                    </div>
                    <div class="panel-body"><a href="signup.php">Sign Up!</a>  
                    </div>
                </div>
            </aside>
            <div style="width: 500px; margin: 0 auto; padding-top: 10px; padding-left: 30px; margin-left:300px">
                <h2 style="font-weight: bold; text-align: center">About PopcornGeeks</h2><br>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">&bull; &nbsp; 
                                <strong>What is popcorngeeks.com all about?</strong></a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <em>A miniature social networking website where you can discuss all about your favorite movies with other movie buffs<br>
                                Share movie links, make lists of your top movies, watch trailers of upcoming movies..and many more!!
                                </em>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">&bull; &nbsp; 
                                <strong>Who is a PopcornGeek?</strong></a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <em>If you are an ardent movie-lover, PopcornGeeks is meant for you!<br>
                                Becoming a PopcornGeek is easy! Just sign up for free and connect with other movie lovers<br>
                                </em>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">&bull; &nbsp; 
                                <strong>Who started PopcornGeeks?</strong></a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <em>PopcornGeeks is the brainchild of four bright, ambitious computer engineering grad students from San Jose State University<br>
                                <br>Initially started as a class project, we aim to develop this website as an interesting watering hole for movie enthusiasts.</em> </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="annieModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button><hr>
                            <aside class="pull-left"><img src="images/annie.jpg" alt="annie" style="height: 100px; width: 100px; padding-right: 10px"></aside>
                            <h4 class="modal-title">Annie Niangneihoi</h4>
                            <h5>MS - Computer Engineering <br><br>Front End (Web UI/Mobile Application) Developer</h5>
                            <h6>San Jose State University</h6>
                        </div><br>
                        <p style="padding-left: 20px">Annie is a budding front end developer who loves to design and develop UI for websites and mobile apps.
                        <br>The PopcornGeeks visualization, themes and user interface were all developed by her, using HTML5, Bootstrap, CSS3, jQuery and JavaScript.
                        <a href="http://www.linkedin.com/pub/annie-niangneihoi-suantak/22/32b/b53/" target="_blank">
                        <br>LinkedIn Profile</a></p>
                    </div>
                </div>
            </div>

            <div id="sahilModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button><hr>
                            <aside class="pull-left"><img src="images/sahil.jpg" alt="sahil" style="height: 100px; width: 100px; padding-right: 10px"></aside>
                            <h4 class="modal-title">Sahil Arora</h4>
                            <h5>MS - Computer Engineering <br><br>Mobile Application Developer (iOS)</h5>
                            <h6>San Jose State University</h6>
                        </div><br>
                        <p style="padding-left: 20px">Sahil is an ambitious mobile application enthusiast who loves developing on the iOS platform.
                        <br>He has developed the PopcornGeeks website backend as well and synchronized the front end using PHP, AJAX and JavaScript.
                        <a href="http://www.linkedin.com/pub/sahil-arora/77/aaa/232" target="_blank">
                        <br>LinkedIn Profile</a></p>
                    </div>
                </div>
            </div>

            <div id="manavModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button><hr>
                            <aside class="pull-left"><img src="images/manav.jpg" alt="manav" style="height: 100px; width: 100px; padding-right: 10px"></aside>
                            <h4 class="modal-title">Manav Pavitra Singh</h4>
                            <h5>MS - Software Engineering <br><br>(Cloud technologies and Virtualization)</h5>
                            <h6>San Jose State University</h6>
                        </div><br>
                        <p style="padding-left: 20px">Manav is...
                        <br>He worked on integrating the PopcornGeeks website with the Rotten Tomatoes API, thus implementing a RESTful API to synchronize the website with.
                        <a href="http://www.linkedin.com/pub/manav-singh/72/b19/2b1" target="_blank">
                        <br>LinkedIn Profile</a></p>
                    </div>
                </div>
            </div>

            <div id="mukhtarModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button><hr>
                            <aside class="pull-left"><img src="images/mukhtar.jpg" alt="mukhtar" style="height: 100px; width: 100px; padding-right: 10px"></aside>
                            <h4 class="modal-title">Mukhtar Yusuf</h4>
                            <h5>MS - Software Engineering </h5>
                            <h6>San Jose State University</h6>
                        </div><br>
                        <p style="padding-left: 20px">Mukhtar is...
                        <br>The PopcornGeeks website was integrated with Facebook REST API so that Facebook users could also easily use the website without signing up for it separately, all thanks to Mukhtar!
                        <a href="http://www.linkedin.com/pub/mukhtar-yusuf/89/588/146" target="_blank">
                        <br>LinkedIn Profile</a></p>
                    </div>
                </div>
            </div>

            <div style="width: 500px; margin: 0 auto; height: 300px;">
                <h2 style="font-weight: bold; text-align: center">Our Team</h2>
                <div class="col-sm-6 col-md-4 col-lg-3"><img src="images/annie.jpg" alt="annie" style="width: 100px; height: 100px" class="annie btn-lg"></div>
                <div class="col-sm-6 col-md-4 col-lg-3"><img src="images/sahil.jpg" alt="sahil" style="width: 100px; height: 100px" class="sahil btn-lg "></div>
                <div class="clearfix visible-sm-block"></div>
                <div class="col-sm-6 col-md-4 col-lg-3"><img src="images/manav.jpg" alt="manav" style="width: 100px; height: 100px" class="manav btn-lg"></div>
                <div class="clearfix visible-md-block"></div>
                <div class="col-sm-6 col-md-4 col-lg-3"><img src="images/mukhtar.jpg" alt="mukhtar" style="width: 100px; height: 100px" class="mukhtar btn-lg"></div>
                <div class="clearfix visible-sm-block"></div>
            </div>
         </div>

        <!--Standard PopcornGeeks Footer-->
        <footer id="footer"><br>
            <a href="about_us.php" id="footer_link">About Us</a>
            <br><br>
            <p>Copyright &copy; 2014 - PopcornGeeks Inc. - All Rights Reserved</p>
        </footer>
       
      </body>
</html>
