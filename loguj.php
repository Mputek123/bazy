<?php
$baza = 'a13';

$serwer = 'studium.pc.pl';
$login = 'a13';
$haslo = 'bazy100';

// $serwer = 'localhost';
// $login = 'root';
// $haslo = '';

$polacz = @mysql_connect ( $serwer, $login, $haslo, $baza );
if (! $polacz) {
	die ( 'Could not connect: ' . mysql_error () );
}
// echo 'Connected successfully';

mysql_query ( "SET character_set_results_utf8", $polacz );
mysql_query ( "SET NAMES utf8", $polacz );

$db = @mysql_select_db ( $baza, $polacz );
?>
  