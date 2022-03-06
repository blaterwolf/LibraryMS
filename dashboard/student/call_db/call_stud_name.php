<?php
$params = array(&$current_student);
$connection = sqlsrv_connect($server, $connectionInfo);
$query = 'EXEC R_Get_Stud_Name_For_Display @StudNum = ?;';
$statement = sqlsrv_prepare($connection, $query, $params);
$result = sqlsrv_execute($statement);
$row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
$g_student_name = $result ? $row['Student_Name'] : 'Error';