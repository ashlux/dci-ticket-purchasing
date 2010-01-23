<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

function displayLoginForm($Username, $Password, $Ref)
{
  ECHO "<form action=login.php method=post>
        Username: <input type=text name=Username value='$Username'><BR>
        Password: <input type=password name=Password value='$Password'><BR>
        <input type=hidden name=ref value=$Ref>
        <input type=hidden name=in value='yes'>
        <input type=Submit value='Login'><BR>
        </form>";

  ECHO "<P><a href='newuser.php'>New User Registration</a> * <a href='resetpw.php'>Frogotten Password/Username</a><BR>";
}

function badPasswordUsernameCombination()
{
  Echo "<ul>Our records show this username/password combination is invalid.  Either the username does not exist, or the password is incorrect.  Password and usernames are NOT case sensitive.<BR>
        </ul>";
}

$in = $_POST['in'];
$ref      = $_POST['ref'];
if ($ref == "") $ref = $_GET['ref'];

if ($in != "yes")
{
  if ($ref != "")
    ECHO "<P><B>You must be logged in to use this feature.  Please login and you will be forwarded to your previous page.</B><BR>";
  displayLoginForm("", "", $ref);
  exit;
}


// ----------------------------------------------------------------------- //


$dblogin = "drums";
$dbpass  = "##############";
$database = "ticketdb";

$Username = trim(strtoupper($_POST['Username']));
$Password = trim(strtoupper($_POST['Password']));

mysql_connect(localhost, $dblogin, $dbpass);
@mysql_select_db($database) or die("Unable to select database");

$query = "SELECT CustomerID, Username, Password FROM customers WHERE Username = '$Username'";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

if (mysql_numrows($result) == 0)
{
  badPasswordUsernameCombination();
  displayLoginForm($Username, "", $ref);
  mysql_close();
  exit;
}

$storedPassword = mysql_result($result, 0, "Password");
$CustomerID = mysql_result($result, 0, "CustomerID");

if ($storedPassword != $Password)
{
  badPasswordUsernameCombination();
  displayLoginForm($Username, "", $ref);
  mysql_close();
  exit;
}

srand((double)microtime()*1000000);
$authcode = rand(0,2000000);

$query = "UPDATE customers SET Auth = $authcode WHERE CustomerID = $CustomerID";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

$time = time() + 3600 * 24;   // 24 hours, 1 day
setcookie("id", $CustomerID, $time);  // $_COOKIE["id"]
setcookie("username", $Username, $time); // $_COOKIE["username"]
setcookie("auth", $authcode, $time);  // $_COOKIE["auth"]

// to display all cookies, use print_r($_COOKIE)

mysql_close();

if ($ref != "")
{
  header("Location:$ref");
  ECHO "<B>Successful Login!</B><BR>";
  ECHO "<P>You should be redirected to your previous page in 5 seconds.  If you are not, please <a href=$ref>click here</a>.<BR>";
  exit;
}
else
{
  header('Location:php-menu.php');
  ECHO "<B>Successful Login!</B><BR>";
  ECHO "<P>You should be directed to the menu in 5 seconds.  If you are not, please <a href='php-menu.php'>click here</a>.<BR>";
}

?>