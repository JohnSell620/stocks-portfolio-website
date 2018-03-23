<?php

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_POST['email']) && isset($_POST['password']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	$pwdhash = hash("SHA1", $password);

	$userid = login_user($email, $pwdhash);
	if ($userid > 0)
	{
		$_SESSION['userid'] = $userid;
		render('home');
	}
	else render('login');

}
else
{
	render('login');
}
?>
