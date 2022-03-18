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

if ((isset($_GET['nomor'])) && ($_GET['nomor'] != "")) {
  $deleteSQL = sprintf("DELETE FROM kamar WHERE nomor_kamar=%s",
                       GetSQLValueString($_GET['nomor'], "int"));

  mysql_select_db($database_reservasihotel, $reservasihotel);
  $Result1 = mysql_query($deleteSQL, $reservasihotel) or die(mysql_error());

  $deleteGoTo = "kamartampil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_hapuskamar = 10;
$pageNum_hapuskamar = 0;
if (isset($_GET['pageNum_hapuskamar'])) {
  $pageNum_hapuskamar = $_GET['pageNum_hapuskamar'];
}
$startRow_hapuskamar = $pageNum_hapuskamar * $maxRows_hapuskamar;

$colname_hapuskamar = "-1";
if (isset($_GET['nomor'])) {
  $colname_hapuskamar = $_GET['nomor'];
}
mysql_select_db($database_reservasihotel, $reservasihotel);
$query_hapuskamar = sprintf("SELECT * FROM kamar WHERE nomor_kamar = %s", GetSQLValueString($colname_hapuskamar, "int"));
$query_limit_hapuskamar = sprintf("%s LIMIT %d, %d", $query_hapuskamar, $startRow_hapuskamar, $maxRows_hapuskamar);
$hapuskamar = mysql_query($query_limit_hapuskamar, $reservasihotel) or die(mysql_error());
$row_hapuskamar = mysql_fetch_assoc($hapuskamar);

if (isset($_GET['totalRows_hapuskamar'])) {
  $totalRows_hapuskamar = $_GET['totalRows_hapuskamar'];
} else {
  $all_hapuskamar = mysql_query($query_hapuskamar);
  $totalRows_hapuskamar = mysql_num_rows($all_hapuskamar);
}
$totalPages_hapuskamar = ceil($totalRows_hapuskamar/$maxRows_hapuskamar)-1;
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
    <td><ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="#" class="MenuBarItemSubmenu">Login</a>
        <ul>
          <li><a href="logintamu.php">LoginUser</a></li>
          <li><a href="#">LoginResepsionis</a></li>
          <li><a href="loginadmin.php">LoginAdmin</a></li>
        </ul>
      </li>
    </ul></td>
    <td><a href="registrasiuser.php">REGISTRASI</a></td>
  </tr>
  <tr>
    <td height="356" colspan="3">&nbsp;
      <form method="post" name="form2" id="form2">
        <input type="hidden" name="nomor_kamar" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<form method="post" name="form1" id="form1">
</form>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($hapuskamar);

mysql_free_result($editkamar);
?>
