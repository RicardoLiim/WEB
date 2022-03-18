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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE kamar SET jenis_kamar=%s, harga=%s, jenis_kasur=%s WHERE nomor_kamar=%s",
                       GetSQLValueString($_POST['jenis_kamar'], "text"),
                       GetSQLValueString($_POST['harga'], "text"),
                       GetSQLValueString($_POST['jenis_kasur'], "text"),
                       GetSQLValueString($_POST['nomor_kamar'], "int"));

  mysql_select_db($database_reservasihotel, $reservasihotel);
  $Result1 = mysql_query($updateSQL, $reservasihotel) or die(mysql_error());

  $updateGoTo = "kamartampil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_editkamar = 10;
$pageNum_editkamar = 0;
if (isset($_GET['pageNum_editkamar'])) {
  $pageNum_editkamar = $_GET['pageNum_editkamar'];
}
$startRow_editkamar = $pageNum_editkamar * $maxRows_editkamar;

$colname_editkamar = "-1";
if (isset($_GET['nomor'])) {
  $colname_editkamar = $_GET['nomor'];
}
mysql_select_db($database_reservasihotel, $reservasihotel);
$query_editkamar = sprintf("SELECT * FROM kamar WHERE nomor_kamar = %s", GetSQLValueString($colname_editkamar, "int"));
$query_limit_editkamar = sprintf("%s LIMIT %d, %d", $query_editkamar, $startRow_editkamar, $maxRows_editkamar);
$editkamar = mysql_query($query_limit_editkamar, $reservasihotel) or die(mysql_error());
$row_editkamar = mysql_fetch_assoc($editkamar);

if (isset($_GET['totalRows_editkamar'])) {
  $totalRows_editkamar = $_GET['totalRows_editkamar'];
} else {
  $all_editkamar = mysql_query($query_editkamar);
  $totalRows_editkamar = mysql_num_rows($all_editkamar);
}
$totalPages_editkamar = ceil($totalRows_editkamar/$maxRows_editkamar)-1;
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
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Nomor_kamar:</td>
            <td><?php echo $row_editkamar['nomor_kamar']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Jenis_kamar:</td>
            <td><input type="text" name="jenis_kamar" value="<?php echo htmlentities($row_editkamar['jenis_kamar'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Harga:</td>
            <td><input type="text" name="harga" value="<?php echo htmlentities($row_editkamar['harga'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Jenis_kasur:</td>
            <td><input type="text" name="jenis_kasur" value="<?php echo htmlentities($row_editkamar['jenis_kasur'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Update record" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="nomor_kamar" value="<?php echo $row_editkamar['nomor_kamar']; ?>" />
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
mysql_free_result($editkamar);
?>
