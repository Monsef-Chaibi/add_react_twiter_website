<?php
// connect to db
$servername = "localhost";
$username = "souqdev_wajdi";
$password = "wajdiwajdi";
$dbname = "souqdev_wajdi";
try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error  Connection" . $r;
}