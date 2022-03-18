<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_reservasihotel = "localhost";
$database_reservasihotel = "reservasihotel";
$username_reservasihotel = "root";
$password_reservasihotel = "";
$reservasihotel = mysql_pconnect($hostname_reservasihotel, $username_reservasihotel, $password_reservasihotel) or trigger_error(mysql_error(),E_USER_ERROR); 
?>