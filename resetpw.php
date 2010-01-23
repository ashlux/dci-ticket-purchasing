<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

function displayEmailForm()
{
  ECHO "Can't remember your username or password?  No problem, just let us know your Email and we'll email you your username and password.<BR>

        <P><form action=resetpw.php method=post>
        Email: <input type=text name=Email><BR>
        <input type=Submit><BR>
        </form>";
}

$Email = trim($_POST['Email']);
if ($Email == "")
{
  displayEmailForm();
  ECHO "!";
  exit;
}

$dblogin = "drums";
$dbpass  = "############";
$database = "ticketdb";

$Email = trim(strtoupper($_POST['Email']));

mysql_connect(localhost, $dblogin, $dbpass);
@mysql_select_db($database) or die("Unable to select database");

$query = "SELECT * FROM customers WHERE Email = '$Email'";
$result = mysql_query($query);

if (mysql_numrows($result) == 0)
{
  ECHO "The email address $Email is not in our records.  Try and create a new account.";
  exit;
}

$Username = mysql_result($result, 0, "Username");
$Password = mysql_result($result, 0, "Password");

$subject = "Drums of Summer Lost Password/Username";
$body = "Someone has sent a request for your password and username to be emailed to you.\n\n\t\tUSERNAME: $Username\n\t\tPASSWORD: $Password\n";

mail($Email, $subject, $body, "From: reset@DrumsOfSummer.com\nX-Mailer: PHP 4.x");

ECHO "Your username and password will be emailed to you shortly.<BR>";

?>