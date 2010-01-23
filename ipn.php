<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

$dblogin = 'drums';
$dbpass = '###############';
$database = 'ticketdb';

mysql_connect(localhost, $dblogin, $dbpass);
@mysql_select_db($database) or die("Unable to select database.");

$time = time();
$query = "INSERT INTO sales VALUES('', 888, 666, 666, $time)";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

mysql_close();

// ----------------------------------------------------- //

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value)
{
  $value = urlencode(stripslashes($value));
  $req .= "&$key = $value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

mail("ashlux@gmail.com", "IPN", $req . "\n\n=HEADER:=====\n\n" . $header);

$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$numcartitems = $_POST['num_cart_items'];
$zpayer_email = $_POST['payer_email'];
$ztxn_id = $_POST['txn_id'];
$zpayment_status = $_POST['payment_status'];
$zpayment_date = $_POST['payment_date'];
$zaddress_street = $_POST['address_street'];
$zaddress_city = $_POST['address_city'];
$zaddress_state = $_POST['address_state'];
$zaddress_zip = $_POST['address_zip'];
$CustomerID = $_POST['custom'];

for ($i = 0; $i < $numcartitems; $i++)
{
  $n = $i + 1;
  $yitem_name[$i] = $_POST['item_name'. $n];
  $yitem_number[$i] = $_POST['item_number'. $n];
  $yquantity[$i] = $_POST['quantity'. $n];
  $ytax[$i] = $_POST['tax'. $n];
}

if (!$fp)
{
  // HTTP ERROR
}
else
{
  fputs($fp, $header . $req);
  while (!feof($fp))
  {
    $res = fgets($fp, 1024);
    if (strcmp($res, "VERIFIED") == 0)
    {
      // check payment_status is completed
      // check txn_id is not previously processed
      // check receiver_email is primary paypal email
      // check payment_amount / payment_currency are correct
      // process payment (update db)

      mysql_connect(localhost, $dblogin, $dbpass);
      @mysql_select_db($database) or die("Unable to select database.");

      $newOrderQuery = "INSERT INTO orders VALUES('', $CustomerID, 0, '$ztxn_id')";
      $newOrderResult = mysql_query($newOrderQuery) or die("Query failed:<BR>$newOrderQuery<BR>Error: " . mysql_error());

      $q = "SELECT * FROM orders WHERE txn_id = '$ztxn_id'";
      $r = mysql_query($q) or die("Query failed:<BR>$q<BR>Error: " . mysql_error());
//      if (mysql_numrows($r) > 1)
//        throwDuplicateTransactionID($r, $ztxn_id);

      $OrderID = mysql_result($r, 0, 'OrderID');

      for($i = 0; $i < $numcartitems; $i++)
      {
        $time = time();
        $TicketID = $yitem_number[$i];

        $updateTicketQuery = "UPDATE tickets SET TicketStatusID = 5 WHERE TicketID = $TicketID";
        $updateTicketResult = mysql_query($updateTicketQuery) or die("Query failed:<BR>$updateTicketQuery<BR>Error: " . mysql_error());

        $selectTicketQuery = "SELECT * FROM tickets, ticketTypes WHERE tickets.TicketTypeID  = ticketTypes.TicketTypeID and TicketID = $TicketID";
        $selectTicketResult = mysql_query($selectTicketQuery) or die("Query failed:<BR>$selectTicketQuery<BR>Error: " . mysql_error());

        $query = "INSERT INTO sales VALUES('', $TicketID, $OrderID, $CustomerID, $time)";
        $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
      }

      mysql_close();

    }
    elseif (strcmp($res, "INVALID") == 0)
    {
      // log for manual investigation
      mysql_connect(localhost, $dblogin, $dbpass);
      @mysql_select_db($database) or die("Unable to select database.");
 
      $time = time();
      $query = "INSERT INTO sales VALUES('', 404, 404, 404, $time)";
      $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

      mysql_close();
    }
  }
  fclose($fp);
}

?>