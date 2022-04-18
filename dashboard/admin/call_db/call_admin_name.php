<?php
$params = array(&$_SESSION['admin_login']['admin_id']);
$connection = sqlsrv_connect($server, $connectionInfo);
$query = 'EXEC R_Get_Admin_Name_For_Display @AdminID = ?;';
$statement = sqlsrv_prepare($connection, $query, $params);
$result = sqlsrv_execute($statement);
$row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
$g_admin_name = $result ? $row['AdminName'] : '';