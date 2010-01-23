<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

  function beginRow()
  { ECHO "<tr height=10>"; }

  function endRow()
  { ECHO "</tr>"; }

  function putCell($color)
  {
    ECHO "<td bgcolor=$color width=4></td>";
  }

  

  ECHO "<script src=hover.js></script>";
  ECHO "<table border=1 cellpadding=0 cellspacing=0>";

  mysql_connect(localhost, 'drums', '############');
  @mysql_select_db(ticketdb) or die("Unable to select database.");

  $query = "SELECT tickets.X, tickets.Y, ticketTypes.Color, ticketTypes.ColorNotForSale, tickets.Year, tickets.TicketStatusID FROM tickets, ticketTypes WHERE tickets.TicketTypeID = ticketTypes.ticketTypeID ORDER BY Y DESC, X ASC";
  $result = mysql_query($query) or die(mysql_error());

  ECHO mysql_numrows($result);

  for ($i = 0; $i < mysql_numrows($result); $i++)
  {
    $X = mysql_result($result, $i, "X");
    $Y = mysql_result($result, $i, "Y");
    $Color = mysql_result($result, $i, "Color");
    $ColorUnavailable = mysql_result($result, $i, "ColorNotForSale");
    $TicketStatusID = mysql_result($result, $i, "TicketStatusID");

    if ($X == -50)
    {
      beginRow();
    }

    if ($TicketStatusID == 2)  // available
    {
      putCell($Color);
    }
    else
    {
      putCell($ColorUnavailable);
    }

    if ($X == 115)
    {
      endRow();
    }
  }

  mysql_close();

  ECHO "</table>";

?>