<!DOCTYPE html>
<html lang="en">
<?php
// Dołącz nagłówek HTTP, ten co zawsze z pliku 'inc/header.php'
require_once '../inc/header.php';
// Dołącz moje funkcje z pliku 'inc/funkcje.php'
require_once '../inc/funkcje.php';

// Połącz z bazą danych
$conn = connect ();
// Pobierz kod akcji do wykonania np. user_password.php?act=change
$act = isset ( $_REQUEST ['act'] ) ? $_REQUEST ['act'] : null;
// Pobierz identyfikator użtkownika np. user_password.php?id=1
$id = isset ( $_REQUEST ['id'] ) ? $_REQUEST ['id'] : null;
//  Pobierz hasło i powtórzenie hasła
$password = isset ( $_REQUEST ['password'] ) ? $_REQUEST ['password'] : null;
$password_repeat = isset ( $_REQUEST ['password_repeat'] ) ? $_REQUEST ['password_repeat'] : null;

// Jeśli identifikator akcji jest 'change', wykonaj
if ($act == 'change') {
	// Zmień hasło
	$result = change_password ( $conn, $id, $password, $password_repeat );
	if ($result != 1) {
		header ( 'Location: user_password.php?id=' . $id . '&err=' . $result );
	} else {
		header ( 'Location: user_password.php?id=' . $id . '&ok' );
	}
}

echo '<body>';
echo '<div class="container">';
if (isset ( $_REQUEST ['ok'] )) {
	echo '<div class="alert alert-success">Hasło użytkownika ' . get_login ( $conn, $id ) . ' zostało zmienione</div>';
} else if (isset ( $_REQUEST ['err'] )) {
	echo '<div class="alert alert-danger">Błąd zmiany hasła</div>';
}
echo '<form class="form" method="post" action="user_password.php">';
echo '<input type="hidden" name="id" value="' . $id . '">';
echo '<input type="hidden" name="act" value="change">';
echo '<div class="row">';
echo '<div class="col-md-6">';
echo '<div class="form-group">';
echo '<label class="control-label">Login</label>';
echo '<p class="form-control-static">' . get_login ( $conn, $id ) . '</p>';
echo '</div>';
echo '<div class="form-group">';
echo '<label class="control-label">Hasło</label>';
echo '<input class="form-control" type="password" name="password">';
echo '</div>';
echo '<div class="form-group">';
echo '<label class="control-label">Powtórz hasło</label>';
echo '<input class="form-control" type="password" name="password_repeat">';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<div class="row">';
echo '<div class="col-md-6">';
echo '<button class="btn btn-danger">Zmień hasło</button>';
echo '<a class="btn btn-default" href="users.php">Anuluj</a>';
echo '</div>';
echo '</div>';
echo '</form>';
echo '</div>';
echo '</body>';
?>
</html>