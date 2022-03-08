<div class="mb-3 col-sm">
    <label for="book_category" class="form-label">Category</label>
    <input value="<?= $book_category ?>" name="category" autocomplete="off" class="form-control" list="category-options"
        id="book_category" placeholder="Search Category...">
    <datalist id="category-options">
        <?php
        $connection = sqlsrv_connect($server, $connectionInfo);
        $query = "EXEC R_Get_Book_Categories";
        $statement = sqlsrv_prepare($connection, $query);
        $result = sqlsrv_execute($statement);

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