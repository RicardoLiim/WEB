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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reservasi (nomor_pemesanan, id_tamu, nama_tamu, fasilitas, tgl_check_in, tgl_check_out, id_resepsionis, nomor_kamar, jenis_kamar) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nomor_pemesanan'], "int"),
                       GetSQLValueString($_POST['id_tamu'], "int"),
                       GetSQLValueString($_POST['nama_tamu'], "text"),
                       GetSQLValueString($_POST['fasilitas'], "text"),
                       GetSQLValueString($_POST['tgl_check_in'], "date"),
                       GetSQLValueString($_POST['tgl_check_out'], "date"),
                       GetSQLValueString($_POST['id_resepsionis'], "int"),
                       GetSQLValueString($_POST['nomor_kamar'], "int"),
                       GetSQLValueString($_POST['jenis_kamar'], "text"));

  mysql_select_db($database_reservasihotel, $reservasihotel);
  $Result1 = mysql_query($insertSQL, $reservasihotel) or die(mysql_error());

  $insertGoTo = "reservasi_sukses.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_reservasihotel, $reservasihotel);
$query_reservasi = "SELECT * FROM reservasi";
$reservasi = mysql_query($query_reservasi, $reservasihotel) or die(mysql_error());
$row_reservasi = mysql_fetch_assoc($reservasi);
$totalRows_reservasi = mysql_num_rows($reservasi);
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
      <form method="post" name="form1" id="form1">
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="379" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Nomor_pemesanan:</td>
            <td><input name="nomor_pemesanan" type="text" value="" size="32" required="required" readonly="readonly" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Id_tamu:</td>
            <td><input type="text" name="id_tamu" value="" size="32" required="required" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Nama_tamu:</td>
            <td><input type="text" name="nama_tamu" value="" size="32" required="required" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Fasilitas:</td>
            <td valign="baseline"><table width="110">
              <tr>
                <td><input type="radio" name="fasilitas" value="AC" checked="checked" />
                  AC</td>
              </tr>
              <tr>
                <td><input name="fasilitas" type="radio" required="required" value="TV" checked="checked" />
                  TV</td>
              </tr>
              <tr>
                <td><input name="fasilitas" type="radio" value="WIFI" checked="checked" />
                  WIFI</td>
              </tr>
              <tr>
                <td><input name="fasilitas" type="radio" value="KULKAS" checked="checked" />
                  KULKAS</td>
              </tr>
            </table></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Tgl_check_in:</td>
            <td><input type="date" name="tgl_check_in" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Tgl_check_out:</td>
            <td><input type="date" name="tgl_check_out" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Id_resepsionis:</td>
            <td><input type="text" name="id_resepsionis" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Nomor_kamar:</td>
            <td valign="baseline"><table>
              <tr>
                <td><input type="radio" name="nomor_kamar" value="10" />
                  10</td>
              </tr>
              <tr>
                <td><input type="radio" name="nomor_kamar" value="11" />
                  11</td>
              </tr>
              <tr>
                <td><input type="radio" name="nomor_kamar" value="12" />
                  12</td>
              </tr>
              <tr>
                <td><input type="radio" name="nomor_kamar" value="13" />
                  13</td>
              </tr>
              <tr>
                <td><input type="radio" name="nomor_kamar" value="14" />
                  14</td>
              </tr>
              <tr>
                <td><input type="radio" name="nomor_kamar" value="15" />
                  15</td>
              </tr>
            </table></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Jenis_kamar:</td>
            <td valign="baseline"><table>
              <tr>
                <td><input type="radio" name="jenis_kamar" value="300.000" />
                  Simple(300.000)</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kamar" value="500.000" />
                  Deluxe(500.000)</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kamar" value="700.000" />
                  Luxury(700.000)</td>
              </tr>
            </table></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insert record" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
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
mysql_free_result($reservasi);

mysql_free_result($reservasi);
?>
