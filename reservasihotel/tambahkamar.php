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
  $insertSQL = sprintf("INSERT INTO kamar (nomor_kamar, jenis_kamar, harga, jenis_kasur) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nomor_kamar'], "int"),
                       GetSQLValueString($_POST['jenis_kamar'], "text"),
                       GetSQLValueString($_POST['harga'], "text"),
                       GetSQLValueString($_POST['jenis_kasur'], "text"));

  mysql_select_db($database_reservasihotel, $reservasihotel);
  $Result1 = mysql_query($insertSQL, $reservasihotel) or die(mysql_error());

  $insertGoTo = "kamartampil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_reservasihotel, $reservasihotel);
$query_tambahkamar = "SELECT * FROM kamar";
$tambahkamar = mysql_query($query_tambahkamar, $reservasihotel) or die(mysql_error());
$row_tambahkamar = mysql_fetch_assoc($tambahkamar);
$totalRows_tambahkamar = mysql_num_rows($tambahkamar);
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
    <td height="356" colspan="3"><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table align="center">
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Nomor_kamar:</td>
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
            <td align="right" valign="middle" nowrap="nowrap">Jenis_kamar:</td>
            <td valign="baseline"><table>
              <tr>
                <td><input type="radio" name="jenis_kamar" value="simple" />
                  Simple</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kamar" value="deluxe" />
                  Deluxe</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kamar" value="luxury" />
                  Luxury</td>
              </tr>
            </table></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Harga:</td>
            <td valign="baseline"><table>
              <tr>
                <td><input type="radio" name="harga" value="300.000" />
                  Simple(300.000)</td>
              </tr>
              <tr>
                <td><input type="radio" name="harga" value="500.000" />
                  Deluxe(500.000)</td>
              </tr>
              <tr>
                <td><input type="radio" name="harga" value="700.000" />
                  Luxury(700.000)</td>
              </tr>
            </table></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Jenis_kasur:</td>
            <td valign="baseline"><table>
              <tr>
                <td><input type="radio" name="jenis_kasur" value="single" />
                  Single</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kasur" value="double" />
                  double</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kasur" value="king" />
                  King</td>
              </tr>
              <tr>
                <td><input type="radio" name="jenis_kasur" value="" />
                  button1</td>
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($tambahkamar);
?>
