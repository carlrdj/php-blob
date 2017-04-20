<?php
$dbHost = 'localhost';
$dbName = 'cursophp';
$dbUser = 'root';
$dbPassword = '';
try{	
	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=UTF8","$dbUser","$dbPassword");
	$pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch (Exception $e){
	echo $e -> getMessage();
}
