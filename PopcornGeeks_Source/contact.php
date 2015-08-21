<?php 
include_once("php_includes/check_login_status.php");
// Get values from the form
$email_subject=$_POST['email_subject'];
$body=$_POST['message_body'];

$to = "admin@popcorngeeks.com";
$subject = "$email_subject";
$message = "$body";
 
$from = "$log_username";
$headers = "From:" . $from . "\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n"; 
 
if(@mail($to,$subject,$message,$headers))
{
  print "<script type='text/javascript'>
  alert('Your email has been sent');
  window.location='about_us_in.php';					
		</script>";
}else{
  echo "Error! Please try again.";
}
?>