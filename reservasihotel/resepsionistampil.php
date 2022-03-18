<?php require_once('Connections/reservasihotel.php'); ?>
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

$maxRows_reservasitampil = 10;
$pageNum_reservasitampil = 0;
if (isset($_GET['pageNum_reservasitampil'])) {
  $pageNum_reservasitampil = $_GET['pageNum_reservasitampil'];
}
$startRow_reservasitampil = $pageNum_reservasitampil * $maxRows_reservasitampil;

mysql_select_db($database_reservasihotel, $reservasihotel);
$query_reservasitampil = "SELECT * FROM reservasi";
$query_limit_reservasitampil = sprintf("%s LIMIT %d, %d", $query_reservasitampil, $startRow_reservasitampil, $maxRows_reservasitampil);
$reservasitampil = mysql_query($query_limit_reservasitampil, $reservasihotel) or die(mysql_error());
$row_reservasitampil = mysql_fetch_assoc($reservasitampil);

if (isset($_GET['totalRows_reservasitampil'])) {
  $totalRows_reservasitampil = $_GET['totalRows_reservasitampil'];
} else {
  $all_reservasitampil = mysql_query($query_reservasitampil);
  $totalRows_reservasitampil = mysql_num_rows($all_reservasitampil);
}
$totalPages_reservasitampil = ceil($totalRows_reservasitampil/$maxRows_reservasitampil)-1;
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
    <td width="616"><ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="#">Home</a>        </li>
      <li><a href="#" class="MenuBarItemSubmenu">Reservasi</a>
        <ul>
          <li><a href="reservasicarinama.php">CariNama</a></li>
          <li><a href="reservasicaricheck.php">CariCheckIN</a></li>
        </ul>
      </li>
    </ul></td>
    <td width="88">&nbsp;</td>
  </tr>
  <tr>
    <td height="356" colspan="3">&nbsp;
      <table border="1">
        <tr>
          <td>nomor_pemesanan</td>
          <td>id_tamu</td>
          <td>nama_tamu</td>
          <td>fasilitas</td>
          <td>tgl_check_in</td>
          <td>tgl_check_out</td>
          <td>id_resepsionis</td>
          <td>nomor_kamar</td>
          <td>jenis_kamar</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_reservasitampil['nomor_pemesanan']; ?></td>
            <td><?php echo $row_reservasitampil['id_tamu']; ?></td>
            <td><?php echo $row_reservasitampil['nama_tamu']; ?></td>
            <td><?php echo $row_reservasitampil['fasilitas']; ?></td>
            <td><?php echo $row_reservasitampil['tgl_check_in']; ?></td>
            <td><?php echo $row_reservasitampil['tgl_check_out']; ?></td>
            <td><?php echo $row_reservasitampil['id_resepsionis']; ?></td>
            <td><?php echo $row_reservasitampil['nomor_kamar']; ?></td>
            <td><?php echo $row_reservasitampil['jenis_kamar']; ?></td>
          </tr>
          <?php } while ($row_reservasitampil = mysql_fetch_assoc($reservasitampil)); ?>
    </table></td>
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
mysql_free_result($reservasitampil);
?>
