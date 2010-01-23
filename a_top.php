<?php

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

$ISLOGGEDIN_SIMPLE = $_GET['login'];

ECHO "

<DIV style='position:absolute;left:5px;top:5px;border-style:none;width:209;height:50'><a href='http://www.drumsofsummer.com/'><img src='http://www.drumsofsummer.com/img/dos-logo1-sm.gif' WIDTH=209 HEIGHT=50 BORDER=0></a></DIV>\n

    ";

ECHO "<DIV style='position:absolute;right:5px;top:5px;height:50;border-style:none'><BR>\n";
if ($ISLOGGEDIN_SIMPLE == "true")
  ECHO "<a href='http://www.drumsofsummer.com/logout.php'>Logout</a>";
else
  ECHO "<a href='http://www.drumsofsummer.com/login.php'>Login</a>";
include 'http://www.drumsofsummer.com/a_menu.php?action=top';
ECHO "</DIV>\n";

?>
