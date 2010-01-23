<HTML>

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

<?

  function isLoggedIn_Simple()
  {

    $CustomerID = $_COOKIE["id"];
    $Username   = trim(strtoupper($_COOKIE["username"]));

    if ($CustomerID == "" || $Username == "")
    {
      return "false";
    }
    else
    {
      return "true";
    }
  }  

  function greyBar($TEXT)
  {
    ECHO "<DIV style='position:absolute;left:208px;right:5px;top:80px;
                      border-style:solid;border-width:1px;
                      border-color:black;text-align:center;color:#FFFFFF;
                      background-color:#616161'>
         $TEXT<BR>
         </DIV>";

  }

  function beginContentBox()
  {
    ECHO "<DIV style='position:absolute;left:220px;right:5px;top:115px;border-style:none;
                      text-align:left;color:#000000'>";
  }
  function endContentBox()
  {
    ECHO "</DIV>";
  }

  function dividingBar($TEXT, $LEFT, $RIGHT)
  {
    ECHO "<DIV style='position:absolute;left:" . $LEFT . "px;right:" . $RIGHT . "px;border-style:solid;border-width:1px;
                      border-color:black;text-align:left;color:#000000;background-color:#FFCC33'>
          &nbsp;= <B>$TEXT</B> =
          </DIV><BR>
         ";
  }

$ISLOGGEDIN = isLoggedIn_Simple();

include "http://www.drumsofsummer.com/a_leftside.php?login=$ISLOGGEDIN";
include "http://www.drumsofsummer.com/a_top.php?login=$ISLOGGEDIN";
include "http://www.drumsofsummer.com/a_broadcast.php?text=$TEXT";
greyBar("<B>Thank you for your support!</B>");

beginContentBox();
dividingBar("Recent News", 20, 20);
include "http://www.drumsofsummer.com/a_news.php?max=4";
endContentBox();

?>

</HTML>