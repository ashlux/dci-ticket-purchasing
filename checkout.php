<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

include "layout.inc";

function checkLoginCookies($dblogin, $dbpass, $db)
{
  $CustomerID = $_COOKIE["id"];
  $Username   = trim(strtoupper($_COOKIE["username"]));
  $Auth       = trim(strtoupper($_COOKIE["auth"]));

  if ($CustomerID == "" || $Username == "" || $Auth == "")
  {
    header('Location:login.php?ref=checkout.php');
    ECHO "You must be logged in.  If you are not forwarded to the login page in 5 seconds, please <a href=login.php?ref=checkout.php>click here</a>.<BR>";
    exit;
  }

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database");
  
  $query = "SELECT * FROM customers WHERE CustomerID = $CustomerID and Username = '$Username' and Auth = '$Auth'";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  if (mysql_numrows($result) == 0)
  {
    mysql_close();
    header('Location:login.php?ref=checkout.php');
    ECHO "You must be logged in.  If you are not forwarded to the login page in 5 seconds, please <a href=login.php?ref=checkout.php>click here</a>.<BR>";
    exit;
  }

  mysql_close();

  return array(mysql_result($result, 0, "CustomerID"), 
               mysql_result($result, 0, "FName"),
               mysql_result($result, 0, "LName"),
               mysql_result($result, 0, "MName"),
               mysql_result($result, 0, "Address1"),
               mysql_result($result, 0, "Address2"),
               mysql_result($result, 0, "City"),
               mysql_result($result, 0, "State"),
               mysql_result($result, 0, "Zip"),
               mysql_result($result, 0, "Phone1"),
               mysql_result($result, 0, "Phone2"),
               mysql_result($result, 0, "Email"),
               mysql_result($result, 0, "Username"),
               mysql_result($result, 0, "Password")
              );
}

function removeSelectedTickets($dblogin, $dbpass, $db, $ip, $username)
{
  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");

  $currTime = time();

$query = "SELECT * FROM tickets, ticketTypes, ticketStatus WHERE ticketTypes.TicketTypeID = tickets.TicketTypeID and ticketStatus.TicketStatusID = tickets.TicketStatusID and (TempHold = 'Y') and ForSale = 'Y' and (HoldID = 'IP:$ip' or HoldID = '$username') and tickets.HoldTimestamp > $currTime ORDER BY TicketID";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
  
  if (mysql_numrows($result) <= 0)
  {
    ECHO "You have no reserved tickets in your cart to remove.<BR>";
    return;
  }

  for ($i = 0; $i < mysql_numrows($result); $i++)
  {
    $TicketID = mysql_result($result, $i, 'TicketID');
    $Row = mysql_result($result, $i, 'Row');
    $Seat = mysql_result($result, $i, 'Seat');
    $TicketTypeID = mysql_result($result, $i, 'TicketTypeID');
    $TicketTypeText = mysql_result($result, $i, 'TicketTypeText');

    $VAL = $_POST[$TicketID];
    if ($VAL == $TicketID)
    {
      if ($TicketTypeID == 3)
      {
        ECHO "<B>REMOVED:</B> 1 $TicketTypeText<BR>";
        $removeTicketQuery = "UPDATE tickets SET HoldID = 'None', TicketStatusID = 2 WHERE TicketID = $TicketID";
        $removeTicketResult = mysql_query($removeTicketQuery) or die("Query failed:<BR>$removeTicketQuery<BR>Error: " . mysql_error());

      }
      else
      {
        ECHO "<B>REMOVED:</B> $TicketTypeText - Ticket No. $TicketID; Row $Row, Seat $Seat<BR>";
        $removeTicketQuery = "UPDATE tickets SET HoldID = 'None', TicketStatusID = 2 WHERE TicketID = $TicketID";
        $removeTicketResult = mysql_query($removeTicketQuery) or die("Query failed:<BR>$removeTicketQuery<BR>Error: " . mysql_error());

      }
    }
  }

  mysql_close();
}

// ------------------------------------------------------- //

list ($CustomerID,
      $FName,
      $LName, 
      $MName,
      $Address1,
      $Address2,
      $City,
      $State,
      $Zip,
      $Phone1,
      $Phone2,
      $Email,
      $Username,
      $Password) = checkLoginCookies($dblogin, $dbpass, $database);

$action = $_POST['action'];
if ($action == "editcart")
{
  removeSelectedTickets($dblogin, $dbpass, $database, $REMOTE_ADDR, $Username);
}

ECHO "<P><B>Currently Reserved Tickets:</B><BR>";

ECHO "<ul>";
mysql_connect(localhost, $dblogin, $dbpass);
@mysql_select_db($database) or die("Unable to select database.");

$currTime = time();
$query = "SELECT * FROM tickets, ticketTypes, ticketStatus WHERE ticketTypes.TicketTypeID = tickets.TicketTypeID and ticketStatus.TicketStatusID = tickets.TicketStatusID and (TempHold = 'Y') and ForSale = 'Y' and (HoldID = 'IP:$ip' or HoldID = '$username') and tickets.HoldTimestamp > $currTime ORDER BY TicketID";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

$numrows = mysql_numrows($result);

$PayPalForm = "";

if (mysql_numrows($result) <= 0)
{

  ECHO "Shopping cart is empty.<BR>";
  ECHO "<P><form action=php-menu.php method=post><input type=Submit value='Continue Shopping'></form>";

}
else
{
//  $PayPalForm .= "<form action='https://www.paypal.com/cgi-bin/webscr' method=post>\n";
  $PayPalForm .= "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method=post>\n";
  $PayPalForm .= "<input type=hidden name=cmd value='_cart'>\n";
  $PayPalForm .= "<input type=hidden name=business value='ashlux@gmail.com'>\n";
  $PayPalForm .= "<input type=hidden name='currency_code' value='USD'>\n";
  $PayPalForm .= "<input type=hidden name=upload value='$numrows'>\n";
  $PayPalForm .= "<input type=hidden name=receiver_email value='ashlux@gmail.com'>\n";
  $PayPalForm .= "<input type=hidden name='first_name' value='$FName'>\n";
  $PayPalForm .= "<input type=hidden name='last_name' value='$LName'>\n";
  $PayPalForm .= "<input type=hidden name='address1' value='$Address1'>\n";
  $PayPalForm .= "<input type=hidden name='address2' value='$Address2'>\n";
  $PayPalForm .= "<input type=hidden name='city' value='$City'>\n";
  $PayPalForm .= "<input type=hidden name='state' value='$State'>\n";
  $PayPalForm .= "<input type=hidden name='zip' value='$Zip'>\n";
  $PayPalForm .= "<input type=hidden name='country' value='USA'>\n";
  $PayPalForm .= "<input type=hidden name='email' value='$Email'>\n";
  $PayPalForm .= "<input type=hidden name='custom' value='$CustomerID'>\n";
//  $PayPalForm .= "<input type=hidden name='test_ipn' value='1'>\n";
//  $PayPalForm .= "<input type=hidden name='' value=''>\n";

  ECHO "<form action='checkout.php' method=post>\n";
  ECHO "<input type=hidden name=action value='editcart'>\n";

  for ($i = 0; $i < mysql_numrows($result); $i++)
  {
    $TicketID = mysql_result($result, $i, "TicketID");
    $Row = mysql_result($result, $i, "Row");
    $Seat = mysql_result($result, $i, "Seat");
    $TicketTypeID = mysql_result($result, $i, "TicketTypeID");
    $UserPickable = mysql_result($result, $i, "UserPickable");
    $TicketTypeText = mysql_result($result, $i, "TicketTypeText");
    $TicketTypePrice = mysql_result($result, $i, "TicketTypePrice");    

    $count = $i + 1;
    if ($UserPickable == 'N')
    {
      $PayPalForm .= "<input type=hidden name='item_number_$count' value='$TicketID'>\n";
      $PayPalForm .= "<input type=hidden name='item_name_$count' value='$TicketTypeText'>\n";
      $PayPalForm .= "<input type=hidden name='amount_$count' value='$TicketTypePrice'>\n";      
      ECHO "<input type=checkbox name='$TicketID' value='$TicketID'>$TicketTypeText<BR>";
    }
    else
    {
      $PayPalForm .= "<input type=hidden name='item_number_$count' value='$TicketID'>\n";
      $PayPalForm .= "<input type=hidden name='item_name_$count' value='$TicketTypeText - Ticket No. $TicketID, Row $Row, Seat $Seat'>";
      $PayPalForm .= "<input type=hidden name='amount_$count' value='$TicketTypePrice'>\n";
//      $PayPalForm .= "$TicketTypeText - Ticket No. $TicketID; Row $Row, Seat $Seat<BR>\n";
      ECHO "<input type=checkbox name='$TicketID' value='$TicketID'>$TicketTypeText - Ticket No. $TicketID; Row $Row, Seat $Seat<BR>";
    }
  }

    ECHO "<P><table><tr><td>";
    ECHO "<input type=Submit value='Release Selected Tickets'></form>";
    ECHO "</td><td>";
    $PayPalForm .= "<input type=Submit value='Continue Checkout'></form>";
    ECHO $PayPalForm;
    ECHO "</td><td>";
    ECHO "<form action=php-menu.php method=post><input type=Submit value='Continue Shopping'></form>";
    ECHO "</td></tr></table>";

}

mysql_close();

ECHO "</ul>";

?>

