<?php

require_once('../model/model.php');
require_once('../includes/helper.php');

if ((isset($_POST['email']) && isset($_POST['password'])) &&
	(isset($_POST['first_name']) &&	isset($_POST['last_name'])))
{

	$email = $_POST['email'];
	$password = $_POST['password'];
	$pwdhash = hash("SHA1", $password);
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $balance = 10000.00;

	$userid = register_user($email, $pwdhash, $first_name, $last_name, $balance, $error);
	if ($userid > 0)
	{
		$_SESSION['userid'] = $userid;
		render('home');
	}
	else
	{
    render('login');
    echo $error;
	}
}
else
{
	render('login');
}
?>
