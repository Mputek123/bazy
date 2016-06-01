<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malgorzata Putek</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/my.css">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
  </head>
  <body>
 <?php

include("loguj.php");
/* zapytanie do konkretnej tabeli */
$sql_query = 'select a13.imie.imie, a13.nazwisko.nazwisko,  a13.ulica.ulica, a13.miasto.miasto, a13.kod.kod, 
a13.stanowisko.stanowisko, a13.komorka.komorka from a13.pracownik
inner join a13.imie on a13.pracownik.imie_id = a13.imie.id
inner join a13.nazwisko on a13.pracownik.nazwisko_id = a13.nazwisko.id
inner join a13.ulica on a13.pracownik.ulica_id = a13.ulica.id
inner join a13.miasto on a13.pracownik.miasto_id = a13.miasto.id
inner join a13.kod on a13.pracownik.kod_id = a13.kod.id
inner join a13.stanowisko on a13.pracownik.stanowisko_id = a13.stanowisko.id
inner join a13.komorka on a13.pracownik.komorka_id = a13.komorka.id
group by komorka, nazwisko;';
$wynik = mysql_query($sql_query )
or die('Błąd zapytania');
print ('<div class="container">
        <div class="jumbotron text-center">
            <p class="bg-primary ">LISTA PRACOWNIKÓW</p>
        </div>');
print ('<table class="table">

</table>');
//print ('<table class="table table-hover">
 
//</table>');	 

/*
wyświetlamy wyniki, sprawdzamy,
czy zapytanie zwróciło wartość większą od 0
*/

if(mysql_num_rows($wynik) > 0) {
    /* jeżeli wynik jest pozytywny, to wyświetlamy dane */
    echo "<table class table>";
	echo "<tehead>";
	echo "<tr class=bg-primary>";
	echo "<th>Pracownik</th>";
	echo "<th>Adres</th>";
	echo "<th>Stanowisko</th>";
    while($r = mysql_fetch_array($wynik)) {
        echo "<tr >";
        echo "<td>".$r['imie'].'<br>'.$r['nazwisko']."</td>";
		echo "<td>".$r['miasto']. ', '.$r['kod']. '<br>'.$r['ulica']."</td>";
		echo "<td>".$r['stanowisko']."</td>";
	//	echo "<td> </td>";
        echo "</tr>";
    }
    echo "</table>";
}
mysql_close($polacz);
?> 
  </body>
</html>
