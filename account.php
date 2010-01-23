<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

include "layout.inc";

function checkLoginCookies($dblogin, $dbpass, $db)
{
  $CustomerID = $_COOKIE["id"];
  $Username   = trim(strtoupper($_COOKIE["username"]));
  $Auth       = trim(strtoupper($_COOKIE["auth"]));

  if ($CustomerID == "" || $Username == "" || $Auth == "")
  {
    header('Location:login.php?ref=account.php');
    generateGenericLayout($dblogin, $dbpass, $db, "<B>Account Settings</B>");
    beginContentBox();
    ECHO "You must be logged in.  If you are not forwarded to the login page in 5 seconds, please <a href=login.php?ref=checkout.php>click here</a>.<BR>";
    endContentBox();
    exit;
  }

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($db) or die("Unable to select database");
  
  $query = "SELECT * FROM customers WHERE CustomerID = $CustomerID and Username = '$Username' and Auth = '$Auth'";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  if (mysql_numrows($result) == 0)
  {
    header('Location:login.php?ref=checkout.php');
    ECHO "You must be logged in.  If you are not forwarded to the login page in 5 seconds, please <a href=login.php?ref=checkout.php>click here</a>.<BR>";
    exit;
  }

  mysql_close();

  return array(mysql_result($result, 0, "CustomerID"), 
               mysql_result($result, 0, "FName"),
               mysql_result($result, 0, "LName"),
               mysql_result($result, 0, "MName"),
               mysql_result($result, 0, "Address1"),
               mysql_result($result, 0, "Address2"),
               mysql_result($result, 0, "City"),
               mysql_result($result, 0, "State"),
               mysql_result($result, 0, "Zip"),
               mysql_result($result, 0, "Phone1"),
               mysql_result($result, 0, "Phone2"),
               mysql_result($result, 0, "Email"),
               mysql_result($result, 0, "Username"),
               mysql_result($result, 0, "Password")
              );
}

function displayAccountInfo($CustomerID, $FName, $LName, $MName, $Address1, $Address2, $City, $State, $Zip, $Phone1, $Phone2, $Email, $Username, $Password)
{
  $INPUTSIZE = 45;
  ECHO "

    <form action=account.php method=post>
    <table border=0 cellpadding=0 cellspacing=0 align=LEFT>
    <TR>
        <TD align=RIGHT width=150><B>First Name:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=FName value='$FName' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Last Name:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=LName value='$LName' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Middle Name:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=MName value='$MName' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Address:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Address1 value='$Address1' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Address2 value='$Address2' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>City:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT>    <input type=text name=City value='$City' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>State:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=State value='$State' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Zip:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Zip value='$Zip' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>First Phone:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Phone1 value='$Phone1' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Second Phone:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Phone2 value='$Phone2' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Username:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Username value='$Username' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>Email:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=text name=Email value='$Email' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD></TD>
        <TD></TD>
        <TD align=RIGHT><input type=Submit value='Update Account'></TD>
    </TR>
    </table>
    <input type=hidden name=action value=update>
    </form>
";

ECHO "
    <form action=account.php method=post>
    <P><BR><table border=0 cellpadding=0 cellspacing=0 align=LEFT>
    <TR>
        <TD align=RIGHT><B>Current Password:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=password name=Password value='$Password' size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>New Password:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=password name=NewPassword size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD align=RIGHT><B>New Password Verify:</B></TD>
        <TD width=10><font color=#FFFFFF>.</font></TD>
        <TD align=LEFT><input type=password name=NewPasswordVerify size=$INPUTSIZE><BR></TD>
    </TR>
    <TR>
        <TD></TD>
        <TD></TD>
        <TD align=RIGHT><input type=Submit value='Change Password'></TD>
    </TR>
    </table>
    <input type=hidden name=action value=newpass>
    </form>
";
}

function updateData($CustomerID, $FName, $NewFName, $LName, $NewLName, $MName, $NewMName, $Address1, $NewAddress1, $Address2, $NewAddress2, $City, $NewCity, $State, $NewState, $Zip, $NewZip, $Phone1, $NewPhone1, $Phone2, $NewPhone2, $Email, $NewEmail, $Username, $NewUsername, $dblogin, $dbpass, $database)
{
  ECHO "<ul>";
  if ($NewFName == "")
  {
    ECHO "<li>Error updating first name, field must not be empty.";
    $NewFName = $FName;
  }
  
  if ($NewLName == "")
  {
    ECHO "<li>Error updating last name, field must not be empty.";
    $NewLName = $LName;
  }

  if ($NewAddress1 == "")
  {
    ECHO "<li>Error updating address (line one), field must not be empty.  Address (line two) will not be updated either.";
    $NewAddress1 = $Address1;
    $NewAddress2 = $Address2;
  }

  if ($NewCity == "")
  {
    ECHO "<li>Error updating city, field must not be empty.";
    $NewCity = $City;
  }

  if ($NewState == "")
  {
    ECHO "<li>Error updating state, field must not be empty.";
    $NewState = $State;
  }

  if ($NewZip == "")
  {
    ECHO "<li>Error updating zip code, field must not be empty.";
    $NewZip = $Zip;
  }

  if ($NewPhone1 == "")
  {
    ECHO "<li>Error updating phone number (primary), field must not be empty.";
    $NewPhone1 = $Phone1;
  }

  if ($NewPhone2 == "")
  {
    ECHO "<li>Warning updating phone number (secondary), field is empty.  Although it is not required, was this intentional?  If you have no secondary phone number, disregard this warning.";
    $NewPhone2 = $Phone2;
  }

  if ($NewEmail == "")
  {
    ECHO "<li>Error updating email address, field must not be empty.";
    $NewEmail = $Email;
  }

  if ($NewUsername == "")
  {
    ECHO "<li>Error updating username, field must not be empty.";
    $NewUsername = $Username;
  }

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($database) or die("Unable to select database.");

  if (strtoupper($Username) != strtoupper($NewUsername))
  {
    $query = "SELECT * FROM customers WHERE Username = '$NewUsername'";
    $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
    if (mysql_numrows($result) >= 1)
    {
      ECHO "<li>Error updating username, new username is already in use.";
      $NewUsername = $Username;
    }
    else
    {
      ECHO "<p><B>YOU WILL NEED TO RE-LOGIN SINCE YOU'VE MADE CHANGES TO YOUR USERNAME!</B><BR>";
    }
  }

  $query = "UPDATE customers SET FName = '$NewFName',
                                 LName = '$NewLName',
                                 MName = '$NewMName',
                                 Address1 = '$NewAddress1',
                                 Address2 = '$NewAddress2',
                                 City = '$NewCity',
                                 State = '$NewState',
                                 Zip = '$NewZip',
                                 Phone1 = '$NewPhone1',
                                 Phone2 = '$NewPhone2',
                                 Username = '$NewUsername',
                                 Email = '$NewEmail' WHERE CustomerID = $CustomerID";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());
  mysql_close();

  if ($Email != $NewEmail)
  {
    mail($Email, "Drums of Summer Your Account's Email Change", "This email is to inform you that your email in the Drums of Summer database has been changed from $Email to $NewEmail.  If this is invalid, or the change is without your authorization, let us know by emailing accounts@DrumsOfSummer.com.\n\nThank you.", "From: accounts@drumsofsummer.com\nX-Mailer: PHP 4.x");
  }

  $body = "This email is to inform you of changes to your Drums of Summer Account.  Please review these changes and inform us if any are incorrect or were made without your authorization.\n\n";
  $body   .= "\n\tNAME\n\t\t$LName, $FName $MName\n";
  $body   .= "\tADDRESS:\n";
  $body   .= "\t\t$Address1\n";
  if ($Address2 != "") { $body .= "\t\t$Addres2\n"; }
  $body   .= "\t\t$City, $State $Zip\n";
  $body   .= "\tPHONE:\n\t\t$Phone1\n";
  if ($phone2 != "") { $body .= "\t\t$Phone2 (secondary)\n"; }
  $body   .= "\tEMAIL:\n\t\t$Email\n";
  $body   .= "\tUSERNAME:\n\t\t$Username\n";
  $body   .= "\nIf you have any questions, please contact accounts@drumsofsummer.com or visit DrumsOfSummer.com.\n";

  mail($Email, "Drums of Summer Account Update", $body, "From: accounts@drumsofsummer.com\nX-Mailer: PHP 4.x");
  
}




function newPassword($CustomerID, $Email, $Password, $OldPassword, $NewPassword, 
                     $NewPasswordVerify, $dblogin, $dbpass, $database)
{  
  if ($OldPassword != $Password)
  {
    ECHO "<B>Invalid Password</B>: Cannot update your password.<BR><P>";
    return;
  }

  if ($NewPassword != $NewPasswordVerify)
  {
    ECHO "<B>NEW PASSWORD NOT VALID</B>: New Password and New Password Verify must match.  These passwords are not case sensitive.<BR><P>";

    ECHO "$NewPassword ... $NewPasswordVerify";
    return;
  }

  if ($NewPassword == "")
  {
    ECHO "<B>NULL PASSWORD</B>: Password must not be empty, please enter a password!<BR><P>";
    return;
  }

  mysql_connect(localhost, $dblogin, $dbpass);
  @mysql_select_db($database) or die("Unable to select database");
  
  $query = "UPDATE customers SET Password = '$NewPassword' WHERE CustomerID = $CustomerID";
  $result = mysql_query($query) or die("Query failed:<BR>$query<BR>Error: " . mysql_error());

  mysql_close();

  ECHO "<B>PASSWORD UPDATE SUCCESSFUL</B><BR><P>";

  mail($Email, "Drums Of Summer Password Change", "Your password on DrumsOfSummer.com has been changed.  The new password is: $NewPassword.  If you did not authorize this change, let us know!", "From: accounts@drumsofsummer.com\nX-Mailer: PHP 4.x");

  if (strtoupper($Username) != strtoupper($NewUsername))
  {
    return false;
  }

  return true;

}

// ----------------------------------------------------- //

include "vars.inc";

list ($CustomerID,
      $FName,
      $LName, 
      $MName,
      $Address1,
      $Address2,
      $City,
      $State,
      $Zip,
      $Phone1,
      $Phone2,
      $Email,
      $Username,
      $Password) = checkLoginCookies($dblogin, $dbpass, $database);


$action = $_POST['action'];

if ($action != "update" && $action != "newpass")
{
  generateGenericLayout($dblogin, $dbpass, $db, "<B>Now you can pick out your own seats!</B>");
  beginContentBox();
  displayAccountInfo($CustomerID, $FName, $LName, $MName, $Address1,
                   $Address2, $City, $State, $Zip, $Phone1, $Phone2,
                   $Email, $Username, "");
  endContentBox();
  exit;
}

if ($action == "newpass")
{
  generateGenericLayout($dblogin, $dbpass, $db, "<B>Account Settings</B>");
  beginContentBox();
  $OldPassword = trim(strtoupper($_POST['Password']));
  $NewPassword = trim(strtoupper($_POST['NewPassword']));
  $NewPasswordVerify = trim(strtoupper($_POST['NewPasswordVerify']));

  newPassword($CustomerID, $Email, $Password, $OldPassword, $NewPassword,   
              $NewPasswordVerify, $dblogin, $dbpass, $database);
  displayAccountInfo($CustomerID, $FName, $LName, $MName, $Address1,
                   $Address2, $City, $State, $Zip, $Phone1, $Phone2,
                   $Email, $Username, "");
  endContentBox();
  exit;
}

if ($action == "update")
{
  
  $NewFName    = trim($_POST['FName']);
  $NewLName    = trim($_POST['LName']);
  $NewMName    = trim($_POST['MName']);
  $NewAddress1 = trim($_POST['Address1']);
  $NewAddress2 = trim($_POST['Address2']);
  $NewCity     = trim($_POST['City']);
  $NewState    = trim($_POST['State']);
  $NewZip      = trim($_POST['Zip']);
  $NewPhone1   = trim($_POST['Phone1']);
  $NewPhone2   = trim($_POST['Phone2']);
  $NewEmail    = trim($_POST['Email']);
  $NewUsername = trim($_POST['Username']);

  if (updateData($CustomerID, $FName, $NewFName, $LName, $NewLName, $MName, $NewMName, $Address1, $NewAddress1, $Address2, $NewAddress2, $City, $NewCity, $State, $NewState, $Zip, $NewZip, $Phone1, $NewPhone1, $Phone2, $NewPhone2, $Email, $NewEmail, $Username, $NewUsername, $dblogin, $dbpass, $database))
  {
    generateGenericLayout($dblogin, $dbpass, $db, "<B>Account Settings</B>");
    beginContentBox();
    displayAccountInfo($CustomerID, $FName, $LName, $MName, $Address1,
                       $Address2, $City, $State, $Zip, $Phone1, $Phone2,
                       $Email, $Username, "");  
    endContentBox();
  }
  exit;
}

?>