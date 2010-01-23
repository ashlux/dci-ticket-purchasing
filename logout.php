<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

include "layout.inc";
include "vars.inc";

generateGenericLayout($dblogin, $dbpass, $db, "<B>Logoff!</B>");
beginContentBox();

// delete cookies
setcookie("id", "", time() - 3600 * 24);
setcookie("username", "", time() - 3600 * 24);
setcookie("auth", "", time() - 3600 * 24);

ECHO "You have been logged off.  Thank you!";

endContentBox();

?>