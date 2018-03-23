<?php

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_SESSION['userid']))
{
	// get the list of holdings for user
	$userid = (int)$_SESSION['userid'];
	$holdings = get_user_shares($userid);
  $balance = get_user_balance($userid);

	render('portfolio', array('holdings' => $holdings, 'balance' => $balance));
}
else
{
	render('login');
}
?>
