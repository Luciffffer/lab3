<?php
	// vul je eigen gegevens in
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
	define("DB_DATABASE", "spotify");

	$pdo = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE . ';', DB_USER, DB_PASSWORD);
	
?>