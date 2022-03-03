<?php
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC R_Get_Find_Book";
$statement = sqlsrv_prepare($connection, $query);
$result = sqlsrv_execute($statement);
$rowCount = 1;

while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
        if ($key == 'ISBN') {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Name') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Author') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Description') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Category') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Status') {
            echo "<td>" . $value . "</td>";
        }
        if ($rowCount == count($row)) {
            echo "</tr>";
        }
        $rowCount++;
    }
}