<?php
$db_conx = mysqli_connect("localhost", "popcorngeek", "Cornference297", "popcorngeek_social");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>