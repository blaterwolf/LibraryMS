<?php
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC R_Get_Find_Student";
$statement = sqlsrv_prepare($connection, $query);
$result = sqlsrv_execute($statement);
$rowCount = 1;

while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
        if ($key == 'LRN Number') {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Name') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Email') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Status') {
            if ($value == 1) {
                echo "<td><span class='badge bg-success'>Active</span></td>";
            } else {
                echo "<td><span class='badge bg-danger'>Blocked</span></td>";
            }
        } else if ($key == 'Date Created') {
            echo "<td>" . $value->format('Y-m-d H:i') . "</td>";
        } else if ($key == 'Date Modified') {
            if ($value == null) {
                echo "<td><span class='badge bg-danger'>N/A</span></td>";
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