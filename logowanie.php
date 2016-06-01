<!DOCTYPE html>
<html lang="en">
<?php
// Dołącz nagłówek HTTP, ten co zawsze z pliku 'inc/header.php'
require_once 'inc/header.php';
// Dołącz moje funkcje z pliku 'inc/funkcje.php'
require_once 'inc/funkcje.php';

error_log ( $_REQUEST ['login'] );
if ($_REQUEST ['login'] && $_REQUEST ['password']) {
	if (login ( $_REQUEST ['login'], $_REQUEST ['password'], connect () )) {
		header ( 'Location: users/users.php' );
	}
}
?>
<body>
    <div class="container">
        <form method="post" action="logowanie.php">
            <div class="text-center">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label class="control-label">Login</label>
                            <input class="form-control text-center" name="login">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hasło</label>
                            <input type="password" class="form-control text-center" name="password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Zaloguj</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>