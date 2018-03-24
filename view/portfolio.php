<?php
require_once('../includes/helper.php');
render('header', array('title' => 'Portfolio'));
?>
<br />
<div class="container">
  <form method="POST" action="quote">
    <input placeholder="Symbol" type="text" name="param" />
  	<input type="submit" value="Get Quote" />
  </form>
  
  <br />

  <h2>Balance: $<?php echo htmlspecialchars($balance) ?></h2>
  <table>
      <tr>
          <th>Stock</th>
          <th>Shares</th>
      </tr>
  <?php
  foreach ($holdings as $key => $holding)
  {
      print "<tr>";
      print "<td>" . htmlspecialchars($holding->symbol) . "</td>";
      print "<td>" . htmlspecialchars($holding->shares) . "</td>";
      print "</tr>";
  }
  ?>
  </table>

  <br />

  <h3>Sell Shares</h3>
  <form class="" action="sell" method="post">
    <input placeholder="Stock symbol" type="text" name="stock_symbol" />
    <input placeholder='Number shares to sell' type='text' name='num_shares' />
    <input type='submit' value='Sell Shares' />
  </form>
</div>

<div id="root" class="chart"></div>

<?php
render('footer');
?>
