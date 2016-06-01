<?php
$serwer='studium.pc.pl';
	$login='a13';
	$haslo='bazy100';
	$baza='a13';
	
	$polacz=@mysql_connect($serwer, $login, $haslo, $baza);
	if (!$polacz) {
		die('Could not connect: ' . mysql_error());
	}
//	echo 'Connected successfully';
	
	mysql_query("SET character_set_results_utf8", $polacz);
	mysql_query("SET NAMES utf8", $polacz);
	
	$db = @mysql_select_db($baza, $polacz);

 $query = "SELECT * FROM user";

$polacz = mysql_query($query);
if (!$polacz) {
    echo " Nie można wykonać kwerendy: $query";
    trigger_error(mysql_error()); 
} else

print('<form><select size="20" style="width:200px">');
while ($row = mysql_fetch_assoc($polacz)) {
	print('<option value ="');
	print($row['login']);
	print('">');
	print($row['login']);
	print('</option>');	
	    //echo $row['id'] . " " . $row['login'] . " "  . "\n";
}
print('</select></form>');
mysql_close();
?>
