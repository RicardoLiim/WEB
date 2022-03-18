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

$maxRows_kamartampil = 10;
$pageNum_kamartampil = 0;
if (isset($_GET['pageNum_kamartampil'])) {
  $pageNum_kamartampil = $_GET['pageNum_kamartampil'];
}
$startRow_kamartampil = $pageNum_kamartampil * $maxRows_kamartampil;

mysql_select_db($database_reservasihotel, $reservasihotel);
$query_kamartampil = "SELECT * FROM kamar";
$query_limit_kamartampil = sprintf("%s LIMIT %d, %d", $query_kamartampil, $startRow_kamartampil, $maxRows_kamartampil);
$kamartampil = mysql_query($query_limit_kamartampil, $reservasihotel) or die(mysql_error());
$row_kamartampil = mysql_fetch_assoc($kamartampil);

if (isset($_GET['totalRows_kamartampil'])) {
  $totalRows_kamartampil = $_GET['totalRows_kamartampil'];
} else {
  $all_kamartampil = mysql_query($query_kamartampil);
  $totalRows_kamartampil = mysql_num_rows($all_kamartampil);
}
$totalPages_kamartampil = ceil($totalRows_kamartampil/$maxRows_kamartampil)-1;
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
</head>

<body>
<table width="856" height="437" border="0" align="center">
  <tr>
    <td width="138"><img src="img/logo.png" width="130" height="73" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="356" colspan="3">&nbsp;
      <table border="1">
        <tr>
          <td>nomor_kamar</td>
          <td>jenis_kamar</td>
          <td>harga</td>
          <td>jenis_kasur</td>
          <td colspan="3">Tools</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_kamartampil['nomor_kamar']; ?></td>
            <td><?php echo $row_kamartampil['jenis_kamar']; ?></td>
            <td><?php echo $row_kamartampil['harga']; ?></td>
            <td><?php echo $row_kamartampil['jenis_kasur']; ?></td>
            <td><a href="tambahkamar.php">Add</a></td>
            <td><a href="editkamar.php?nomor=<?php echo $row_kamartampil['nomor_kamar']; ?>">edit</a></td>
            <td><a href="hapuskamar.php?nomor=<?php echo $row_kamartampil['nomor_kamar']; ?>">hapus</a></td>
          </tr>
          <?php } while ($row_kamartampil = mysql_fetch_assoc($kamartampil)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($kamartampil);
?>
