<?php 
session_start();

$hostName = 'http://localhost/php/news';
$basePath = $_SERVER['DOCUMENT_ROOT'].'/php/news';

// Database Connection

$conn = mysqli_connect('localhost','root','B@$!tmy$qll!te3','news') or die('Connection Failed : ' .mysqli_connect_error());
 ?>