<?php
	function connect() {
		$conn=mysqli_connect('localhost', 'php', 'php', 'bazy');
		
		if(!$conn) {
			die('Database connection error');
		}
		
		return $conn;
	}
	
	function login($username,$password,$conn) {
		$result=mysqli_query($conn,'select username from users where username="'.$username.'" and passwd=MD5("'.$password.'")');
		
		if($result) {
			return mysqli_fetch_array($result)[0];
		}
	}
?>
