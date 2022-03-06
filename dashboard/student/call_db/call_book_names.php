<div class="mb-3 col-sm">
    <label for="book_name" class="form-label">What book will you borrow?</label>
    <input autocomplete="off" name="book_name" class="form-control" list="category-options" id="book_name"
        placeholder="Search Books...">
    <datalist id="category-options">
        <?php
        // EXEC R_Get_Book_Categories;
        $connection = sqlsrv_connect($server, $connectionInfo);
        $query = "EXEC R_Get_Available_Books;";
        $statement = sqlsrv_prepare($connection, $query);
        $result = sqlsrv_execute($statement);
        $rowCount = 1;

        while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
            foreach ($row as $key => $value) {
                if ($key == 'Book_Name') {
                    echo "<option value='" . $value . "'>";
                }
            }
        }

        ?>
    </datalist>
</div>