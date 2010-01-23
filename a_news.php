<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

function intToMonth($m)
{
  switch($m)
  {
    case 1: return "January";
    case 2: return "Feburary";
    case 3: return "March";
    case 4: return "April";
    case 5: return "May";
    case 6: return "June";
    case 7: return "July";
    case 8: return "August";
    case 9: return "September";
    case 10: return "October";
    case 11: return "November";
    case 12: return "December";
    default: return "Error";
  }
}

function returnTimeStr($month, $day, $year, $hour, $minute, $second)
{
  $hourPre = ""; if ($hour <= 9) $hourPre .= "0";
  $minutePre = ""; if ($minute <= 9) $minutePre .= "0";
  $secondPre = ""; if ($second <= 9) $secondPre .= "0";
  return intToMonth($month) . " $day, $year at $hourPre$hour:$minutePre$minute:$secondPre$second";
}

function displayMostActive($max, $dblogin, $dbpass, $db)
{

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database.");

  $query = "SELECT * FROM news WHERE Active = 'Y' ORDER BY Year DESC, Month DESC, Day DESC, Hour DESC, Minute DESC, Second DESC";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  if (mysql_numrows($result) == 0)
  {
    ECHO "No news items to display.";
    exit;
  }

  for ($i = 0; $i < mysql_numrows($result) && $i < $max; $i++)
  {
    $Title = mysql_result($result, $i, 'Title');
    $Text = mysql_result($result, $i, 'Text');
    $Month = mysql_result($result, $i, 'Month');
    $Day = mysql_result($result, $i, 'Day');
    $Year = mysql_result($result, $i, 'Year');
    $Hour = mysql_result($result, $i, 'Hour');
    $Minute = mysql_result($result, $i, 'Minute');
    $Second = mysql_result($result, $i, 'Second');

    ECHO "<B><h2>$Title</h2></B>";
    ECHO "<ul>$Text</ul>";
    ECHO "Posted on " . returnTimeStr($Month, $Day, $Year, $Hour, $Minute, $Second) . "<BR>";
  }
}

// ----------------------------------- //

$dblogin = 'drums';
$dbpass  = '#############';
$db      = 'ticketdb';

  $max = $_GET['max'];
  displayMostActive($max, $dblogin, $dbpass, $db);

?>