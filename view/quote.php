<?php
require_once('../includes/helper.php');
if (!isset($quote_data["symbol"]))
{
    render('header', array('title' => 'Quote'));
    print "No symbol was provided, or no quote data was found.";
}
else
{
    render('header', array('title' => 'Quote for '.htmlspecialchars($quote_data["symbol"])));
?>
<br />

<div class="container">
  <form method="POST" action="quote">
    <input placeholder="Symbol" type="text" name="param" />
  	<input type="submit" value="Get Another Quote" />
  </form>

  <br />

<!-- <div class="progress" style="display: none; ">
  <img src="../img/ajax-loader.gif" alt="" />
</div> -->

  <table>
      <tr>
          <th>Symbol</th>
          <th>Date</th>
          <th>Open</th>
          <th>High</th>
          <th>Low</th>
          <th>Close</th>
      </tr>
      <tr>
          <td id="stock-symbol"><?= htmlspecialchars($quote_data["symbol"]) ?></td>
          <td><?= htmlspecialchars($quote_data["date"]) ?></td>
          <td><?= htmlspecialchars($quote_data["open"]) ?></td>
          <td><?= htmlspecialchars($quote_data["high"]) ?></td>
          <td><?= htmlspecialchars($quote_data["low"]) ?></td>
          <td><?= htmlspecialchars($quote_data["close"]) ?></td>
      </tr>
  </table>

  <br />

  <h3>Buy Shares</h3>
  <form method="POST" action="buy">
    <input id="stock_to_buy" type="text" name="stock_symbol" />
    <input placeholder="No. Shares" type="text" name="num_shares" />
  	<input type="submit" value="Buy Shares" />
  </form>
</div>

<script>var stock_data = "<?= $stock_data ?>";</script>
<script>var stock_symbol = "<?= htmlspecialchars($quote_data["symbol"]) ?>";</script>

<script type="text/javascript">
  var symbol = document.getElementById("stock-symbol").innerHTML;
  var input = document.getElementById("stock_to_buy");
  input.value = symbol;
</script>

<div id="root" class="chart"></div>

<!-- <div class="root container" ></div> -->

<?php
}

render('footer');

?>
