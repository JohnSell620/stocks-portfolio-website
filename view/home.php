<?php
require_once('../includes/helper.php');
render('header', array('title' => 'C$75 Finance'));
?>

<br />
<div class="container">
  <form method="POST" action="quote">
    <input placeholder="Symbol" type="text" name="param" />
  	<input type="submit" value="Get Quote" />
  </form>
  <ul>
  	<li><a href="portfolio">View Portfolio</a></li>
    	<li><a href="sell">Sell Stock</a></li>
  </ul>
</div>

<div id="root" class="chart"></div>

<?php
render('footer');
?>
