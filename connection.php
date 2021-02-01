<?php

$servername='localhost';
$username='root';
$password='';
$dbname='vamsiminiorange';

// below line is used to connect the database

$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
	die(' Could not able connect mysql:' .mysql_error());
}

?>