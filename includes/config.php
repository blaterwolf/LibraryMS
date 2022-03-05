<?php
// DB credentials.
$server = 'NITRO5-ANGELO\SQLEXPRESS';
$user = 'angelo';
$password = 'admin';
$database = 'LibraryMS';

$connectionInfo = array("Database" => $database);

function generateID()
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, 36);
}

// Establish database connection.


// $connection = odbc_connect("Server=$server;Database=$database;", $user, $password);
// $dbh = new PDO("sqlsrv:Server=" . DB_HOST . ";Database=" . DB_NAME, DB_USER, DB_PASS);