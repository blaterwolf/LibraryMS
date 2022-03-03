<?php
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC R_Get_Find_Borrow";
$statement = sqlsrv_prepare($connection, $query);
$result = sqlsrv_execute($statement);
$rowCount = 1;



while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
        if ($key == 'Book') {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Student') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Status') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Borrow Date') {
            echo "<td>" . $value->format('Y-m-d H:i') . "</td>";
        }
        if ($rowCount == count($row)) {
            echo "</tr>";
        }
        $rowCount++;
    }
}