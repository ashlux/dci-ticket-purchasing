<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

$ISLOGGEDIN_SIMPLE = $_GET['login'];

ECHO "<DIV style='position:absolute;left:5px;width:200px;top:80px;border-style:solid;
                  border-width:1px;border-color:black;text-align:center;
                  background-color:#000000;height:700px;overflow:visible'>";
ECHO "<DIV style='position:absolute;left:10px;width:190px;top:0px;border-style:none;
                  border-width:0px;text-align:left;background-color:#000000;height:700px'>";
ECHO "<BR>";

if ($ISLOGGEDIN_SIMPLE == "true")
  ECHO "<a href='http://www.drumsofsummer.com/logout.php' class='sidemenu'><B>Logout</B></a><BR><BR>";
else
  ECHO "<a href='http://www.drumsofsummer.com/login.php' class='sidemenu'><B>Login</B></a><BR><BR>";

include 'http://www.drumsofsummer.com/a_menu.php?action=side';

// include 'http://www.drumsofsummer.com/a_ads.php?action=side';

ECHO "</DIV></DIV>";

?>