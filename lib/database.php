<?php
$hostname = "localhost";
$username = "billal";
$password = "12345";

$connector = new mysqli($hostname, $username, $password, "sikasir");
if ($connector->connect_error) {
    die("Connection failed");
}