<?php

$dsn = "mysql:host=localhost;dbname=bibliotheque;charset=UTF8";
$username = 'root';
$password = '';
$db = 'bibliotheque';
try {
    $conn = new PDO($dsn, $username, $password);

    if ($conn) {
        "Connected to the $db database successfully!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>