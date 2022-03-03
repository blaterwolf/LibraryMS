<div class="mb-3">
    <label for="category-list" class="form-label">Category</label>
    <input name="Category" class="form-control" list="category-options" id="category-list"
        placeholder="Search Category...">
    <datalist id="category-options">
        <?php
        // EXEC R_Get_Book_Categories;
        $connection = sqlsrv_connect($server, $connectionInfo);
        $query = "EXEC R_Get_Book_Categories";
        $statement = sqlsrv_prepare($connection, $query);
        $result = sqlsrv_execute($statement);
        $rowCount = 1;

        while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
            foreach ($row as $key => $value) {
                if ($key == 'Category') {
                    echo "<option value='" . $value . "'>";
                }
            }
        }

        ?>
    </datalist>
</div>