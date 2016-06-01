<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Malgorzata Putek</title>
<!-- Zakomentowany CSS z foundation bo przeszkadza i gryzie się z Bootstrapem, używamy albo Foundation albo Bootstrap -->
<!-- <link rel="stylesheet" href="css/foundation.css"> -->
<link rel="stylesheet" href="css/my.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />

<!-- Nadajemy własne style dla tabelki z raportem -->
<style type="text/css">
/* Wszystko poniżej dotyczy elementów w tabelce o klasie 'report'*/

/* Wiersze o klasie 'data' w niej komórki = białe tło i brak górnej ramki */
table.report tr.data td {
	background-color: #fff;
	border-top: none;
    font-size: 14pt;
}

/* Wiersze o klasie data mają czarną ramkę z dołu*/
table.report tr.data {
	border-bottom: 2px solid #000;
}

/* Wiersze o klasie 'header' mają szare tło i czarną ramkę od dołu*/
table.report tr.header {
	background-color: #f1f1f1;
	border-bottom: 2px solid #000;
}

/* Elementy TH w wierszu o klasie 'header' nie mają ramki i mają wiekszą czcionkę */
table.report tr.header th {
	border: none;
	font-size: 16pt;
}

/* Paragraf w numerze strony ma szare tło i wysokość 20px
musi być nadana wysokość, bo span z numerem strony o klasie 'pageno' (poniżej) ma float right  
*/
table.report  tr.paging p {
	background-color: #f1f1f1;
	height: 20px;
}
/* Numer strony, po prawej stronie */
.pageno {
	float: right;
}
</style>
</head>
<body>

<div class="container">
 <p></p>
  <h4>Przeszukaj dane:</h4>
<div class="row">
<div class="col-lg-6">
    <div class="input-group" >
    <form action="index.php" method="post">
      <input type="text" id="phrase" name="phrase" class="form-control" placeholder="Tutaj wpisz tekst...">
      <span class="input-group-btn">
     <input type="submit" class="btn btn-danger" class="form-control" value="Szukaj">
     
      </form>
        <p></p>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</div>


 <?php
 
	include ("loguj.php");
	
	$Search="";
//	$_POST['phrase']=trim($_POST['phrase']); 
// sprawdzenie, czy użytkownik wpisał dane
if(!empty($_POST['phrase'])) 
{
	$Search = $_POST['phrase'];
}
	/* zapytanie do konkretnej tabeli */
	$sql_query = "select a13.imie.imie, a13.nazwisko.nazwisko,  a13.ulica.ulica, a13.miasto.miasto, a13.kod.kod, 
a13.stanowisko.stanowisko, a13.komorka.komorka from a13.pracownik
inner join a13.imie on a13.pracownik.imie_id = a13.imie.id
inner join a13.nazwisko on a13.pracownik.nazwisko_id = a13.nazwisko.id
inner join a13.ulica on a13.pracownik.ulica_id = a13.ulica.id
inner join a13.miasto on a13.pracownik.miasto_id = a13.miasto.id
inner join a13.kod on a13.pracownik.kod_id = a13.kod.id
inner join a13.stanowisko on a13.pracownik.stanowisko_id = a13.stanowisko.id
inner join a13.komorka on a13.pracownik.komorka_id = a13.komorka.id
WHERE a13.nazwisko.nazwisko like '%".$Search."%' or
a13.ulica.ulica like '%".$Search."%' or
a13.miasto.miasto like '%".$Search."%' or 
a13.kod.kod like '%".$Search."%' or
a13.stanowisko.stanowisko like '%".$Search."%' or
a13.komorka.komorka like '%".$Search."%'
ORDER by komorka, nazwisko;";

	$wynik = mysql_query ( $sql_query ) or die ( 'Błąd zapytania' );
	
	print ('<div class="container">
        		<div class="panel panel-primary">
            	<div class="panel-heading text-center"><h1>LISTA PRACOWNIKÓW</h1></div></div>') ;
	
	/*
	 * wyświetlamy wyniki, sprawdzamy,
	 * czy zapytanie zwróciło wartość większą od 0
	 *
	 * Ilość wierszy dodajemy do zmiennej bo będzie potrzebne do wyświetlania numerów stron w tabelce
	 */
	$rows = mysql_num_rows ( $wynik );
	
	if ($rows > 0) {
		/* jeżeli wynik jest pozytywny, to wyświetlamy dane */
		/* Na początek tebelka o klasie report */
		echo '<table class="table report">';
		/* Nagłówek z tekstem w kolorze niebieskim */
		echo '<thead>';
		echo '<tr class="text-primary header">';
		echo '<th>Pracownik</th>';
		echo '<th>Adres</th>';
		echo '<th>Stanowisko</th>';
		echo '</tr>';
		echo '</thead>';
		// Zawartość tabelki
		echo '<tbody>';
		// Ustawiamy locale, czy sposów w jaki bedą wyświetlane daty, liczby, itp.
		setlocale ( LC_ALL, 'pl', 'pl_PL' );
		// Aktualna data w formacie polskim
		$date = strftime ( '%A %d %B %G' );
		// Określamy sobie rozmiar strony
		$pageSize = 10;
		// Ilość stron = wynik dzielenia bez reszty ilości wierszy przez rozmiar strony
		$pageCnt = intval ( $rows / $pageSize );
		// Jeśli reszta z dzielenia ilości wierszy przez rozmiar strony jest większa od 0, powiększamy ilość stron o 1
		if (fmod ( $rows, $pageSize ) > 0) {
			$pageCnt ++;
		}
		// Aktualny numer wiersza
		$idx = 0;
		// Aktualny numer strony
		$page = 0;
		// Pętla po wszystkich wierszach wyniku zapytania
		while ( $r = mysql_fetch_array ( $wynik ) ) {
			echo '<tr class="data">';
			echo '<td>' . $r ['imie'] . '<br>' . $r ['nazwisko'] . '</td>';
			echo '<td>' . $r ['miasto'] . ', ' . $r ['kod'] . '<br>' . $r ['ulica'] . '</td>';
			echo '<td>' . $r ['stanowisko'] . '</td>';
			echo '</tr>';
			// Powiększamy aktualny numer wiersza o 1
			$idx ++;
			// Jeśli reszta z dzielenia aktualnego numeru wiersza przez ilość stron jest równa 0 - mamy koniec strony
			// lub reszta z dzielenia aktualnego numeru wiersza przez ilość stron jest różna od 0 i aktualny numer wiersza jest równy ilości wszystkich wierszy - jesteśmy na końcu
			// wyświetlamy aktualny numer strony
			if (($idx % $pageSize) == 0 || (($idx % $pageSize) != 0 && $idx == $rows)) {
				// Powiększamy aktualny numer strony o 1
				$page ++;
				echo '<tr class="paging">';
				echo '<td colspan="3"><p>' . $date . '<span class="pageno">Page ' . $page . ' of ' . $pageCnt . '</span></p></td>';
				echo '</tr>';
			}
			// Jeśli reszta z dzielenia aktualnego numeru wiersza przez ilość stron jest równa 0 i aktualny numer wiersza jest mniejszy od ilości wierszy
			// Wyświetlamy nagłówek dla kolejnej strony
			if (($idx % $pageSize) == 0 && $idx < $rows) {
				echo '<tr class="text-primary header">';
				echo '<th>Pracownik</th>';
				echo '<th>Adres</th>';
				echo '<th>Stanowisko</th>';
				echo '</tr>';
			}
		}
		echo '</tbody>';
		echo '</table>';
	}
	echo '</div>';
	mysql_close ( $polacz );

	?> 
  </body>
</html>
