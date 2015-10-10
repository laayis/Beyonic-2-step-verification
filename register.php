<?php
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
require('auth_seed.php');
$auth = new authSeed();

$code = $auth->fetchComputation('6trio78okjuuiy7ik78olkjerwhwty7ikri67i');
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))
{
	$uname = mysql_real_escape_string($_POST['uname']);
	$email = mysql_real_escape_string($_POST['email']);
	$phone_number = mysql_real_escape_string($_POST['phone_number']);
	$upass = md5(mysql_real_escape_string($_POST['pass']));
	
	if(mysql_query("INSERT INTO users(username,email,phone_number,code,password) VALUES('$uname','$email','$phone_number','$code','$upass')"))
	{
		
		$EmailTo = "lawi@dotsavvyafrica.com";
		$Subject = "Sign Up Message";

		// prepare email body text
		$Body = "";
		$Body .= "Name: ";
		$Body .= $uname;
		$Body .= "\n";
		$Body .= "Email: ";
		$Body .= $email;
		$Body .= "\n";
		$Body .= "Phone Number: ";
		$Body .= $phone_number;
		$Body .= "\n";
		$Body .= "Code: ";
		$Body .= $code;
		$Body .= "\n";

		// send email
		$success = mail($EmailTo, $Subject, $Body, "From:".$email);

    // Step 1: Download the Twilio-PHP library from twilio.com/docs/libraries, 
    // and move it into the folder containing this file.
    // This line loads the library
	require('/twilio-php/Services/Twilio.php');
 
    // Step 2: set our AccountSid and AuthToken from www.twilio.com/user/account
    $AccountSid = "ACdaccc7cac6e08e09a62c117c400a06d3";
    $AuthToken = "bb079a4c38d7c33a0fd46d55117ed6d5";
 
    // Step 3: instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
 
    // Step 4: make an array of people we know, to send them a message. 
    // Feel free to change/add your own phone number and name here.
    $people = array(
        "+254713348090" => "Lawi",
    );
 
    // Step 5: Loop over all our friends. $number is a phone number above, and 
    // $name is the name next to it
    foreach ($people as $number => $name) {
 
        $sms = $client->account->messages->sendMessage(
 
        // Step 6: Change the 'From' number below to be a valid Twilio number 
        // that you've purchased, or the (deprecated) Sandbox number
            "+254734861758", 
 
            // the number we are sending to - Any phone number
            $number,
 
            // the sms body
            "Hey $name, Monkey Party at 6PM. Bring Bananas!"
        );
 
        // Display a confirmation message on the screen
        echo "Sent message to $name";
    }
		print $message->$account_sid;

		// redirect to success page
		if ($success && $errorMSG == ""){
		   echo "success";
		}else{
		    if($errorMSG == ""){
		        echo "Something went wrong :(";
		    } else {
		        echo $errorMSG;
		    }
		}

		?>
        <!-- <script>alert('successfully registered ');</script> -->
        <?php
	}
	else
	{
		?>
        <script>alert('error while registering you...');</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Beyonic Login & Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="text" name="phone_number" placeholder="Your Phone Number" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>