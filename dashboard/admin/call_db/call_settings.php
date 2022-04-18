<?php

// autofill the forms with the current librarian information in the database
$params = array(&$_SESSION['admin_login']['admin_id']);
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC R_Get_Admin_Info_For_Settings @AdminID = ?;";
$statement = sqlsrv_prepare($connection, $query, $params);
$result = sqlsrv_execute($statement);
$row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
if ($result) {
    $_SESSION['admin_id'] = $row['AdminID'];
    $r_admin_name = $row['AdminName'];
    $r_admin_username = $row['AdminUsername'];
}