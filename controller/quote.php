<?php

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_POST['param'])) // $_REQUEST['param']
{
  $sym = strtoupper($_POST['param']);
	$quote_data = get_quote_data($sym);
  $stock_data = get_stock_data($sym);
}

render('quote', array('quote_data' => $quote_data, 'stock_data' => $stock_data));
?>
