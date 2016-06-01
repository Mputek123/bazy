<?php
function connect() {
	$conn = mysqli_connect ( 'studium.pc.pl', 'a13', 'bazy100', 'a13' );
	
	if (! $conn) {
		die ( 'Database connection error' );
	}
	
	mysqli_query ( $conn, 'SET character_set_results_utf8' );
	mysqli_query ( $conn, 'SET NAMES utf8' );
	
	return $conn;
}
function login($username, $password, $conn) {
	session_start ();
	
	if (isset ( $_SESSION ['username'] )) {
		return $_SESSION ['username'];
	} else {
		$result = mysqli_query ( $conn, 'select login from user where login="' . $username . '" and haslo=MD5("' . $password . '")' );
		
		if ($result) {
			$_SESSION ['username'] = mysqli_fetch_array ( $result ) [0];
			
			return $_SESSION ['username'];
		} else {
			$_SESSION ['username'] = null;
		}
		
		return null;
	}
}
function get_users($conn) {
	session_start ();
	
	if (isset ( $_SESSION ['username'] )) {
		return mysqli_query ( $conn, 'select id,login from user' );
	} else {
		return null;
	}
}
function get_login($conn, $id) {
	session_start ();
	
	if (isset ( $_SESSION ['username'] )) {
		$result = mysqli_query ( $conn, 'select login from user where id=' . $id );
		
		return mysqli_fetch_array ( $result ) [0];
	}
}
function change_password($conn, $id, $password, $password_repeat) {
	session_start ();
	
	if (isset ( $_SESSION ['username'] )) {
		if ($password == '') {
			return 'PASSWORD_SHORT';
		}
		if ($password != $password_repeat) {
			return 'PASSWORD_MISMATCH';
		}
		mysqli_query ( $conn, 'update user set haslo=MD5(' . $password . ') where id=' . $id );
		
		return mysqli_affected_rows ( $conn );
	}
	
	return null;
}
function del_user($conn, $id) {
	session_start ();
	
	if (isset ( $_SESSION ['username'] )) {
		mysqli_query ( $conn, 'delete from user where id=' . $id );
		
		return mysqli_affected_rows ( $conn );
	}
	
	return null;
}

?>
