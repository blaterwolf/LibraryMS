<?php
$params = array(&$current_student);
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC R_Transaction_History @StudNum = ?;";
$statement = sqlsrv_prepare($connection, $query, $params);
$result = sqlsrv_execute($statement);
$rowCount = 1;

while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
        if ($key == 'Book Borrowed') {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Student Name') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Number of Copies') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Status') {
            if ($value == 1) {
                echo "<td><span class='badge bg-success'>Returned</span></td>";
            } else {
                echo "<td><span class='badge bg-info text-dark'>Borrowed</span></td>";
            }
        } else if ($key == 'Borrow Date') {
            echo "<td>" . $value->format('Y-m-d H:i') . "</td>";
        } else if ($key == 'Return Date') {
            if ($value == null) {
                echo "<td><span class='badge bg-warning text-dark'>Not Yet Returned</span></td>";
            } else {
                echo "<td>" . $value->format('Y-m-d H:i') . "</td>";
            }
        }
        if ($rowCount == count($row)) {
            echo "</tr>";
        }
        $rowCount++;
    }
}