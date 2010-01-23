<?php

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

  function displaySideMenu($dblogin, $dbpass, $db)
  {

    ECHO "<STYLE type='text/css'>
          <! --
            a:hover {text-decoration: none; background:#000000; color: #FFFF33}
            a:visited:hover {text-decoration: none; background:#000000; color: #FFFF33}

            a.sidemenu:link {text-decoration: underline; background=#000000; color: #FFFFFF}
            a.sidemenu:active {text-decoration: underline; background=#000000; color: #FFFFFF}
            a.sidemenu:visited {text-decoration: underline; background=#000000; color: #FFFFFF}
            a.sidemenu:hover {text-decoration: underline; background:#000000; color: #FFFF33}
            a.sidemenu:visited:hover {text-decoration: none; background:#000000; color: #FFFF33}
          -->
          </STYLE>";

    mysql_connect(localhost, $dblogin, $dbpass);
    @mysql_select_db($db) or die("Unable to select database.");
    
    $query = "SELECT * FROM menuItems WHERE Active = 'Y' and Side = 'Y' ORDER BY SideOrder ASC";
    $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

    mysql_close();

    for ($i = 0; $i < mysql_numrows($result); $i++)
    {
      $Text = mysql_result($result, $i, 'Text');
      $Link = mysql_result($result, $i, 'Link');
     
      ECHO "<a href='$Link' class='sidemenu'><B>$Text</B></a><BR>";
    }
  }

  function displayTopMenu($dblogin, $dbpass, $db)
  {

    mysql_connect(localhost, $dblogin, $dbpass);
    @mysql_select_db($db) or die("Unable to select database.");
    
    $query = "SELECT * FROM menuItems WHERE Active = 'Y' and Top = 'Y' ORDER BY TopOrder ASC";
    $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

    mysql_close();

    for ($i = 0; $i < mysql_numrows($result); $i++)
    {
      $Text = mysql_result($result, $i, 'Text');
      $Link = mysql_result($result, $i, 'Link');
     
      ECHO " * <a href='$Link'>$Text</a>";
    }
  }


$dblogin = 'drums';
$dbpass  = '############';
$db      = 'ticketdb';

$ACTION = trim(strtoupper($_GET['action']));
if ($ACTION == "")
  $ACTION = trim(strtoupper($_POST['action']));

if ($ACTION == "TOP")
{
  displayTopMenu($dblogin, $dbpass, $db);
  exit;
}
elseif ($ACTION == "SIDE")
{
  displaySideMenu($dblogin, $dbpass, $db);
  exit;
}
else
{
  ECHO "<B>Error displaying menu</B><BR>";
  exit;
}

?>