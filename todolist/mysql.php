<?php
ini_set('display_errors', 0);
$conn = mysqli_connect('localhost', 'root', '');
mysqli_select_db($conn, 'volga');
mysqli_query($conn, "/*!40101 SET NAMES 'utf8' */");

$sess = get_session();