<?php
$connection = sqlsrv_connect($server, $connectionInfo);
$query = 'EXEC R_Get_All_Admin;';
$statement = sqlsrv_prepare($connection, $query);
$result = sqlsrv_execute($statement);
$rowCount = 1;

while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
        if ($key == 'AdminName') {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
        } else if ($key == 'AdminUsername') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'CreateDate') {
            echo "<td>" . $value->format('Y-m-d H:i') . "</td>";
        } else if ($key == 'ModifiedDate') {
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