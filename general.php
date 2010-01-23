<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

  $RESERVE_SECONDS = 60 * 30; // 30 minutes

  function isLoggedIn($dblogin, $dbpass, $db)
  {
    $CustomerID = $_COOKIE["id"];
    $Username   = trim(strtoupper($_COOKIE["username"]));
    $Auth       = trim(strtoupper($_COOKIE["auth"]));

    if ($CustomerID == "" || $Username == "" || $Auth == "")
    {
      return false;
    }

    mysql_connect(localhost, $dblogin, $dbpass);
    @mysql_select_db($db) or die("Unable to select database");
  
    $query = "SELECT * FROM customers WHERE CustomerID = $CustomerID and Username = '$Username' and Auth = '$Auth'";
    $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

    if (mysql_numrows($result) == 0)
    {
      mysql_close();
      return false;
    }

    mysql_close();

    return true;
  }  
  
  function generateReserveID($Username, $r, $dblogin, $dbpass, $db)
  {
    if (isLoggedIn($dblogin, $dbpass, $db))
    {
      // use username if logged in
       return $Username;
    }
    else
    {
      // use ip address
      return "IP:" . $r;
    }
  }


function unreserveTickets($Username, $ip, $num, $dblogin, $dbpass, $db)
{
  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");

  $query = "SELECT * FROM tickets, ticketStatus WHERE TicketTypeID = 3 and ticketStatus.Available = 'N' and ticketStatus.TempHold = 'Y' and (HoldID = 'IP:$ip' or HoldID = '$Username')";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  $numReserved = mysql_numrows($result);
  if ($numReserved < $num)
  {
    ECHO "You cannot remove $num general admission tickets since you are only reserving $numReserved tickets.<BR>";
    mysql_close();
    return;
  }

  $newTime = time();
  for ($i = 0; $i < $num; $i++)
  {
    $TicketID = mysql_result($result, $i, 'TicketID');
    $removeQuery = "UPDATE tickets SET HoldID = 'None', HoldTimestamp = $newTime, TicketStatusID = 2 WHERE TicketID = $TicketID";
    $removeResult = mysql_query($removeQuery) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
  }

  ECHO "Successfully <B>unreserved</B> $num general admission tickets.";

}

function reserveTickets($ReserveID, $num, $dblogin, $dbpass, $db)
{
  global $RESERVE_SECONDS;

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");
  
  $query = "SELECT * FROM tickets, ticketStatus WHERE tickets.TicketStatusID = ticketStatus.TicketStatusID and TicketTypeID = 3 and Available = 'Y' ORDER BY TicketID ASC";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
  
  if (mysql_numrows($result) < $num)  
  {
    ECHO "<B>ERROR</B>: We currently do not have $num general admission tickets available for purchase.  If you constantly receive this error, please contact us to verify we are out of general admission ticekts.<BR>";
    mysql_close();
    return;
  }

  $reserveTimestamp = time() + $RESERVE_SECONDS;
  for ($i = 0; $i < $num; $i++)
  {
    $TicketID = mysql_result($result, $i, 'TicketID');
    $reserveQuery = "UPDATE tickets SET HoldTimestamp = $reserveTimestamp, HoldID = '$ReserveID', TicketStatusID = 3 WHERE TicketID = $TicketID";
    $reserveResult = mysql_query($reserveQuery) or die("Query failed:<BR>$reserveQuery<BR>Error: " . mysql_error());
  }
  
  mysql_close();

  ECHO "<P>Successfully reserved $num additional general admission tickets.<BR>";

}

function numReserved($Username, $ip, $dblogin, $dbpass, $db)
{
  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");
  
  $currTime = time();
  $query = "SELECT TicketID FROM tickets, ticketStatus WHERE tickets.TicketStatusID = ticketStatus.TicketStatusID and TicketTypeID = 3 and Available = 'N' and TempHold = 'Y' and (HoldID = 'IP:$ip' or HoldID = '$Username') and HoldTimestamp >= $currTime";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  $num = mysql_numrows($result);
  
  mysql_close();  

  return $num;
}

// ------------------------------------------------------- //

$dblogin = "drums";
$dbpass  = "###############";
$database = "ticketdb";

$num = $_POST['num'];
$Username = trim(strtoupper($_COOKIE['username']));

$action = $_POST['action'];
if ($action == "reserve")
{
  reserveTickets(generateReserveID($Username, $REMOTE_ADDR, $dblogin, $dbpass, $database), $num, $dblogin, $dbpass, $database);
}

if ($action == "unreserve")
{
  unreserveTickets($Username, $REMOTE_ADDR, $num, $dblogin, $dbpass, $database);
}

$numReserved = numReserved($Username, $REMOVE_ADDR, $dblogin, $dbpass, $database);

ECHO "<P><table width=250 align='center' border=1 cellpadding=0 cellspacing=0><tr><td align=center>You currently have <B>$numReserved</B> general admission tickets reserved.</td></tr></table><BR>";

ECHO "
         <P><form action='general.php' method='post'>
         <input type=hidden name=action value='reserve'>
         Number of Tickets to RESERVE: <input type=text name=num value='0'> <input type=submit name='Reserve' value='Reserve'>
         </form>

         <form action='general.php' method='post'>
         <input type=hidden name=action value='unreserve'>
         Number of Tickets to UNRESERVE: <input type=text name=num value='0'> <input type=submit name='Unreserve' value='Unreserve'>
         </form>

         <table><tr><td><form action='php-menu.php' method='post'><input type=submit name='Continue Shopping' value='Continue Shopping'></form> </td>
         <td> <form action='checkout.php' method='post'><input type=submit name='Checkout' value='Checkout'></form></td>
         </tr></table>
     ";

?>