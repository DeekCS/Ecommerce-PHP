<?php
session_start();
//try {
//    $db = new PDO('mysql:host=localhost;dbname=php', 'root', '');
//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//    echo "Connection failed: " . $e->getMessage();
//}

function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'admin';
    $DATABASE_NAME = 'php';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $e) {
        // If there is an error with the connection, stop the script and display the error.
        echo "Connection failed: " . $e->getMessage();
    }
}