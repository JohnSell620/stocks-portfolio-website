<?php

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_POST['num_shares']))
{
  $userid = $_SESSION['userid'];
  $stock_symbol = strtoupper($_POST['stock_symbol']);
  $num_shares = $_POST['num_shares'];
  buy_shares($userid, $stock_symbol, $num_shares, $error);
}

$userid = (int)$_SESSION['userid'];
$holdings = get_user_shares($userid);
$balance = get_user_balance($userid);

render('portfolio', array('holdings' => $holdings, 'balance' => $balance));
?>
