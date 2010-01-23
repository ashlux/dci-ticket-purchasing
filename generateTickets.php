<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

  function yToRow($y)
  {
    switch ($y)
    {
      case 0: return "A"; break;
      case 1: return "B"; break;
      case 2: return "C"; break;
      case 3: return "D"; break;
      case 4: return "E"; break;      case 5: return "F"; break;
      case 6: return "G"; break;
      case 7: return "H"; break;
      case 8: return "J"; break;
      case 9: return "K"; break;
      case 10: return "L"; break;
      case 11: return "M"; break;
      case 12: return "N"; break;
      case 13: return "P"; break;
      case 14: return "Q"; break;
      case 15: return "R"; break;
      case 16: return "S"; break;
      case 17: return "T"; break;
      case 18: return "U"; break;
      case 19: return "V"; break;
      case 20: return "W"; break;
      case 21: return "X"; break;
      case 22: return "Z"; break;
      case 23: return "Y"; break;
      case 24: return "AA"; break;
      case 25: return "BB"; break;
      case 26: return "CC"; break;
      case 27: return "DD"; break;
      case 28: return "EE"; break;
      case 29: return "FF"; break;
      case 30: return "GG"; break;
      case 31: return "HH"; break;
      case 32: return "JJ"; break;
      case 33: return "KK"; break;
      case 34: return "LL"; break;
      case 35: return "MM"; break;
      case 36: return "NN"; break;
      case 37: return "PP"; break;
      case 38: return "QQ"; break;
      case 39: return "RR"; break;
      case 40: return "SS"; break;
      default: return "XX"; break;
    }
  }

  function xyToSeatType($x, $y)
  {

    // is (x,y) a row of stairs?
    if ($x == 0   || $x == 22  || $x == 44 || $x == 66 || 
        $x == -26 || $x == -50 || $x == 92 || $x == 115)
    {
      if (($x == 22 || $x == 44) && ($y >= 39))
        return -3;
      else
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

  function xyToTicketType($x, $y)
  {
    ECHO "[$x, $y]";
    $SeatType = xyToSeatType($x, $y);
    if ($SeatType == 0)
    { ECHO "STAIRS<BR>";
      return array(5, 1); // Stairs, closed
    }
    if ($SeatType == -1)
    {ECHO "GENERAL<BR>";
      return array(3, 2); // General Addmission, available
    }
    if ($SeatType == -2)
    { ECHO "BLAST<BR>";
      return array(4, 2); // Blast Zone, available
    }
    if ($SeatType == -3)
    { ECHO "PRESS<BR>";
      return array(6, 1); // Pressbox, closed
    }
    
    if ($x <= 16 || $x >= 50)
    { ECHO "RESERVE<BR>";
      return array(2, 2); // Reserved, available
    }
    else
    { ECHO "PREMIUM<BR>";
      return array(1,2); // Premium, available
    }
  }

  function generate2005($dblogin, $dbpass, $db)
  {
    mysql_connect(localhost, $dblogin, $dbpass);
    @mysql_select_db($db) or die("Unable to select database");

    $time = time();
    $c = 0;
    for ($y = 0; $y <= 40; $y++)
    {
      for ($x = -50; $x <= 115; $x++)
      {
        $c++;
//        ECHO "$x, $y<BR>";

        $year = 2005;
        $row = yToRow($y);
        $seat = xyToSeat($x,$y);
        list ($TicketTypeID, $TicketStatusID) = xyToTicketType($x,$y);
//        $section = xToSection($x);


          $query = "INSERT INTO tickets VALUES('', $year, '$row', '$seat', 
                                               $TicketTypeID, $TicketStatusID, $time, 'NONE', 0, $x, $y, 'Y')";
          $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
      }
    }
    mysql_close();
    ECHO "$c<BR>";
  }

  function delete($year)
  {
    mysql_connect(localhost, 'drums', '###########');
    @mysql_select_db(ticketdb) or die("Unable to select database");
    $query = "DELETE FROM tickets WHERE Year = $year";
    mysql_query($query);
    mysql_close();
  }

delete(2005);
generate2005('drums', '############', 'ticketdb');

ECHO "<B>TICKETS HAVE BEEN GENERATED FOR THE 2005 YEAR!</B>";

?>