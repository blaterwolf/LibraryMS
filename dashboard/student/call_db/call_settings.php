<?php

// autofill the forms with the current student information in the database
$params = array(&$_SESSION['student_login']['student_id']);
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC R_Get_Stud_Info_For_Settings @StudID = ?;";
$statement = sqlsrv_prepare($connection, $query, $params);
$result = sqlsrv_execute($statement);
$row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
if ($result) {
    $r_student_number = $row['Student_Number'];
    $r_student_name = $row['Student_Name'];
    $r_student_email = $row['Student_Email'];
}