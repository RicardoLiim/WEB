<?php require_once('Connections/reservasihotel.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_reservasihotel, $reservasihotel);
$query_loginresepsionis = "SELECT * FROM resepsionis";
$loginresepsionis = mysql_query($query_loginresepsionis, $reservasihotel) or die(mysql_error());
$row_loginresepsionis = mysql_fetch_assoc($loginresepsionis);
$totalRows_loginresepsionis = mysql_num_rows($loginresepsionis);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield3'])) {
  $loginUsername=$_POST['textfield3'];
  $password=$_POST['textfield3'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "homeresepsionis.php";
  $MM_redirectLoginFailed = "registrasiresepsionis.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_reservasihotel, $reservasihotel);
  
  $LoginRS__query=sprintf("SELECT username, password FROM resepsionis WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $reservasihotel) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	background-image: url(img/back.jpg);
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-size: cover;
}
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<table width="856" height="437" border="0" align="center">
  <tr>
    <td width="138"><img src="img/logo.png" width="130" height="73" /></td>
    <td colspan="2"><ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="#" class="MenuBarItemSubmenu">Login</a>
        <ul>
          <li><a href="logintamu.php">Login User</a></li>
          <li><a href="loginadmin.php">Login Admin</a></li>
          <li><a href="loginresepsionis.php">Login Resepsionis</a></li>
        </ul>
      </li>
    </ul></td>
  </tr>
  <tr>
    <td height="356" colspan="3" bgcolor="#333333"><form id="form4" name="form4" method="POST" action="<?php echo $loginFormAction; ?>">
      <table width="200" border="1" align="center">
        <tr>
          <td colspan="2" align="center">Login Resepsionis</td>
        </tr>
        <tr>
          <td width="163">Username</td>
          <td width="21"><label for="textfield4"></label>
            <input type="text" name="textfield3" id="textfield4" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><label for="textfield5"></label>
            <input type="password" name="textfield3" id="textfield5" /></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="button2" id="button2" value="Submit" /></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($loginresepsionis);
?>
