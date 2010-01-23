<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

include "layout.inc";

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

function displayNewUserForm($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, $Email, $Username, $Password)
{
  $INPUTSIZE = 45;
  ECHO "<form action=newuser.php method=post>
    <table border=0 cellpadding=0 cellspacing=0 align=LEFT>
    <TR>
        <TD align=RIGHT width=150><B>First Name*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=FName value='$FName' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Last Name*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=LName value='$LName' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Middle Name:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=MName value='$MName' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Address*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Address1 value='$Address1' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Address2 value='$Address2' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>City*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT>    <input type=text name=City value='$City' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>State*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=State value='$State' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Zip*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Zip value='$Zip' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>First Phone*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Phone1 value='$Phone1' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Second Phone:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Phone2 value='$Phone2' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Email*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Email value='$Email' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Desired Username*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Username value='$Username' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Password*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=password name=Password value='$Password' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Verify Password*:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=password name=VerifyPassword size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD></TD>
        <TD></TD>
        <TD align=RIGHT><input type=Submit value='Create New Account'></TD>
    </TR>
    </table>
    <input type=hidden name=ref value=ref>
    </form>";
}

function verifyData($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, $Email, $Username, $Password)
{
  $error_msg = "There were ERRORS in the input data :<BR><ul>";
  $errors_found = false;

  if ($FName == "") { $error_msg .= "<li>The FIRST NAME field is required.<BR>";
    $errors_found = true; }
  if ($LName == "") { $error_msg .= "<li>The LAST NAME field is required.<BR>";
    $errors_found = true; }
  if ($Address1 == "") { $error_msg .= "<li>The ADDRESS 1 field is required.<BR>";
    $errors_found = true; }
  if ($City == "") { $error_msg .= "<li>The CITY field is required.<BR>";
    $errors_found = true; }
  if ($State == "")  {    $error_msg .= "<li>The STATE field is required.<BR>";
    $errors_found = true;  }
  if ($Zip == "")  {    $error_msg .= "<li>The ZIP field is required.<BR>";
    $errors_found = true;  }
  if ($Phone1 == "")  {    $error_msg .= "<li>The PHONE NUMBER 1 field is required.<BR>";
    $errors_found = true;  }
  if ($Email == "")  {    $error_msg .= "<li>The EMAIL field is required.<BR>";
    $errors_found = true;  }
  if ($Username == "")  {    $error_msg .= "<li>The USER NAME field is required.<BR>";
    $errors_found = true;  }
  if ($Password == "")  {    $error_msg .= "<li>The PASSWORD field is required.<BR>";
    $errors_found = true;  }

  $error_msg .= "</ul>";

  if ($errors_found == true)
  {
    ECHO "$error_msg";
    displayNewUserForm($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, $Email, $Username, "");
    exit;
  }

}


// ------------------------------------------- //


include "vars.inc";
generateGenericLayout($dblogin, $dbpass, $db, "<B>New User Registration Form</B>");
beginContentBox();


$ref = $_POST['ref'];
if ($ref != 'ref')
{
  displayNewUserForm("", "", "", "", "", "", "", "", "", "", "", "");
  endContentBox();
  exit;
}

$FName    = trim($_POST['FName']);
$LName    = trim($_POST['LName']);
$MName    = trim($_POST['MName']);
$Address1 = trim($_POST['Address1']);
$Address2 = trim($_POST['Address2']);
$City     = trim($_POST['City']);
$State    = trim($_POST['State']);
$Zip      = trim($_POST['Zip']);
$Phone1   = trim($_POST['Phone1']);
$Phone2   = trim($_POST['Phone2']);
$Email    = trim($_POST['Email']);
$Username = trim(strtoupper($_POST['Username']));
$Password = trim(strtoupper($_POST['Password']));
$PasswordVerify = trim(strtoupper($_POST['VerifyPassword']));

verifyData($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, $Email, $Username, $Password);

mysql_connect(localhost, $dblogin, $dbpass);
@mysql_select_db($database) or die("Unable to select database");

$query = "SELECT CustomerID, Username FROM customers WHERE Username = '$Username'";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

if (mysql_numrows($result) >= 1)
{
  $conflict_CustomerID = mysql_result($result, 0, "CustomerID");
  ECHO "<B>ERROR</B>: Username $Username is already claimed by customer ID $conflict_CustomerID";
  displayNewUserForm($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, $Email, "", "");
  endContentBox();
  exit;
}

$query = "SELECT CustomerID, Email FROM customers WHERE Email = '$Email'";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
if (mysql_numrows($result) >= 1)
{
  $conflict_CustomerID = mysql_result($result, 0, "CustomerID");
  ECHO "<B>ERROR</B>: Email $Email is already being used by customer ID $conflict_CustomerID";
  displayNewUserForm($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, "", "", "");
  endContentBox();
  exit;
}

if ($Password != $PasswordVerify)
{
  ECHO "<B>ERROR</B>: PASSWORD and PASSWORD VERIFY fields do NOT match.  Make sure you 
        typed the exact same password for each field.  Passwords are NOT case sensitive.";
  displayNewUserForm($FName, $LName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $phone2, $Email, $Username, "");
  endContentBox();
  exit;
}

$query = "INSERT INTO customers VALUES ('', '$FName', '$LName', '$MName', '$Address1',          
                                        '$Address2', '$City', '$State', '$Zip', '$Phone1', 
                                        '$Phone2', '$Email', '$Username', '$Password', 'N', '0')";
$result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

mysql_close();

ECHO "New user created.  An email will be sent informing you of your new account.<BR>

<ul>
  <B>NAME:</B> $LName, $FName $MName<BR>
  <B>ADDRESS 1:</B> $Address1<BR>
  <B>ADDRESS 2:</B> $Address2<BR>
  <B>CITY:</B> $City<BR>
  <B>STATE:</B> $State<BR>
  <B>ZIP:</B> $Zip<BR>
  <B>PHONE 1:</B> $Phone1<BR>
  <B>PHONE 2:</B> $Phone2<BR>
  <B>EMAIL:</B> $Email<BR>
  <B>USERNAME: </B> $Username<BR>
  <B>PASSWORD: </B> [Hidden, Check Email]<BR>
</ul>

Thank you!";

$subject = "Drums Of Summer Registration";
$body    = "Thank you for registering for an account on DrumsOfSummer.com.  Your registration information is: \n";
$body   .= "\n\tNAME\n\t\t$LName, $FName $MName\n";
$body   .= "\tADDRESS:\n";
$body   .= "\t\t$Address1\n";
if ($Address2 != "") { $body .= "\t\t$Addres2\n"; }
$body   .= "\t\t$City, $State $Zip\n";
$body   .= "\tPHONE:\n\t\t$Phone1\n";
if ($phone2 != "") { $body .= "\t\t$Phone2 (secondary)\n"; }
$body   .= "\tEMAIL:\n\t\t$Email\n";
$body   .= "\tUSERNAME:\n\t\t$Username\n";
$body   .= "\tPASSWORD:\n\t\t$Password\n";
$body   .= "\nIf you have any questions, please contact drumsofsummer@gmail.com or visit DrumsOfSummer.com.\n";

mail($Email, $subject, $body, "From: accounts@drumsofsummer.com\nX-Mailer: PHP 4.x");

ECHO "<P>You must now login:<BR>";

displayLoginForm($Username, "", "");

  endContentBox();

?>