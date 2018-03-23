<?php
require_once('../includes/helper.php');
render('header', array('title' => 'C$75 Finance'));
?>

<br />
<form method="POST" action="quote">
  <input placeholder="Symbol" type="text" name="param" />
	<input type="submit" value="Get Quote" />
</form>

<ul>
	<li><a href="portfolio">View Portfolio</a></li>
  	<li><a href="sell">Sell Stock</a></li>
</ul>

<div style="display: inline-block" id="root"></div>

<?php
render('footer');
?>
