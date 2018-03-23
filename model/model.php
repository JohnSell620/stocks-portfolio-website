<?php
/*
    model.php
    Description: Model for user and porfolios.

    @author Johnny Sellers
    @version 0.1 05/10/2017
*/

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'cs75finance');

/*
    login_user() - Verify account credentials and create session

    @param string $email
    @param string $password
 */
function login_user($email, $password)
{
	$mysqli = new mysqli("localhost","root","root", "cs75finance");

	if (mysqli_connect_errno())
  {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	// Prepare email address for safe query
	$email = mysqli_real_escape_string($mysqli, $email);

  $stmt = $mysqli->prepare("SELECT userid FROM users WHERE email=? AND password=?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $stmt->bind_result($userid);
  $stmt->fetch();
  return $userid;

  $stmt->close();
	$mysqli->close();
}

/*
    register_user() - Create a new user account

    @param string $email
    @param string $password
    @param string $first_name
    @param string $last_name

    @return string $error
 */
function register_user($email, $password, $first_name, $last_name, $balance, &$error)
{
	try
	{
		$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
		$dbh = new PDO($dsn, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$register = $dbh->prepare('INSERT INTO users (email, password, first_name, last_name, balance) VALUES (:email, :password, :first_name, :last_name, :balance)');
    $register->execute([':email' => $email, ':password' => $password, ':first_name' => $first_name, ':last_name' => $last_name, ':balance' => $balance]);
    $register = null;

    // Return userid to $_SESSION
    $sql = "SELECT userid FROM users WHERE email=? AND password=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($email, $password));
    $userid = $stmt->fetchAll();
    $stmt = null;

		return $userid;
	}
	catch (Exception $e)
  {
		$error = 'Unable to register account.';
    echo $error +" \nCaught exception: ", $e->getMessage();
    die();
  	return false;
	}

	$dbh = null;
	return null;
}

/*
    get_quote_data() - Get stock quotes from Quandl

    @param string $symbol

    @return quote_data_object $result
 */
function get_quote_data($symbol)
{
  ini_set('auto_detect_line_endings', true);
	$url ="https://www.quandl.com/api/v3/datasets/WIKI/{$symbol}.csv";
	$handle = fopen($url, "r");
	$result = array();
  $k=0;
	while ($row = fgetcsv($handle, ","))
  {
		if (isset($row[0]) && $k==1)
    {
			$result = array("symbol" => $symbol, "date" => $row[0], "open" => $row[1], "high" => $row[2], "low" => $row[3], "close" => $row[4]);
    }
    if ($k==1) break;
    $k++;
  }

	fclose($handle);
	return $result;
}

/*
    get_stock_data() - Get historical stock data

    @param string $symbol

    @return stock_data_object $result
 */
function get_stock_data($symbol)
{
  ini_set('auto_detect_line_endings', true);
	$url ="https://www.quandl.com/api/v3/datasets/WIKI/{$symbol}.csv";
	$handle = fopen($url, "r");
	$result = array();

	while ($row = fgetcsv($handle, ","))
  {
		if (isset($row[0]))
			$result = array("date" => $row[0], "close" => $row[4]);
  }

	fclose($handle);
	return $result;
}

/*
    get_user_shares() - Retrieve user's portfolio

    @param int $userid
 */
function get_user_shares($userid)
{
  // Data source name
	$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
  // Database handle
	$dbh = new PDO($dsn, DB_USER, DB_PASSWORD);
  // Set exception mode for PDO
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

  // Statement handle
	$sth = $dbh->prepare("SELECT symbol, shares FROM portfolios WHERE userid=:userid");
	if ($sth->execute([':userid'=> $userid]))
	{
	    $result = array();
	    while ($row = $sth->fetch())
      {
			  array_push($result, $row);
	    }
		$dbh = null;
		return $result;
	}

	// Close database and return null
  $sth = null;
	$dbh = null;
	return null;
}

/*
    get_user_balance() - Get user's total of funds

    @param int $userid

    @return double $balance
 */
function get_user_balance($userid)
{
  $mysqli = new mysqli("localhost","root","root","cs75finance");

	if (mysqli_connect_errno())
  {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$userid = mysqli_real_escape_string($mysqli, $userid);
  $stmt = $mysqli->prepare("SELECT balance FROM users WHERE userid=?");
  $stmt->bind_param("s", $userid);
  $stmt->execute();
  $stmt->bind_result($balance);
  $stmt->fetch();

  return $balance;

  $stmt->close();
	$mysqli->close();
}

/*
    buy_shares() - Buy stock shares (no partial shares)

    @param int $userid
    @param string $symbol
    @param string $shares
    @param string_reference $error
 */
function buy_shares($userid, $symbol, $shares, &$error)
{
  // Check if the user has sufficient funds
  $quote_data = get_quote_data($symbol);
  $shares_value = $quote_data['close'] * $shares;
  $user_balance = get_user_balance($userid);
  $new_balance = $user_balance - $shares_value;

  // Check for current no. of shares
  $user_shares = get_user_shares($userid);
  $current_shares = 0;
  $sym = null;

  if (!empty($user_shares))
  {
    foreach ($user_shares as $key => $user_share)
    {
      if ($user_share->symbol == $symbol)
      {
        $sym = $user_share->symbol;
        $current_shares = $user_share->shares;
      }
    }
  }

  $total_shares = $current_shares + $shares;

  if ($user_balance < $shares_value)
  {
    $error = "Quote exceeds your balance.";
    return null;
  }

  try
  {
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
    $dbh = new PDO($dsn, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($current_shares == 0 && $sym == null)
    {
      $buy = $dbh->prepare('INSERT INTO portfolios (userid, symbol, shares) VALUES (:userid, :symbol, :shares)');
      $buy->execute([':shares' => $total_shares, ':userid' => $userid, ':symbol' => $symbol]);
      $buy = null;
    }
    else
    {
      $buy = $dbh->prepare('UPDATE portfolios SET shares=:shares WHERE userid=:userid AND symbol=:symbol');
      $buy->execute([':shares' => $total_shares, ':userid' => $userid, ':symbol' => $symbol]);
      $buy = null;
    }

    // Update user funds after transaction
    $update_balance = $dbh->prepare('UPDATE users SET balance=:new_balance WHERE userid=:userid');
    $update_balance->execute([':new_balance' => $new_balance, ':userid' => $userid]);
    $update_balance = null;
  }
  catch (Exception $e)
  {
    $error = "Unable to buy shares.";
    echo $error +" \nCaught exception: ", $e->getMessage();
    die("Unable to buy shares.");
    return false;
  }

  $dbh = null;
  return null;
}

/*
    sell_shares() - Sell stock shares (no partial shares)

    @param int $userid
    @param string $symbol
    @param string $shares
    @param string_reference $error
 */
function sell_shares($userid, $symbol, $shares, &$error)
{
  // Check for current no. of shares
  $user_shares = get_user_shares($userid);
  $current_shares = 0;

  if (!empty($user_shares))
  {
    foreach ($user_shares as $key => $user_share)
    {
      if ($user_share->symbol == $symbol)
      {
        $sym = $user_share->symbol;
        $current_shares = $user_share->shares;
      }
    }
  }
  else
  {
    $error = "You do not have any holdings in this stock.";
    return null;
  }

  if ($current_shares < $shares)
  {
    $error = "You only have " . $current_shares . " of " . $symbol . " to sell.";
    return null;
  }
  else
  {
    $total_shares = $current_shares - $shares;
  }

  // Get quote value and user balance
  $quote_data = get_quote_data($symbol);
  $shares_value = $quote_data['close'] * $shares;
  $user_balance = get_user_balance($userid);
  $new_balance = $user_balance + $shares_value;

  try
  {
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
    $dbh = new PDO($dsn, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($total_shares == 0)
    {
      $sell = $dbh->prepare('DELETE FROM portfolios WHERE userid=? AND symbol=?');
      $sell->execute([$userid, $symbol]);
      $sell = null;
    }
    else
    {
      $sell = $dbh->prepare('UPDATE portfolios SET shares=? WHERE userid=? AND symbol=?');
      $sell->execute([$total_shares, $userid, $symbol]);
      $sell = null;
    }

    // Update user's funds after transaction
    $update_balance = $dbh->prepare('UPDATE users SET balance=:new_balance WHERE userid=:userid');
    $update_balance->execute([':new_balance' => $new_balance, ':userid' => $userid]);
    $update_balance = null;
  }
  catch (Exception $e)
  {
    $error = 'Unable to sell shares.';
    echo $error +" \nCaught exception: ", $e->getMessage();
    die();
    return false;
  }

  $dbh = null;
  return null;
}

?>
