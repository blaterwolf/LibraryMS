<?php
$connection = sqlsrv_connect($server, $connectionInfo);
$query = "EXEC SP_Get_Books_Archive";
$statement = sqlsrv_prepare($connection, $query);
$result = sqlsrv_execute($statement);
$rowCount = 1;

while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
        if ($key == 'ISBN') {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Book_Name') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Book_Author') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Category_Name') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Book_Status') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Book_Copies_Current') {
            echo "<td>" . $value . "</td>";
        } else if ($key == 'Book_Copies_Actual') {
            echo "<td>" . $value . "</td>";
        }
        if ($rowCount == count($row)) {
            echo "</tr>";
        }
        $rowCount++;
    }
}