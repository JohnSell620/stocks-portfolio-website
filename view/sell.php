<?php
require_once('../includes/helper.php');
  render('header', array('title' => 'Sell Shares'));
?>
<script type='text/javascript'>
  function validateForm()
  {
    isValid = true;

    // Validate stock symbol entry
    stockSymbolField = $("input[name=stock-symbol]");
    if (emailField.val().length < 3) {
      isValid = false;
      alert("Not a valid stock symbol." + stockSymbolField.val().length());
    }

    // Validate number-of-shares entry
    sharesField = $("input[name=confirm-password]");
    if (sharesField.val() === parseInt(sharesField.val(), 10)) {
      return isValid;
    }
    else {
      isValid = false;
      alert("Number of shares must be an integer.");
    }

    return isValid;
  }

  // set the focus to the email field (located by id attribute)
  $("input[name=email]").focus();
</script>
<br />

<div style="display: inline-block; max-width: 300px"
<form method="POST" action="quote">
  <input placeholder="Symbol" type="text" name="param" />
	<input type="submit" value="Get Quote" />
</form>

<h1>Balance: <?php echo $balance ?></h1>

<!-- <div> -->

  <table>
    <tr>
      <th>Symbol</th>
      <th>Shares</th>
    </tr>
    <?php
    foreach ($holdings as $holding)
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

<br />


<?php

render('footer');

?>
