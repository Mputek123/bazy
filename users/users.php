<!DOCTYPE html>
<html lang="en">
<?php
// Dołącz nagłówek HTTP, ten co zawsze z pliku 'inc/header.php'
require_once '../inc/header.php';
// Dołącz moje funkcje z pliku 'inc/funkcje.php'
require_once '../inc/funkcje.php';

$act = isset ( $_REQUEST ['act'] ) ? $_REQUEST ['act'] : null;
$id = isset ( $_REQUEST ['id'] ) ? $_REQUEST ['id'] : null;
$conn = connect ();

if ($act == 'del' && $id) {
	del_user ( $conn, $id );
	header ( 'Location: users.php' );
}
echo '<body>';
echo '<div class="container">';
echo '<table class="table table-hover table-striped">';
echo '<thead>';
echo '<tr>';
echo '<th>Login</th>';
echo '<th>Akcje</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
// Nawiąż połączenie z bazą
// Pobierz listę użytkowników z bazy
$result = get_users ( $conn );

// Dopóki jest kolejny wiersz w wyniku
while ( $row = mysqli_fetch_array ( $result ) ) {
	// Dodaj na stronę kod HTML - wiersz/komórka z loginem
	echo '<tr><td>' . $row [1] . '</td><td><a class="btn btn-danger" href="users.php?act=del&id=' . $row [0] . '">Usuń</a> <a class="btn btn-warning" href="user_password.php?id=' . $row [0] . '">Zmień hasło</a></td></tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</body>';
?>
</html>