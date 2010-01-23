<?

static $X_LEFT; $X_LEFT = $_GET['XLEFT'];
static $X_RIGHT; $X_RIGHT = $_GET['XRIGHT'];
static $Y_TOP; $Y_TOP = $_GET['YTOP'];
static $Y_BOTTOM; $Y_BOTTOM = $_GET['YBOTTOM'];
static $YEAR; $YEAR = $_GET['YEAR'];
static $ACTIONPAGE; $ACTIONPAGE = 'seatSelector.php';

if ($X_LEFT == "")   $X_LEFT = $_POST['XLEFT'];
if ($X_RIGHT == "")  $X_RIGHT = $_POST['XRIGHT'];
if ($Y_TOP == "")    $Y_TOP = $_POST['YTOP'];
if ($Y_BOTTOM == "") $Y_BOTTOM = $_POST['YBOTTOM'];
if ($YEAR == "")     $YEAR = $_POST['YEAR'];

  function xyToSeatType($x, $y)
  {

    // is (x,y) a row of stairs?
    if ($x == 0   || $x == 22  || $x == 44 || $x == 66 || 
        $x == -26 || $x == -50 || $x == 92 || $x == 115)
    {
      return 0;
    }

    // is (x,y) stairs to stadium (block)
    if ($y < 4)
    {
      if (($x <= -27 && $x >= -37) ||
          ($x <=  21 && $x >=  14) ||
          ($x <=  52 && $x >=  45) ||
          ($x <= 102 && $x >=  93))
      {
        return 0;
      }
    }

    // is (x,y) in the general admission?
    if ($x <= -1 || $x >= 67)
    {
      return -1;
    }

    // is (x,y) in the blast zone?
    if ($y < 4 && $x >= 1 && $x <= 65) 
    {
      return -2;
    }   

    // is (x,y) in the pressbox?
    if ($y >38)
    {
      return -3;
    }

    // is (x,y) in reserve left
    if ($x >= 23 && $x <= 43)
    {
      return $x-22;
    }
 
    if ($x >= 45 && $x <= 65)
    {
      return $x-44;
    }
    
    return $x;
  }

  function xyToSeat($x, $y)
  {
    $seatNum = xyToSeatType($x, $y);
    if ($seatNum >= 0)
    {
      return $seatNum;
    }

    if ($x <= -27)
    {
      return $x + 50;
    }
    
    if ($x >= -25 && $x <= -1)
    {
      return $x + 26;
    }

    if ($x >= 1 && $x <= 21)
    {
      return $x;
    }

    if ($x >= 23 && $x <= 43)
    {
      return $x - 22;
    }
  
    if ($x >= 45 && $x <= 65)
    {
      return $x - 44;
    }
   
    if ($x >= 67 && $x <= 91)
    {
      return $x - 66;
    }

    if ($x >= 93)
    {
      return $x - 92;
    }
  }

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

  function beginRow()
  { ECHO "<tr height=15>"; }

  function endRow()
  { ECHO "</tr>"; }

  function putCell($color, $ticketID, $checked, $disabled)
  {
    ECHO "<td bgcolor=$color width=15><input type=checkbox name=$ticketID $checked $disabled size=-2></td>";
  }

  function putBlankCell($color)
  {
    ECHO "<td bgcolor=$color width=15><font size=1 color=#color>.</font></td>";
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


function displayPremiumTicketSelection($title, $dblogin, $dbpass, $db, $ip)
{
  global $X_LEFT, $X_RIGHT, $Y_TOP, $Y_BOTTOM, $YEAR, $ACTIONPAGE;

  $ReserveID = trim(strtoupper($_COOKIE['ReserveID']));
  $Username = trim(strtoupper($_COOKIE['username']));

  if ($ReserveID == "" || ($ReserveID != $Username && $ReserveID != "IP:" . $ip))
  {
    $ReserveID = trim(strtoupper(generateReserveID($Username, $ip, $dblogin, $dbpass, $db)));
    setcookie("ReserveID", $ReserveID, time() + 86400);  // cookie valid for 1 day
    ECHO "ReserveID: .." . $ReserveID . "<BR>";
    ECHO "IP:" . $ip . "<BR>";
  }

  ECHO "<CENTER><B><h2>$title</h2></B></CENTER>";

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");

  // release all expired tickets!
  $c = time();
  $q = "SELECT * FROM tickets, ticketStatus WHERE tickets.TicketStatusID = ticketStatus.TicketStatusID and Available = 'N' and TempHold = 'Y' and HoldTimestamp < $c";
  $r = mysql_query($q) or die("Query failed:<BR>$q<BR>Error: " . mysql_error());
  for ($i = 0; $i < mysql_numrows($r); $i++)
  {
    $TicketID = mysql_result($r, $i, 'TicketID');
    $uq = "UPDATE tickets SET TicketStatusID = 2 Where TicketID = $TicketID";
    $ur = mysql_query($uq) or die("Query failed:<BR>$uq<BR>Error: " . mysql_error());
  }


  $keyquery = "SELECT DISTINCT tickets.TicketTypeID, ticketTypes.Color, ticketTypes.ColorNotForSale, ticketTypes.TicketTypeText FROM ticketTypes, tickets WHERE tickets.TicketTypeID = ticketTypes.TicketTypeID and tickets.X >= $X_LEFT and tickets.X <= $X_RIGHT and tickets.Y >= $Y_BOTTOM and tickets.Y <= $Y_TOP  and tickets.Year = $YEAR ORDER BY tickets.TicketTypeID ASC";
  $keyresult = mysql_query($keyquery) or die ("Query failed:<BR>$keyquery<BR>Error: " . mysql_error());

  ECHO "<CENTER><B>SEATING CHART KEY:</B></CENTER>";
  ECHO "<table width=440 border=1 cellpadding=0 cellspacing=0 align=center><tr><td>";
  ECHO "<table width=430 border=0 cellpadding=0 cellspacing=2 align=center>";
  for ($j = 0; $j < mysql_numrows($keyresult); $j++)
  {
    $Color = mysql_result($keyresult, $j, "Color");
    $ColorNotForSale = mysql_result($keyresult, $j, "ColorNotForSale");
    $Text = mysql_result($keyresult, $j, "TicketTypeText");
    if ($Color == $ColorNotForSale)
    {
      ECHO "
          <tr>
            <td width=15 bgcolor=$Color><font color=$Color size=1>.</font></td>
            <td width=200 align=left>$Text (Unavailable)</td>
            <td width=15><font color=#FFFFFF size=1>.</font></td>
            <td width=200 align=left><font color=#FFFFFF size=1>.</font></td>
            </tr>
            <tr><td></td><td></td></tr>
          ";
    }
    else
    {
      ECHO "
          <tr>
            <td width=15 bgcolor=$Color><font color=$Color size=1>.</font></td>
            <td width=200 align=left>Available $Text</td>
            <td width=15 bgcolor=$ColorNotForSale><font color=$ColorNotForSale 
                size=1>.</font></td>
            <td width=200 align=left>Unavailable $Text</td>
          </tr>
          <tr><td></td><td></td></tr>
          ";
    }
  }
  ECHO "</table>";
  ECHO "</td></tr></table>";

  ECHO "<font size=1>";
  ECHO "<form action=$ACTIONPAGE method=post>";
  ECHO "<input type=hidden name=action value=reserve>";
  ECHO "<input type=hidden name=ReserveID value=$ReserveID>";
  ECHO "<input type=hidden name=XLEFT value=$X_LEFT>";
  ECHO "<input type=hidden name=XRIGHT value=$X_RIGHT>";
  ECHO "<input type=hidden name=YTOP value=$Y_TOP>";
  ECHO "<input type=hidden name=YBOTTOM value=$Y_BOTTOM>";
  ECHO "<input type=hidden name=YEAR value=$YEAR>";
  ECHO "<input type=hidden name=TITLE value='$title'>";
  ECHO "<P><table border=0 cellpadding=0 cellspacing=0 bordercolor=#000000 align=center>";

//tickets.Row, tickets.Seat, tickets.TicketTypeID, tickets.TicketID, tickets.X, tickets.Y, ticketTypes.Color, tickets.Year, ticketStatus.Available, ticketStatus.Hold FROM tickets, ticketTypes, ticketStatus

  $query = "SELECT * FROM tickets, ticketTypes, ticketStatus WHERE tickets.TicketStatusID = ticketStatus.TicketStatusID and tickets.TicketTypeID = ticketTypes.ticketTypeID and tickets.X >= $X_LEFT and tickets.X <= $X_RIGHT and tickets.Y >= $Y_BOTTOM and tickets.Y <= $Y_TOP and tickets.Year = $YEAR ORDER BY Y DESC, X ASC";

  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());


  for ($i = 0; $i < mysql_numrows($result); $i++)
  {
    $X = mysql_result($result, $i, "X");
    $Y = mysql_result($result, $i, "Y");
    $Color = mysql_result($result, $i, "Color");
    $ColorNotForSale = mysql_result($result, $i, "ColorNotForSale");
    $TicketID = mysql_result($result, $i, "TicketID");
    $TicketTypeID = mysql_result($result, $i, "TicketTypeID");
    $Available = mysql_result($result, $i, "Available");
    $TempHold = mysql_result($result, $i, "TempHold");
    $TicketStatusID = mysql_result($result, $i, "TicketStatusID");
    $HoldID = mysql_result($result, $i, "HoldID");
    $HoldTimestamp = mysql_result($result, $i, "HoldTimestamp");

    if ($X == $X_LEFT)
    {
      beginRow();
      $Row = mysql_result($result, $i, "Row");
      ECHO "<td>$Row</td>";
    }
    
    // release ticket?
    if ($TempHold == 'Y' && $HoldTimestamp < time())
    {
      $updateTicketQuery = "UPDATE tickets SET TicketStatusID = 2 WHERE TicketID = $TicketID";
      $updateTicketResult = mysql_query($updateTicketQuery) or die("Query failed:<BR>$updateTicketQuery<BR>Error: " . mysql_error());
      $Available = 'Y';
    }

    // display ticket
    if ($Available == 'N' && ($HoldID == $Username || $HoldID == "IP:" . $ip))
    {
      putCell($ColorNotForSale, $TicketID, "checked", "");
    }
    elseif ($Available == 'N')
    {
      putBlankCell($ColorNotForSale);
    }
    else
    {
      putCell($Color, $TicketID, "", "");
    }

    if ($X == $X_RIGHT)
    {
      endRow();
    }

  }

  beginRow();
  ECHO "<td></td>"; // row labels
  for ($i = $X_LEFT; $i <= $X_RIGHT; $i++)
  {
    if ($i == -50 || $i == -26 || $i == 0 || $i == 22 || 
        $i == 44 || $i == 66 || $i == 92 || $i == 115)
    {
      ECHO "<td></td>";
    }
    elseif ($i >= -49 && $i <= -27)
    {
      $seatnum = $i + 50;
      ECHO "<td align=center>$seatnum</td>";
    }
    elseif ($i >= -25 && $i <= -1)
    {
      $seatnum = $i + 26;
      ECHO "<td align=center>$seatnum</td>";
    }
    elseif ($i >= 1 && $i <= 21)
    {
      $seatnum = $i;
      ECHO "<td align=center>$seatnum</td>";
    }
    elseif ($i >= 23 && $i <= 43)
    {
      $seatnum = $i - 22;
      ECHO "<td align=center>$seatnum</td>";
    }
    elseif ($i >= 45 && $i <= 65)
    {
      $seatnum = $i - 44;
      ECHO "<td align=center>$seatnum</td>";
    }
    elseif ($i >= 67 && $i <= 91)
    {
      $seatnum = $i - 66;
      ECHO "<td align=center>$seatnum</td>";
    }
    elseif ($i >= 93 && $i <= 114)
    {
      $seatnum = $i - 92;
      ECHO "<td align=center>$seatnum</td>";
    }
    else
    {
      ECHO "<td align=center>X</td>";
    }
  }
  endRow();

  mysql_close();

  ECHO "</table>";

  ECHO "<p align=center><input type=submit value='Reserve Selected Tickets' name='ReserveSelectedTicketsButton'> <input type=submit value='View Cart / Checkout' name='Checkout'> <input type=submit value='Continue Shopping' name='ContinueShopping'></p>";
  ECHO "</form>";
  ECHO "</font>";

}


  function showStadiumSectionSelection()
  {
    ECHO "Please click on a seating section:<BR>";
    ECHO "
    <MAP NAME='SeatingMap'>
    <AREA SHAPE=RECT COORDS='104,8,189,168' HREF='general.php'>
    <AREA SHAPE=RECT COORDS='192,8,277,78' HREF='seatSelector.php?XLEFT=0&XRIGHT=22&YTOP=40&YBOTTOM=18&YEAR=2005&TITLE=Upper-Left Reserve Seats'>
    <AREA SHAPE=RECT COORDS='192,79,278,134' HREF='seatSelector.php?XLEFT=0&XRIGHT=22&YTOP=18&YBOTTOM=4&YEAR=2005&TITLE=Lower-Left Reserve Seats'>
    <AREA SHAPE=RECT COORDS='280,8,364,78' HREF='seatSelector.php?XLEFT=17&XRIGHT=49&YTOP=40&YBOTTOM=18&YEAR=2005&TITLE=Upper Premium Seats'>
    <AREA SHAPE=RECT COORDS='280,79,364,134' HREF='seatSelector.php?XLEFT=17&XRIGHT=49&YTOP=18&YBOTTOM=4&YEAR=2005&TITLE=Lower Premium Seats'>
    <AREA SHAPE=RECT COORDS='368,8,453,78' HREF='seatSelector.php?XLEFT=44&XRIGHT=66&YTOP=40&YBOTTOM=18&YEAR=2005&TITLE=Upper-Right Reserve Seats'>
    <AREA SHAPE=RECT COORDS='368,79,454,134' HREF='seatSelector.php?XLEFT=44&XRIGHT=66&YTOP=18&YBOTTOM=4&YEAR=2005&TITLE=Lower-Right Reserve Seats'>
    <AREA SHAPE=RECT COORDS='456,8,541,168' HREF='general.php'>
    <AREA SHAPE=RECT COORDS='192,138,279,168' HREF='seatSelector.php?XLEFT=0&XRIGHT=28&YTOP=8&YBOTTOM=0&YEAR=2005&TITLE=Left Blast Zone Seats'>
    <AREA SHAPE=RECT COORDS='280,138,366,168' HREF='seatSelector.php?XLEFT=22&XRIGHT=44&YTOP=8&YBOTTOM=0&YEAR=2005&TITLE=Center Blast Zone Seats'>
    <AREA SHAPE=RECT COORDS='367,138,453,168' HREF='seatSelector.php?XLEFT=38&XRIGHT=66&YTOP=8&YBOTTOM=0&YEAR=2005&TITLE=Right Blast Zone Seats'>
    </MAP>
    <P align=center><IMG SRC='http://www.drumsofsummer.com/img/seating.gif' WIDTH=648 HEIGHT=300 USEMAP='#SeatingMap' ALT='Seating Map'BORDER=1></p>
    ";
  }


// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //


  if ($YTOP == "" || $YBOTTOM == "" || $XRIGHT == "" || $XLEFT == "" || $YEAR == "")
  {
    showStadiumSectionSelection();
    exit;
  }

  $RESERVE_SECONDS = 60 * 30; // 30 minutes

  $dblogin = 'drums';
  $dbpass  = '###########';
  $db      = 'ticketdb';
 
  $ACTION1 = $_POST['ReserveSelectedTicketsButton'];
  $ACTION2 = $_POST['Checkout'];
  $ACTION3 = $_POST['ContinueShopping'];

  $TITLE = $_GET['TITLE'];
  if ($TITLE == "")
    $TITLE = $_POST['TITLE'];

  if ($ACTION3 == "Continue Shopping")
  {
    header('Location:php-menu.php');
    ECHO "You should be redirected to your shopping cart within 5 seconds.  If you are not redirected, <a href=php-menu.php>click here</a>.<BR>";
    exit;
  }

  if ($ACTION2 == "View Cart / Checkout")
  {
    header('Location:checkout.php');
    ECHO "You should be redirected to the checkout process within 5 seconds.  If you are not redirected, <a href=cart.php>click here</a>.<BR>";
    exit;
  }

  if ($ACTION3 == "" && $ACTION2 == "" && $ACTION1 != "Reserve Selected Tickets")
  {
    displayPremiumTicketSelection($TITLE, $dblogin, $dbpass, $db, $REMOTE_ADDR);
    exit;
  }

  ECHO "<B>PROCESSING, PLEASE WAIT</B><BR>";

  $ReserveID = generateReserveID(trim(strtoupper($_COOKIE['username'])), $REMOTE_ADDR, $dblogin, $dbpass, $db);
  ECHO "ReserveID: $ReserveID<BR>";
  $HoldTime = time() + $RESERVE_SECONDS;

  // get list of $YEAR tickets, so we can use those ticketIDs
  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");
  
  $query = "SELECT * FROM tickets, ticketStatus WHERE tickets.TicketStatusID = ticketStatus.ticketStatusID and Year = $YEAR and tickets.X >= $X_LEFT and tickets.X <= $X_RIGHT and tickets.Y >= $Y_BOTTOM and tickets.Y <= $Y_TOP ORDER BY TicketID ASC";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  for ($i = 0; $i < mysql_numrows($result); $i++)
  {
    $TicketID = mysql_result($result, $i, "TicketID");
    $PostTicketID = $_POST[$TicketID];
    //ECHO "$PostTicketID<BR>";
    $HoldID = mysql_result($result, $i, "HoldID");
    $Username = $_COOKIE['username'];
    $Available = mysql_result($result, $i, "Available");
    $TempHold = mysql_result($result, $i, "TempHold");
    $Row = mysql_result($result, $i, "Row");
    $Seat = mysql_result($result, $i, "Seat");

    //ECHO ">>$PostTicketID<<<BR>"; // returns "on"

   if ($PostTicketID == "on")
   {

    if ($TempHold == 'Y' && ($HoldID != "IP:" . $REMOTE_ADDR && $HoldID != $Username))
    {
      ECHO "<li>Ticket No. $TicketID (Row $Row, Seat $Seat) has already been temporarily held by someone else.  You may wish to wait until the ticket is released if not purchased within 60 minutes. $HoldID --> IP:$REMOTE_ADDR --> $Username<BR>";
    }
    elseif ($TempHold == 'Y' && ($HoldID == "IP:" . $REMOTE_ADDR || $HoldID == $Username))
    {
      // ECHO "<li>Ticket No. $TicketID (Row $Row, Seat $Seat) is already held for you.<BR>";
    }
    elseif ($Available == 'N')
    {
      ECHO "<li>Ticket No. $TicketID (Row $Row, Seat $Seat) is unavailable for purchase.<BR>";
    }
    else
    {
      $holdTicketQuery = "UPDATE tickets SET HoldID = '$ReserveID', TicketStatusID = 3, HoldTimestamp = $HoldTime WHERE TicketID = $TicketID";
      $resultHoldTicketQuery = mysql_query($holdTicketQuery) or die ("Query failed:<BR>$holdTicketQuery<BR>Error: " . mysql_error());
      ECHO "<li>Ticket No. $TicketID (Row $Row, Seat $Seat) has successfully been held for you.<BR>";
    }

   } else if ($PostTicketID != "on" && $TempHold == 'Y' && ($HoldID == "IP:" . $REMOTE_ADDR || $HoldID == $Username) && $Available = 'Y')
   {
     // unreserve tickets
     $newtime = time();
     $unholdTicketQuery = "UPDATE tickets SET HoldID = 'None', TicketStatusID = 2, HoldTimestamp = $newtime WHERE TicketID = $TicketID";
     $unholdTicketResult = mysql_query($unholdTicketQuery) or die("Query failed:<BR>$unholdTicketQuery<BR>Error: " . mysql_error());
     ECHO "<li>Ticket No. $TicketID (Row $Row, Seat $Seat) has successfully been <B>unheld</B> for you.<BR>";
   }
    
  }

  mysql_close();

      displayPremiumTicketSelection($TITLE, $dblogin, $dbpass, $db, $REMOTE_ADDR);

?> 