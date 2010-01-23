<? 

$dblogin = "drums";
$dbpass  = "############";

$FName = "Ashley";
$LName = "Lux";
$MName = "Ryan";
$Address1 = "124 W. Jefferson Pl.";
$Address2 = "";
$City = "Broken Arrow";
$State = "OK";
$Zip = "74011";
$Phone1 = "918-455-5684";
$Phone2 = "918-740-6663";
$Email = "ashlux@gmail.com";
$Username = "ashlux";
$Password = "###########";

mysql_connect(localhost, $dblogin, $dbpass);
@mysql_select_db($database) or die("Unable to select database");

$query = "INSERT INTO customers VALUES ('', '$FName', '$LName', '$LName', '$Address1',          
                                        '$Address2', '$City', '$State', '$Zip', '$Phone1', 
                                        '$Phone2', '$Email', '$Username', '$Password')";
mysql_query($query);